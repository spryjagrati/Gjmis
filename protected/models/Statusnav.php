<?php

/**
 * This is the model class for table "{{statusnav}}".
 *
 * The followings are the available columns in table '{{statusnav}}':
 * @property integer $idstatusnav
 * @property integer $idstatusf
 * @property integer $idstatust
 *
 * The followings are the available model relations:
 * @property Statusm $idstatusf0
 * @property Statusm $idstatust0
 */
class Statusnav extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Statusnav the static model class
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
		return '{{statusnav}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idstatusf, idstatust', 'required'),
			array('idstatusf, idstatust', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstatusnav, idstatusf, idstatust', 'safe', 'on'=>'search'),
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
			'idstatusf0' => array(self::BELONGS_TO, 'Statusm', 'idstatusf'),
			'idstatust0' => array(self::BELONGS_TO, 'Statusm', 'idstatust'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstatusnav' => 'Idstatusnav',
			'idstatusf' => 'Status From',
			'idstatust' => 'Status To',
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

		$criteria->compare('idstatusnav',$this->idstatusnav);
		$criteria->compare('idstatusf',$this->idstatusf);
		$criteria->compare('idstatust',$this->idstatust);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}