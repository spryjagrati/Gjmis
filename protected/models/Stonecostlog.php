<?php

/**
 * This is the model class for table "{{stonecostlog}}".
 *
 * The followings are the available columns in table '{{stonecostlog}}':
 * @property integer $idstonecostlog
 * @property integer $idstone
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $cost
 *
 * The followings are the available model relations:
 * @property Stone $idstone0
 */
class Stonecostlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stonecostlog the static model class
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
		return '{{stonecostlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idstone, mdate, cost', 'required'),
			array('idstone, updby', 'numerical', 'integerOnly'=>true),
			//array('cost', 'length', 'max'=>8),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstonecostlog, idstone, cdate, mdate, updby, cost', 'safe', 'on'=>'search'),
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
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
                        'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstonecostlog' => 'Idstonecostlog',
			'idstone' => 'Idstone',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'updby' => 'Updby',
			'cost' => 'Cost',
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
                $criteria->scopes='search';
                $criteria->with=array('idstone0','iduser0');
                $criteria->together = true;
		$criteria->compare('idstonecostlog',$this->idstonecostlog);
		$criteria->compare('idstone0.namevar',$this->idstone,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
                $criteria->compare('idstone0.namevar',$this->idstone,true);
		
		$criteria->compare('iduser0.username',$this->updby,true);
		$criteria->compare('cost',$this->cost,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
