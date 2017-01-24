<?php

/**
 * This is the model class for table "{{poskustones}}".
 *
 * The followings are the available columns in table '{{poskustones}}':
 * @property integer $idtbl_poskustones
 * @property integer $idposku
 * @property integer $idskustone
 * @property integer $idstone
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 */
class Poskustones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Poskustones the static model class
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
		return '{{poskustones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idtbl_poskustones, idposku, idskustone, idstone', 'required'),
			array('idtbl_poskustones, idposku, idskustone, idstone, updby', 'numerical', 'integerOnly'=>true),
			array('cdate, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idtbl_poskustones, idposku, idskustone, idstone, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idtbl_poskustones' => 'Idtbl Poskustones',
			'idposku' => 'Idposku',
			'idskustone' => 'Idskustone',
			'idstone' => 'Idstone',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
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

		$criteria->compare('idtbl_poskustones',$this->idtbl_poskustones);
		$criteria->compare('idposku',$this->idposku);
		$criteria->compare('idskustone',$this->idskustone);
		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}