<?php

/**
 * This is the model class for table "{{memosku}}".
 *
 * The followings are the available columns in table '{{memosku}}':
 * @property integer $idmemosku
 * @property integer $idmemo
 * @property integer $idsku
 * @property integer $qty
 * @property integer $type
 * @property string $cdate
 * @property string $mdate
 */
class Memosku extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Memosku the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{memosku}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmemo, idsku, type', 'required'),
			array('idmemo, idsku, qty, type', 'numerical', 'integerOnly'=>true),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmemosku, idmemo, idsku, qty, type, cdate, mdate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
                    'idmemo0' => array(self::BELONGS_TO, 'Memo', 'idmemo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmemosku' => 'Idmemosku',
			'idmemo' => 'Idmemo',
			'idsku' => 'Sku #',
			'qty' => 'Qty',
			'type' => 'Type',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idmemosku',$this->idmemosku);
		$criteria->compare('idmemo',$this->idmemo);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('type',$this->type);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * behaviors expressed by the model
         */
        public function behaviors()
	{
	    return array(
	        'CTimestampBehavior' => array(
	            'class' => 'zii.behaviors.CTimestampBehavior',
	            'createAttribute' => 'cdate',
	            'updateAttribute' => 'mdate',
	            'setUpdateOnCreate' => true,
	        ),
	    );
	}
        
        public function codify($sku) {
            $this->idsku = Sku::model()->findByAttributes(array( 'skucode' => trim($sku) ))->idsku;
            return $this;
        } 
        
        public function returned(){
            $this->type = 2;
            return $this;
        }
        
        public function getMetalwt($wt){
            if(isset($this->idmemo0->idmetalm) && ($this->idmemo0->idmetalm) && $this->idsku0->skumetals[0]->idmetal0->idmetalm0->name != $this->idmemo0->idmetalm){
                $percent = Memo::metalConversionArray()[$this->idsku0->skumetals[0]->idmetal0->idmetalm0->name][$this->idmemo0->metalm->name];
                if(isset($percent)){
                    $wt += $wt * $percent;
                }
            }
           
            return round($wt, 5);
        }
        
        public function saveSkus($post, $memo){
            $skus = explode(',', $post['Memosku']['idsku']); 
            foreach ($skus as $k=>$sku){
                if (empty(trim($sku)) || !trim($sku)){
                    unset($skus[$k]);
                    continue;
                }
                
                if(Sku::checkSkus($sku)){
                    continue;
                }else{
                    return false;
                }
            }
            
            foreach ($skus as $sku) {
                $model = new Memosku();
                $model->idmemo = $memo->idmemo;
                $model->idsku = $sku;
                $model->type = $memo->status == 3 ? 2 : 1;
                $model->codify($sku)->save(); 
            }
            
            return true;
        }
        
        public function getSkus($idmemo, $type){
            $skus = Yii::app()->db->createCommand("select sk.skucode as skucode, sk.idsku as idsku from tbl_sku sk, tbl_memosku ms where ms.idmemo = {$idmemo} and ms.idsku = sk.idsku")->queryAll(); 
            return ($type == 1) ? implode(',',array_column($skus, 'idsku')) : implode(',',array_column($skus, 'skucode'));
        }
        
        public function getShippedqty($idmemo, $idsku){
            $model = Memosku::model()->findByAttributes(array('idmemo' => $idmemo, 'idsku' => $idsku, 'type' => 1));
            $modelreturn = Memosku::model()->findByAttributes(array('idmemo' => $idmemo, 'idsku' => $idsku, 'type' => 2));
            if($model && $modelreturn){
                return $model->qty - $modelreturn->qty;
            }else{
                return ($model) ? $model->qty : 0;
            }
        }
        
        public function updateSkuqty($idmemo, $locstocks, $type){
            foreach($locstocks as $k=>$locstock){
                $locationstock = Locationstocks::model()->findByPk($k);
                 $memosku = Memosku::model()->findByAttributes(array('idmemo' => $idmemo, 'idsku' => $locationstock->idsku));
                 
                if(isset($memosku) && isset($locationstock) && isset($locstock) && ($locstock <= ($locationstock->totqty - $locationstock->qtyship + $memosku->qty ))){
                    $locationstock->qtyship += ($locstock - $memosku->qty);
                    Memosku::updateSkumodels($locationstock, $memosku, $locstock);
                }else{
                    return false;
                }
            }
            return true;
        }
        
        public function totalstocks(){
            $locationstock = Locationstocks::model()->findByAttributes(array('idsku' => $this->idsku, 'iddept' => $this->idmemo0->iddptfrom));
            return $locationstock->totqty - $locationstock->qtyship;
        }
        
        private function updateSkumodels($locationstock, $memosku, $locstock){
            $locationstock->totwt = ($locationstock->totqty - $locationstock->qtyship) * $memosku->idsku0->grosswt;
            $locationstock->totstone = ($locationstock->totqty - $locationstock->qtyship) * $memosku->idsku0->totstowei;
            $locationstock->totmetwt = ($locationstock->totqty - $locationstock->qtyship) * $memosku->idsku0->totmetalwei;
            $locationstock->save();

            $memosku->qty = $locstock;
            $memosku->save();
        }
        
        public static function getReturnmemo($idmemosku){
            $memosku = Memosku::model()->findByPk($idmemosku);
            $returnmemo = Memosku::model()->findByAttributes(array('idsku' => $memosku->idsku, 'idmemo' => $memosku->idmemo, 'type' => 2));
            
            if(isset($returnmemo)){
                return $returnmemo;
            }else{
              $returnmemo = new Memosku;
              $returnmemo->attributes = $memosku->attributes;
              $returnmemo->qty = 0;
              $returnmemo->returned()->save();
              return $returnmemo;
            }
        }
        
        public function updateReturnSku($returnskus){
            foreach($returnskus as $k => $returnsku){
                $memosku = Memosku::model()->findByPk($k);
                $locationstock = Locationstocks::model()->findByAttributes(array('idsku' => $memosku->idsku, 'iddept' => $memosku->idmemo0->iddptfrom));
                
                if(isset($returnsku)  && isset($memosku) && ($memosku->qty >= $returnsku) && isset($locationstock)){
                    $returnmemo = Memosku::getReturnmemo($k);
                    $locationstock->qtyship -= ($returnsku - $returnmemo->qty);
                    Memosku::updateSkumodels($locationstock, $returnmemo, $returnsku);
                }else{
                    return false;
                }
            }
            
            return true;
        }
}