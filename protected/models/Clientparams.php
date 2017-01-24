<?php

/**
 * This is the model class for table "{{clientparams}}".
 *
 * The followings are the available columns in table '{{clientparams}}':
 * @property integer $idclientparams
 * @property integer $idclient
 * @property string $name
 * @property string $defaultval
 * @property string $formula
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Client $idclient0
 */
class Clientparams extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Clientparams the static model class
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
		return '{{clientparams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idclient, name', 'required'),
			array('idclient', 'numerical', 'integerOnly'=>true),
			array('name, defaultval', 'length', 'max'=>45),
			array('formula', 'length', 'max'=>64),
			array('type', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idclientparams, idclient, name, defaultval, formula, type', 'safe', 'on'=>'search'),
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
			'idclient0' => array(self::BELONGS_TO, 'Client', 'idclient'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idclientparams' => 'Idclientparams',
			'idclient' => 'Idclient',
			'name' => 'Name',
			'defaultval' => 'Defaultval',
			'formula' => 'Formula',
			'type' => 'Type',
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

		$criteria->compare('idclientparams',$this->idclientparams);
		$criteria->compare('idclient',$this->idclient);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('defaultval',$this->defaultval,true);
		$criteria->compare('formula',$this->formula,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}