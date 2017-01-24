<?php

/**
 * This is the model class for table "{{metalcostlog}}".
 *
 * The followings are the available columns in table '{{metalcostlog}}':
 * @property integer $idmetalcostlog
 * @property integer $idmetal
 * @property string $cdate
 * @property string $mdate
 * @property string $cost
 * @property integer $updby
 *
 * The followings are the available model relations:
 * @property Metal $idmetal0
 */
class Metalcostlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Metalcostlog the static model class
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
		return '{{metalcostlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmetal, mdate, cost', 'required'),
			array('idmetal, updby', 'numerical', 'integerOnly'=>true),
			array('cost', 'length', 'max'=>9),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmetalcostlog, idmetal, cdate, mdate, cost, updby', 'safe', 'on'=>'search'),
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
			'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmetalcostlog' => 'Idmetalcostlog',
			'idmetal' => 'Idmetal',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'cost' => 'Cost',
			'updby' => 'Updby',
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

		$criteria->compare('idmetalcostlog',$this->idmetalcostlog);
		$criteria->compare('idmetal',$this->idmetal);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}