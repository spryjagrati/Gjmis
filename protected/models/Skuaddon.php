<?php

/**
 * This is the model class for table "{{skuaddon}}".
 *
 * The followings are the available columns in table '{{skuaddon}}':
 * @property integer $idskuaddon
 * @property integer $idcostaddon
 * @property string $qty
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $idsku
 *
 * The followings are the available model relations:
 * @property Costadd $idcostaddon0
 * @property Sku $idsku0
 */
class Skuaddon extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skuaddon the static model class
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
		return '{{skuaddon}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idcostaddon, idsku', 'required'),
			array('idcostaddon, updby, idsku, qty', 'numerical', 'integerOnly'=>true),
			//array('qty', 'length', 'max'=>1),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskuaddon, idcostaddon, qty, cdate, mdate, updby, idsku', 'safe', 'on'=>'search'),
		);
	}

        /*spry behaviours*/
        public function behaviors()
	{
	    return array(
	        'CTimestampBehavior' => array(
	            'class' => 'zii.behaviors.CTimestampBehavior',
	            'createAttribute' => 'cdate',
	            'updateAttribute' => 'mdate',
	            'setUpdateOnCreate' => true,
	        ),
	        'BlameableBehavior' => array(
	            'class' => 'application.components.BlameableBehavior',
	            'createdByColumn' => 'updby', // optional
	            'updatedByColumn' => 'updby',  // optional
	        ),
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
			'idcostaddon0' => array(self::BELONGS_TO, 'Costadd', 'idcostaddon'),
			'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idskuaddon' => 'Idskuaddon',
			'idcostaddon' => 'Cost AddOn',
			'qty' => 'Qty',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'idsku' => 'Idsku',
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

		$criteria->compare('idskuaddon',$this->idskuaddon);
		$criteria->compare('idcostaddon',$this->idcostaddon);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('idsku',$this->idsku);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}