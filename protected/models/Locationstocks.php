<?php

/**
 * This is the model class for table "{{locationstocks}}".
 *
 * The followings are the available columns in table '{{locationstocks}}':
 * @property integer $idlocationstocks
 * @property integer $idsku
 * @property integer $idpo
 * @property integer $totqty
 * @property string $totwt
 * @property string $totstone
 * @property string $totmetwt
 * @property integer $qtyship
 * @property string $locref
 * @property string $currency
 * @property string $pricepp
 * @property string $lupdated
 */
class Locationstocks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Locationstocks the static model class
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
		return '{{locationstocks}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddept', 'required'),
			array('idsku,totqty, qtyship', 'numerical', 'integerOnly'=>true),
			array('totwt, totstone, totmetwt, pricepp', 'length', 'max'=>9),
                        array('po_num', 'length', 'max'=>128),
			array('locref', 'length', 'max'=>64),
			array('currency', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idlocationstocks,item,iddept, idsku, po_num, totqty, totwt, totstone, totmetwt, qtyship, locref, currency, pricepp, lupdated', 'safe', 'on'=>'search'),
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
                     'iddept0' => array(self::BELONGS_TO, 'Dept', 'iddept'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idlocationstocks' => 'Idlocationstocks',
			'idsku' => 'Idsku',
			//'idpo' => 'Idpo',
                        'po_num' => 'PO Number',
			'totqty' => 'Totqty',
			'totwt' => 'Totwt',
			'totstone' => 'Totstone',
			'totmetwt' => 'Totmetwt',
			'qtyship' => 'Qtyship',
			'locref' => 'Locref',
			'currency' => 'Currency',
			'pricepp' => 'Pricepp',
			'lupdated' => 'Lupdated',
			'iddept' => 'Department',
                        'item' => 'Item'
		);
	}
        
         /*spry behaviours*/
        public function behaviors()
	{
	    return array(
	        'CTimestampBehavior' => array(
	            'class' => 'zii.behaviors.CTimestampBehavior',
	            'createAttribute' => 'cdate',
	            'updateAttribute' => 'lupdated',
	            'setUpdateOnCreate' => true,
	        ),
	       
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

		$criteria->compare('idlocationstocks',$this->idlocationstocks);
		$criteria->compare('idsku',$this->idsku);
		//$criteria->compare('idpo',$this->idpo);
                $criteria->compare('po_num',$this->po_num);
		$criteria->compare('totqty',$this->totqty);
		$criteria->compare('totwt',$this->totwt,true);
		$criteria->compare('totstone',$this->totstone,true);
		$criteria->compare('totmetwt',$this->totmetwt,true);
		$criteria->compare('qtyship',$this->qtyship);
		$criteria->compare('locref',$this->locref,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('pricepp',$this->pricepp,true);
		$criteria->compare('lupdated',$this->lupdated,true);
		$criteria->compare('iddept',$this->iddept,true);
		$criteria->compare('item',$this->item,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function locationUpdate($iddeptskulog, $type){
            $deptlog = Deptskulog::model()->findByPk($iddeptskulog);
            $locationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->iddept,'idsku'=>$deptlog->idsku));

            if(!isset($locationstock->idlocationstocks)){$locationstock = new Locationstocks;} 

            $locationstock->iddept = $deptlog->iddept;
            $locationstock->idsku = $deptlog->idsku;
            
            if(isset($deptlog->refsent) && $deptlog->refsent){
                $locationstock->totqty = $locationstock->totqty - (((-1 * $deptlog->qty) - ($deptlog->lastqty * -1))*$type);
                $locationstock->qtyship = $locationstock->qtyship + $deptlog->qty;
                $locationstock = Locationstocks::updateValues($locationstock, $deptlog);
                $locationstock->save();
                
                $locationstock->reverseUpdate($deptlog, $type);
            }
            
            if((isset($deptlog->refrcvd) && $deptlog->refrcvd) || (!isset($deptlog->refrcvd) && !isset($deptlog->refsent))){
                $locationstock->totqty = $locationstock->totqty + ((($deptlog->qty) - ($deptlog->lastqty))*$type);
                $locationstock = Locationstocks::updateValues($locationstock, $deptlog);
                $locationstock->save();
                
                if((isset($deptlog->refrcvd) && $deptlog->refrcvd)){
                    $locationstock->reverseUpdate($deptlog, $type);
                }
            }
        }
       
        
        public function reverseUpdate($deptlog, $type){
            if(isset($deptlog->refrcvd) && $deptlog->refrcvd){
                $revlocationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->refrcvd,'idsku'=>$deptlog->idsku));
                if(!isset($revlocationstock->idlocationstocks)){$revlocationstock = new Locationstocks;} 
                
                $revlocationstock->iddept = $deptlog->refrcvd;
                $revlocationstock->idsku = $deptlog->idsku;
                $revlocationstock->totqty = $revlocationstock->totqty - ((($deptlog->qty) - ($deptlog->lastqty))*$type);
                $revlocationstock->qtyship = $revlocationstock->qtyship + $deptlog->qty;
                $revlocationstock = Locationstocks::updateValues($revlocationstock, $deptlog);
                $revlocationstock->save();
                
            }else if(isset($deptlog->refsent) && $deptlog->refsent){
                $revlocationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->refsent,'idsku'=>$deptlog->idsku));
                if(!isset($revlocationstock->idlocationstocks)){$revlocationstock = new Locationstocks;} 
                
                $revlocationstock->iddept = $deptlog->refsent;
                $revlocationstock->idsku = $deptlog->idsku;
                $revlocationstock->totqty = $revlocationstock->totqty + (((-1 * $deptlog->qty) - (-1 * $deptlog->lastqty))*$type);
                $revlocationstock = Locationstocks::updateValues($revlocationstock, $deptlog);
                $revlocationstock->save();
            }
        }

        
        public function updateValues($locationstock, $deptlog){
            $locationstock->totstone = ($locationstock->totqty - $locationstock->qtyship) * $deptlog->idsku0->totstowei;
            $locationstock->totmetwt = ($locationstock->totqty - $locationstock->qtyship) * $deptlog->idsku0->totmetalwei;
            $locationstock->totwt = ($locationstock->totqty - $locationstock->qtyship) * $deptlog->idsku0->grosswt;
            $locationstock->item = $deptlog->idsku0->skucontent->type;
            
            return $locationstock;
        }

        public function UploadLocationUpdate($iddeptskulog, $type ,$locref , $currency , $pricepp){
        	$deptlog = Deptskulog::model()->findByPk($iddeptskulog);
            $locationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->iddept,'idsku'=>$deptlog->idsku));

            if(!isset($locationstock->idlocationstocks)){$locationstock = new Locationstocks;} 

            $locationstock->iddept = $deptlog->iddept;
            $locationstock->idsku = $deptlog->idsku;
            
            if(isset($deptlog->refsent) && $deptlog->refsent){
                $locationstock->totqty = $locationstock->totqty - (((-1 * $deptlog->qty) - ($deptlog->lastqty * -1))*$type);
                $locationstock->qtyship = $locationstock->qtyship + $deptlog->qty;
                $locationstock = Locationstocks::updateValues($locationstock, $deptlog);
                $locationstock->locref =$locref;
                $locationstock->currency =$currency;
                $locationstock->pricepp =$pricepp;
                $locationstock->save();
                
                $locationstock->uploadReverseUpdate($deptlog, $type,$locref , $currency , $pricepp);
            }
            
            if((isset($deptlog->refrcvd) && $deptlog->refrcvd) || (!isset($deptlog->refrcvd) && !isset($deptlog->refsent))){
                $locationstock->totqty = $locationstock->totqty + ((($deptlog->qty) - ($deptlog->lastqty))*$type);
                $locationstock = Locationstocks::updateValues($locationstock, $deptlog);
                $locationstock->locref =$locref;
                $locationstock->currency =$currency;
                $locationstock->pricepp =$pricepp;
                $locationstock->save();
                
                if((isset($deptlog->refrcvd) && $deptlog->refrcvd)){
                    $locationstock->reverseUpdate($deptlog,$type,$locref , $currency , $pricepp);
                }
            } 
        }
        public function uploadReverseUpdate($deptlog, $type,$locref , $currency , $pricepp){
            if(isset($deptlog->refrcvd) && $deptlog->refrcvd){
                $revlocationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->refrcvd,'idsku'=>$deptlog->idsku));
                if(!isset($revlocationstock->idlocationstocks)){$revlocationstock = new Locationstocks;} 
                
                $revlocationstock->iddept = $deptlog->refrcvd;
                $revlocationstock->idsku = $deptlog->idsku;
                $revlocationstock->totqty = $revlocationstock->totqty - ((($deptlog->qty) - ($deptlog->lastqty))*$type);
                $revlocationstock->qtyship = $revlocationstock->qtyship + $deptlog->qty;
                $revlocationstock = Locationstocks::updateValues($revlocationstock, $deptlog);
                $revlocationstock->locref =$locref;
                $revlocationstock->currency =$currency;
                $revlocationstock->pricepp =$pricepp;
                $revlocationstock->save();
                
            }else if(isset($deptlog->refsent) && $deptlog->refsent){
                $revlocationstock = Locationstocks::model()->findByAttributes(array('iddept'=>$deptlog->refsent,'idsku'=>$deptlog->idsku));
                if(!isset($revlocationstock->idlocationstocks)){$revlocationstock = new Locationstocks;} 
                
                $revlocationstock->iddept = $deptlog->refsent;
                $revlocationstock->idsku = $deptlog->idsku;
                $revlocationstock->totqty = $revlocationstock->totqty + (((-1 * $deptlog->qty) - (-1 * $deptlog->lastqty))*$type);
                $revlocationstock = Locationstocks::updateValues($revlocationstock, $deptlog);
                $revlocationstock->locref =$locref;
                $revlocationstock->currency =$currency;
                $revlocationstock->pricepp =$pricepp;
                $revlocationstock->save();
            }
        }
}
