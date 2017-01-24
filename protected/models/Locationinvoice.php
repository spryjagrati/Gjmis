<?php

/**
 * This is the model class for table "{{locationinvoice}}".
 *
 * The followings are the available columns in table '{{locationinvoice}}':
 * @property integer $idlocationinvoice
 * @property integer $idinvoice
 * @property string $daddress
 * @property string $dperson
 * @property integer $dphone
 * @property string $saddress
 * @property string $sperson
 * @property integer $sphone
 * @property string $procode
 * @property string $totprice
 * @property integer $type
 */
class Locationinvoice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Locationinvoice the static model class
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
		return '{{locationinvoice}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idinvoice, type,dcountry,dperson,scountry,sperson', 'required'),
			array('idinvoice,idlocation, dphone, sphone, type', 'numerical', 'integerOnly'=>true),
			array('dcountry, scountry', 'length', 'max'=>30),
                        array('dstreet, sstreet', 'length', 'max'=>255),
                        array('dpincode, spincode', 'length', 'max'=>64),
			array('dperson, sperson', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idlocationinvoice,idlocation,creditnum, idinvoice, dcountry,dstreet,dpincode, dperson, dphone, scountry,sstreet,spincode, sperson, sphone,  type', 'safe', 'on'=>'search'),
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
                    'idinvoice0' => array(self::BELONGS_TO, 'Invoice', 'idinvoice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idlocationinvoice' => 'Idlocationinvoice',
			'idinvoice' => 'Invoice',
			'dcountry' => 'Delivery Country',
                        'dstreet' => 'Delivery Street',
                        'dpincode' => 'Delivery Pincode',
			'dperson' => 'Delivery Concern Person',
			'dphone' => 'Delivery Phone',
                        'scountry' => 'Shipping Country',
                        'sstreet' => 'Shipping Street',
                        'spincode' => 'Shipping Pincode',
			'sperson' => 'Shipping Concern Person',
			'sphone' => 'Shipping Phone',
			'type' => 'Type',
                        'idlocation' => 'Location',
                        'creditnum' =>'Credit Number'
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

		$criteria->compare('idlocationinvoice',$this->idlocationinvoice);
		$criteria->compare('idinvoice',$this->idinvoice);
		$criteria->compare('dcountry',$this->daddress,true);
                $criteria->compare('dstreet',$this->dstreet,true);
                $criteria->compare('dpincode',$this->dpincode,true);
		$criteria->compare('dperson',$this->dperson,true);
		$criteria->compare('dphone',$this->dphone);
		$criteria->compare('scountry',$this->scountry,true);
                $criteria->compare('sstreet',$this->sstreet,true);
                $criteria->compare('spincode',$this->spincode,true);
		$criteria->compare('sperson',$this->sperson,true);
		$criteria->compare('sphone',$this->sphone);
		$criteria->compare('type',$this->type);
		$criteria->compare('idlocation',$this->iddept);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}