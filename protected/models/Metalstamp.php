<?php

/**
 * This is the model class for table "{{metalstamp}}".
 *
 * The followings are the available columns in table '{{metalstamp}}':
 * @property integer $idmetalstamp
 * @property string $name
 * @property string $purity
 *
 * The followings are the available model relations:
 * @property Metal[] $metals
 */
class Metalstamp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Metalstamp the static model class
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
		return '{{metalstamp}}';
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
			array('purity', 'length', 'max'=>16),
                    array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmetalstamp, name, purity', 'safe', 'on'=>'search'),
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
			'metals' => array(self::HAS_MANY, 'Metal', 'idmetalstamp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmetalstamp' => 'Idmetalstamp',
			'name' => 'Name',
			'purity' => 'Purity',
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

		$criteria->compare('idmetalstamp',$this->idmetalstamp);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('purity',$this->purity,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}