<?php

/**
 * This is the model class for table "{{setting}}".
 *
 * The followings are the available columns in table '{{setting}}':
 * @property integer $idsetting
 * @property string $name
 * @property string $type
 * @property string $setcost
 * @property string $bagcost
 *
 * The followings are the available model relations:
 * @property Costadd[] $costadds
 * @property Skustones[] $skustones
 */
class Setting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Setting the static model class
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
		return '{{setting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, setcost, bagcost', 'required'),
			array('name', 'length', 'max'=>16),
			array('type', 'length', 'max'=>8),
			array('setcost, bagcost', 'length', 'max'=>5),
                    array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idsetting, name, type, setcost, bagcost', 'safe', 'on'=>'search'),
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
			'costadds' => array(self::HAS_MANY, 'Costadd', 'idsetting'),
			'skustones' => array(self::HAS_MANY, 'Skustones', 'idsetting'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idsetting' => 'Idsetting',
			'name' => 'Name',
			'type' => 'Type',
			'setcost' => 'Setting Cost',
			'bagcost' => 'Bagging Cost',
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

		$criteria->compare('idsetting',$this->idsetting);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('setcost',$this->setcost,true);
		$criteria->compare('bagcost',$this->bagcost,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}