<?php

/**
 * This is the model class for table "{{deptchemlog}}".
 *
 * The followings are the available columns in table '{{deptchemlog}}':
 * @property integer $iddeptchemlog
 * @property integer $idchemical
 * @property integer $iddept
 * @property string $qty
 * @property string $cunit
 * @property integer $idpo
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $refrcvd
 * @property integer $refsent
 *
 * The followings are the available model relations:
 * @property Chemical $idchemical0
 * @property Dept $iddept0
 * @property Po $idpo0
 * @property Dept $refrcvd0
 * @property Dept $refsent0
 */
class Deptchemlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Deptchemlog the static model class
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
		return '{{deptchemlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddeptchemlog, idchemical, iddept, idpo, updby, refrcvd, refsent', 'numerical', 'integerOnly'=>true),
			array('qty', 'length', 'max'=>9),
			array('cunit', 'length', 'max'=>16),
			array('cdate, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iddeptchemlog,acknow, idchemical, iddept, qty, cunit, idpo, cdate, mdate, updby, refrcvd, refsent', 'safe', 'on'=>'search'),
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
			'idchemical0' => array(self::BELONGS_TO, 'Chemical', 'idchemical'),
			'iddept0' => array(self::BELONGS_TO, 'Dept', 'iddept'),
			'idpo0' => array(self::BELONGS_TO, 'Po', 'idpo'),
			'refrcvd0' => array(self::BELONGS_TO, 'Dept', 'refrcvd'),
			'refsent0' => array(self::BELONGS_TO, 'Dept', 'refsent'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iddeptchemlog' => 'Iddeptchemlog',
			'idchemical' => 'Chemical',
			'iddept' => 'Department',
			'qty' => 'Quantity',
			'cunit' => 'Cunit',
			'idpo' => 'IdPO',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updby',
			'refrcvd' => 'Ref. Received',
			'refsent' => 'Ref. Sent',
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

		$criteria->compare('iddeptchemlog',$this->iddeptchemlog);
		$criteria->compare('idchemical',$this->idchemical);
		$criteria->compare('iddept',$this->iddept);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('cunit',$this->cunit,true);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('refrcvd',$this->refrcvd);
		$criteria->compare('refsent',$this->refsent);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>50,
                        ),
		));
	}
}