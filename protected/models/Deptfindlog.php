<?php

/**
 * This is the model class for table "{{deptfindlog}}".
 *
 * The followings are the available columns in table '{{deptfindlog}}':
 * @property integer $idtbl_deptfindlog
 * @property integer $iddept
 * @property integer $idfinding
 * @property string $cdate
 * @property string $mdate
 * @property integer $refrcvd
 * @property integer $refsent
 * @property integer $idpo
 * @property integer $qty
 *
 * The followings are the available model relations:
 * @property Dept $iddept0
 * @property Finding $idfinding0
 * @property Po $idpo0
 * @property Dept $refrcvd0
 * @property Dept $refsent0
 */
class Deptfindlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Deptfindlog the static model class
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
		return '{{deptfindlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idtbl_deptfindlog, iddept, idfinding, refrcvd, refsent, idpo, qty', 'numerical', 'integerOnly'=>true),
			array('cdate, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idtbl_deptfindlog, iddept,acknow, idfinding, cdate, mdate, refrcvd, refsent, idpo, qty', 'safe', 'on'=>'search'),
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
			'idfinding0' => array(self::BELONGS_TO, 'Finding', 'idfinding'),
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
			'idtbl_deptfindlog' => 'Id Deptfindlog',
			'iddept' => 'Department',
			'idfinding' => 'Finding',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'refrcvd' => 'Ref. Received',
			'refsent' => 'Ref. Sent',
			'idpo' => 'IdPO',
			'qty' => 'Quantity',
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

		$criteria->compare('idtbl_deptfindlog',$this->idtbl_deptfindlog);
		$criteria->compare('iddept',$this->iddept);
		$criteria->compare('idfinding',$this->idfinding);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('refrcvd',$this->refrcvd);
		$criteria->compare('refsent',$this->refsent);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('qty',$this->qty);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                            'pageSize'=>50,
                        ),
		));
	}
}