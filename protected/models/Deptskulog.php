<?php

/**
 * This is the model class for table "{{deptskulog}}".
 *
 * The followings are the available columns in table '{{deptskulog}}':
 * @property integer $iddeptskulog
 * @property integer $iddept
 * @property integer $idsku
 * @property integer $qty
 * @property integer $idpo
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $refrcvd
 * @property integer $refsent
 * @property integer $acknow
 *
 * The followings are the available model relations:
 * @property Dept $iddept0
 * @property Po $idpo0
 * @property Dept $refrcvd0
 * @property Dept $refsent0
 * @property Sku $idsku0
 */
class Deptskulog extends CActiveRecord
{
    
    
    
        public $skucode_search;
        public $inputfile;
    
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Deptskulog the static model class
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
		return '{{deptskulog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddept, idsku, qty', 'required'),
			array('iddept, idsku, qty, lastqty, updby, refrcvd, refsent,acknow, type, type_id, showdata', 'numerical', 'integerOnly'=>true),
            array('po_num', 'length', 'max'=>128),
			array('cdate, inputfile', 'safe'),
			array('locref', 'length', 'max'=>64),
			array('currency', 'length', 'max'=>16),
            array('pricepp', 'type', 'type'=>'float'),
            array('pricepp', 'length', 'max'=>9),
            //array('inputfile', 'file'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iddeptskulog, iddept, idsku, qty, lastqty,  po_num, locationref, currency, pricepp, cdate, mdate, updby, refrcvd, refsent,skucode_search, acknow', 'safe', 'on'=>'search'),
		);
	}
        
        /*spry behaviours*/
        public function behaviors()
	{
	    return array(
	        'CTimestampBehavior' => array(
	            'class' => 'zii.behaviors.CTimestampBehavior',
	            'createAttribute' => 'cdate',
	            'updateAttribute' => 'mdate',
	            'setUpdateOnCreate' => true,
	        ),
	        'BlameableBehavior' => array(
	            'class' => 'application.components.BlameableBehavior',
	            'createdByColumn' => 'updby', // optional
	            'updatedByColumn' => 'updby',  // optional
	        ),
	    );
	}
        
        /**
         * defining scopes for the model
         */
        public function scopes(){
            return array(
                'positived' => array(
                    'condition' => 'qty >= 0',
                ),
                
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
			'iddept0' => array(self::BELONGS_TO, 'Dept', 'iddept'),
			'refrcvd0' => array(self::BELONGS_TO, 'Dept', 'refrcvd'),
			'refsent0' => array(self::BELONGS_TO, 'Dept', 'refsent'),
			'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iddeptskulog' => 'Iddeptskulog',
			'iddept' => 'Department',
			'idsku' => 'SKU #',
			'qty' => 'Quantity',
			//'idpo' => 'IdPO',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updby',
			'refrcvd' => 'Skus Received from',
			'refsent' => 'Skus Sent to',
			'acknow' => 'Confirm',
            'locationref' => 'Location Reference',
            'currency' => 'Currency',
            'pricepp' => 'Price per piece',
            'po_num' => 'PO #',
            'inputfile'=> 'Upload File *'
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
                if(isset($_POST['Deptskulog']['iddept'])){
                    $iddept = $_POST['Deptskulog']['iddept'];
                }
                else{
                    $iddept=$this->iddept;
                }
                if(isset(Yii::app()->session['iddeptskustocks'])){
                $iddept = Yii::app()->session['iddeptskustocks'];}else{
                    $iddept='';
                }
                
                
		$criteria->compare('iddeptskulog',$this->iddeptskulog);
		$criteria->compare('iddept',$iddept);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('refrcvd',$this->refrcvd);
		$criteria->compare('refsent',$this->refsent);
                $criteria->compare('po_num', $this->po_num);
                
                $criteria->addCondition("showdata = 1");
                
                $criteria->with = array('idsku0' );
                $criteria->together = true;
                $criteria->compare( 'idsku0.skucode', $this->skucode_search, true );

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'sort'=>array(
                        'attributes'=>array(
                            'skucode_search'=>array(
                                'asc'=>'idsku0.skucode',
                                'desc'=>'idsku0.skucode DESC',
                            ),
                            '*',
                        ),
                    ),
                    'pagination'=>array(
                        'pageSize'=>50,
                    ),
		));
	}
        
        public function reverseStock(){
            if(isset($this->refrcvd) && $this->refrcvd){
                $rev_model = Deptskulog::model()->findByAttributes(array('refsent' => $this->iddept, 'iddept' => $this->refrcvd, 'idsku' => $this->idsku, 'po_num' => $this->po_num));
                $rev_model = isset($rev_model) ? $rev_model : new Deptskulog();
                
                $rev_model->attributes = $this->attributes;
                $rev_model->refsent = $this->iddept;
                $rev_model->iddept = $this->refrcvd;
                $rev_model->refrcvd = null;
                $rev_model->lastqty = $this->lastqty;
                if(Deptskulog::saverevModel($rev_model, $this)){
                    return true;
                }else{
                    return false;
                }
                
            }elseif (isset($this->refsent) && $this->refsent) {
                $rev_model = Deptskulog::model()->findByAttributes(array('refrcvd' => $this->iddept, 'iddept' => $this->refsent, 'idsku' => $this->idsku, 'po_num' => $this->po_num));
                $rev_model = isset($rev_model) ? $rev_model : new Deptskulog();
                
                $rev_model->attributes = $this->attributes;
                $rev_model->refrcvd = $this->iddept;
                $rev_model->iddept = $this->refsent;
                $rev_model->refsent = null;
                $rev_model->lastqty = $this->lastqty;
                if(Deptskulog::saverevModel($rev_model, $this)){
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function uploadreverseStock($idsku , $po_num, $qty , $price){
            if(isset($this->refrcvd) && $this->refrcvd){
                $rev_model = Deptskulog::model()->findByAttributes(array('refsent' => $this->iddept, 'iddept' => $this->refrcvd, 'idsku' => $idsku, 'po_num' => $po_num));
                $rev_model = isset($rev_model) ? $rev_model : new Deptskulog();
                $rev_model->attributes = $this->attributes;
                $rev_model->iddept = $this->refrcvd;
                $rev_model->refsent = $this->iddept;
                $rev_model->idsku = $idsku;
                $rev_model->qty = $qty;
                $rev_model->po_num = $po_num;
                $rev_model->pricepp = $price;
                $rev_model->refrcvd = null;
                $rev_model->lastqty = $this->lastqty;
                if(Deptskulog::saverevModel($rev_model, $this)){
                    return true;
                }else{
                    return false;
                }
            }elseif (isset($this->refsent) && $this->refsent) {
                $rev_model = Deptskulog::model()->findByAttributes(array('refrcvd' => $this->iddept, 'iddept' => $this->refsent, 'idsku' => $idsku, 'po_num' => $po_num));
                $rev_model = isset($rev_model) ? $rev_model : new Deptskulog();
                
                $rev_model->attributes = $this->attributes;
                $rev_model->iddept = $this->refsent;
                $rev_model->refrcvd = $this->iddept;
                $rev_model->idsku = $idsku;
                $rev_model->qty = $qty;
                $rev_model->po_num = $po_num;
                $rev_model->pricepp = $price;
                $rev_model->refsent = null;
                $rev_model->lastqty = $this->lastqty;
                if(Deptskulog::saverevModel($rev_model, $this)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        public function saverevModel($rev_model, $model){
            $rev_model->qty = $rev_model->qty * (-1);
            $rev_model->save(); 
            if($rev_model->save()){
                return true;
            }else{
                return false;
            }
        }
        
        public function uniqueField($attribute,$params){
            $count_purchase = Deptskulog::model()->countbyattributes(array('refsent' => null, 'refrcvd' => null, 'po_num' => $this->po_num));
            $count_transfer = 0;
            
            if(isset($this->refsent) && $this->refsent){
                $count_transfer += Deptskulog::model()->countbyattributes(array('refrcvd' => null, 'po_num' => $this->po_num));
            }else if(isset($this->refrcvd) && $this->refrcvd){
                $count_transfer += Deptskulog::model()->countbyattributes(array('refsent' => null, 'po_num' => $this->po_num));
            }
            
            if( ($count_purchase >= 1 && $count_transfer <= 0) || ($count_purchase <= 0 && $count_transfer > 1 ) || ($count_purchase >= 1 && $count_transfer > 1 )){
                 $this->addError($attribute, 'This po number already exits in the system');
            }
        }
        
        public function getTotalsku($po, $sku, $dept){
            $sku = Sku::model()->findByAttributes(array('skucode' => $sku));
            $sql = "SELECT sum(qty) as qty FROM `tbl_deptskulog` where idsku = ".$sku->idsku." and iddept = ".$dept." and po_num = '".$po."' and qty >= 0";
            return Yii::app()->db->createCommand($sql)->queryAll();
        }
        
        public function getShippedsku($po, $sku, $dept){
            $sku = Sku::model()->findByAttributes(array('skucode' => $sku));
            $sql = "SELECT sum(qty) as qty FROM `tbl_deptskulog` where idsku = ".$sku->idsku." and iddept = ".$dept." and po_num = '".$po."' and qty <= 0";
            return Yii::app()->db->createCommand($sql)->queryAll();
        }
        
        public function feedInvoicedata($invoice){
            $inv_skus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice' => $invoice->idinvoice, 'activ' => 1, 'movements' => 1));
            
            if(isset($inv_skus)){
                foreach($inv_skus as $inv){
                    $log = Deptskulog::model()->findByAttributes(array('iddept' => $inv->idinvoice0->idlocation, 'type' => '1', 'type_id' => $inv->idinvoiceposkus, 'refsent' => $inv->idinvoice0->deptto, 'idsku' => $inv->idsku));
                    $log = isset($log) ? $log : new Deptskulog;

                    $log->iddept = $inv->idinvoice0->idlocation;
                    $log->po_num = $inv->idinvoice0->idpo;
                    $log->type = 1;
                    $log->type_id = $inv->idinvoiceposkus;
                    $log->refsent = $inv->idinvoice0->deptto;
                    $log->idsku = $inv->idsku;
                    $log->qty = -1 * $inv->shipqty;
                    $log->save();

                    if(isset($inv->idinvoice0->deptto) && $inv->idinvoice0->deptto){
                        $log = Deptskulog::model()->findByAttributes(array('iddept' => $inv->idinvoice0->deptto, 'type' => '1', 'type_id' => $inv->idinvoiceposkus, 'refrcvd' => $inv->idinvoice0->idlocation, 'idsku' => $inv->idsku));
                        $log = isset($log) ? $log : new Deptskulog;

                        $log->iddept = $inv->idinvoice0->deptto;
                        $log->po_num = $inv->idinvoice0->idpo;
                        $log->type = 1;
                        $log->type_id = $inv->idinvoiceposkus;
                        $log->refrcvd = $inv->idinvoice0->idlocation;
                        $log->idsku = $inv->idsku;
                        $log->qty =  $inv->shipqty;
                        $log->save();
                    }
                }
            }
        }
        
        public function feedInvoicereturndata($invoice){
            $inv_rtrn = Invoicereturn::model()->findAllByAttributes(['idinvoice' => $invoice->idinvoice]);
            
            if(isset($inv_rtrn)){
                foreach($inv_rtrn as $inv){
                    $log = Deptskulog::model()->findByAttributes(array('iddept' => $inv->idinvoice0->idlocation, 'type' => '1', 'type_id' => $inv->idinvoicespokus0->idinvoiceposkus, 'refsent' => $inv->idinvoice0->deptto, 'idsku' => $inv->idinvoicespokus0->idsku));
                    
                    if(isset($log)){
                        $log->qty = -1 * ($inv->idinvoicespokus0->shipqty);
                        $log->save();
                    }
                    
                    if(isset($inv->idinvoice0->deptto) && $inv->idinvoice0->deptto){
                        $log = Deptskulog::model()->findByAttributes(array('iddept' => $inv->idinvoice0->deptto, 'type' => '1', 'type_id' => $inv->idinvoicespokus0->idinvoiceposkus, 'refrcvd' => $inv->idinvoice0->idlocation, 'idsku' => $inv->idinvoicespokus0->idsku));
                        $log->qty = $inv->idinvoicespokus0->shipqty;
                        $log->save();
                    }
                }
            }
        }
        
        public function feedMemodata($memo){
            $memoskus = Memosku::model()->findAllByAttributes(['idmemo' => $memo->idmemo, 'type' => 1]);
            
            if(isset($memoskus)){
                foreach($memoskus as $memosku){
                    $log = Deptskulog::model()->findByAttributes(array('iddept' => $memosku->idmemo0->iddptfrom, 'type' => '2', 'type_id' => $memosku->idmemo0->idmemo, 'idsku' => $memosku->idsku));
                    $log = isset($log) ? $log : new Deptskulog;
                    
                    $log->iddept = $memosku->idmemo0->iddptfrom;
                    $log->type = 2;
                    $log->type_id = $memosku->idmemo0->idmemo;
                    $log->idsku = $memosku->idsku;
                    $log->qty = -1 * $memosku->qty;
                    $log->save();
                }
            }
        }
        
        public function feedreturnMemodata($memo){
            $memoskus = Memosku::model()->findAllByAttributes(['idmemo' => $memo->idmemo, 'type' => 2]);
            
            if(isset($memoskus)){
                foreach($memoskus as $memosku){
                    $log = Deptskulog::model()->findByAttributes(array('iddept' => $memosku->idmemo0->iddptfrom, 'type' => '2', 'type_id' => $memosku->idmemo0->idmemo, 'idsku' => $memosku->idsku));
                    
                    $sku = Memosku::model()->findByAttributes(['idmemo' => $memo->idmemo, 'idsku' => $memosku->idsku, 'type' => '1']);
                    if(isset($log) && isset($sku)){
                        $log->qty = -1 * ($sku->qty - $memosku->qty);
                        $log->save();
                    }
                }
            }
        }
        
            
}
