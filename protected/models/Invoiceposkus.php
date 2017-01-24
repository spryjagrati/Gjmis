<?php

/**
 * This is the model class for table "{{invoiceposkus}}".
 *
 * The followings are the available columns in table '{{invoiceposkus}}':
 * @property integer $idinvoiceposkus
 * @property integer $idinvoice
 * @property integer $idposkus
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $activ
 */
class Invoiceposkus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoiceposkus the static model class
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
		return '{{invoiceposkus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idinvoice,', 'required'),
			array('idinvoice,  updby', 'numerical', 'integerOnly'=>true),
			array('activ', 'length', 'max'=>45),
			array('cdate,movements,idlocationstocks, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idinvoiceposkus,movements,idlocationstocks, shipqty,idinvoice,procode,totprice,idposkus, cdate, mdate, updby, activ, idpo', 'safe', 'on'=>'search'),
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
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'idposkus0' => array(self::BELONGS_TO, 'Poskus', 'idposkus'),
                    'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
                    'idinvoice0' => array(self::BELONGS_TO, 'Invoice', 'idinvoice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idinvoiceposkus' => 'Idinvoiceposkus',
			'idinvoice' => 'Id Invoice',
			'idposkus' => 'Id Poskus',
			'cdate' => 'Create',
			'mdate' => 'Modified',
			'updby' => 'Update By',
			'activ' => 'Activ',
			'idpo' => 'PO ID',
                        'procode' => 'Product Code',
                        'totprice' => 'Unit Net Price Incl. Vat',
                        'shipqty' => 'Shipped Quantity'
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

		$criteria->compare('idinvoiceposkus',$this->idinvoiceposkus);
		$criteria->compare('idinvoice',$this->idinvoice);
		$criteria->compare('idposkus',$this->idposkus);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('activ',$this->activ,true);
		$criteria->compare('idpo',$this->activ,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}