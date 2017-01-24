<?php

/**
 * This is the model class for table "{{metalm}}".
 *
 * The followings are the available columns in table '{{metalm}}':
 * @property integer $idmetalm
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Metal[] $metals
 */
class Metalm extends CActiveRecord
{
	public $srate;
	public $grate;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Metalm the static model class
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
		return '{{metalm}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>45),
            array('currentcost', 'length', 'max'=>11),
            array('name','unique'),
           	//array('srate, grate', 'required', 'on' => 'my_scenario'),
            array('name', 'required','on' => 'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmetalm, name,srate,grate', 'safe', 'on'=>'search'),
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
			'metals' => array(self::HAS_MANY, 'Metal', 'idmetalm'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmetalm' => 'Idmetalm',
			'name' => 'Name',
			'currentcost' => 'Cost',
			'srate'=> 'Silver Base Rate',
			'grate'=>'Gold Base Rate',
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

		$criteria->compare('idmetalm',$this->idmetalm);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('currentcost',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}