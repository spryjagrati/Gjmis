<?php

/**
 * This is the model class for table "{{chemical}}".
 *
 * The followings are the available columns in table '{{chemical}}':
 * @property integer $idchemical
 * @property string $name
 * @property string $weiunit
 *
 * The followings are the available model relations:
 * @property Costadd[] $costadds
 */
class Chemical extends CActiveRecord
{
    
    
        public $stocks;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Chemical the static model class
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
		return '{{chemical}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, weiunit', 'required'),
			array('name', 'length', 'max'=>45),
			array('weiunit', 'length', 'max'=>8),
                    array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idchemical, name, weiunit, stocks', 'safe', 'on'=>'search'),
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
			'costadds' => array(self::HAS_MANY, 'Costadd', 'idchemical'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idchemical' => 'Idchemical',
			'name' => 'Name',
			'weiunit' => 'Weiunit',
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

		$criteria->compare('idchemical',$this->idchemical);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('weiunit',$this->weiunit,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}