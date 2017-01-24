<?php

/**
 * This is the model class for table "{{stonesize}}".
 *
 * The followings are the available columns in table '{{stonesize}}':
 * @property integer $idstonesize
 * @property string $size
 *
 * The followings are the available model relations:
 * @property Stone[] $stones
 */
class Stonesize extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stonesize the static model class
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
		return '{{stonesize}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size', 'required'),
			array('size', 'length', 'max'=>16),
                    array('size','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstonesize, size', 'safe', 'on'=>'search'),
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
			'stones' => array(self::HAS_MANY, 'Stone', 'idstonesize'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstonesize' => 'Idstonesize',
			'size' => 'Size',
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

		$criteria->compare('idstonesize',$this->idstonesize);
		$criteria->compare('size',$this->size,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}