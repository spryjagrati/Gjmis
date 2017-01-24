<?php

/**
 * This is the model class for table "{{deptmetallog}}".
 *
 * The followings are the available columns in table '{{deptmetallog}}':
 * @property integer $iddeptmetallog
 * @property integer $idmetal
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
 * @property Dept $iddept0
 * @property Metal $idmetal0
 * @property Po $idpo0
 * @property Dept $refrcvd0
 * @property Dept $refsent0
 */
class Deptmetallog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Deptmetallog the static model class
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
		return '{{deptmetallog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmetal, iddept, qty', 'required'),
			array('idmetal, iddept, idpo, updby, refrcvd, refsent', 'numerical', 'integerOnly'=>true),
			array('qty', 'length', 'max'=>9),
			array('cunit', 'length', 'max'=>16),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iddeptmetallog, idmetal, iddept, qty,acknow, cunit, idpo, cdate, mdate, updby, refrcvd, refsent', 'safe', 'on'=>'search'),
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
			'iddept0' => array(self::BELONGS_TO, 'Dept', 'iddept'),
			'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
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
			'iddeptmetallog' => 'Iddeptmetallog',
			'idmetal' => 'Metal',
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

		$criteria->compare('iddeptmetallog',$this->iddeptmetallog);
		$criteria->compare('idmetal',$this->idmetal);
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