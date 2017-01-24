<?php

/**
 * This is the model class for table "{{po}}".
 *
 * The followings are the available columns in table '{{po}}':
 * @property integer $idpo
 * @property integer $idclient
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $idstatusm
 * @property string $dlvddate
 * @property string $startdate
 * @property string $totamt
 * @property string $instructions
 * @property integer $idprocdept
 *
 * The followings are the available model relations:
 * @property Deptmetallog[] $deptmetallogs
 * @property Deptstonelog[] $deptstonelogs
 * @property Invoice[] $invoices
 * @property Client $idclient0
 * @property Statusm $idstatusm0
 * @property Poskus[] $poskuses
 * @property Postatuslog[] $postatuslogs
 * @property Sku[] $skus
 * @property Dept $idprocdept0
 */
class Po extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Po the static model class
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
		return '{{po}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idclient, idstatusm', 'required'),
			array('idclient, updby, idstatusm, idprocdept', 'numerical', 'integerOnly'=>true),
			array('totamt', 'length', 'max'=>9),
			array('instructions', 'length', 'max'=>128),
			array('cdate, dlvddate, startdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idpo, idclient, cdate, mdate, updby, idstatusm, dlvddate, startdate, totamt, instructions, idprocdept', 'safe', 'on'=>'search'),
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
			'deptmetallogs' => array(self::HAS_MANY, 'Deptmetallog', 'idpo'),
			'deptstonelogs' => array(self::HAS_MANY, 'Deptstonelog', 'idpo'),
			'invoices' => array(self::HAS_MANY, 'Invoice', 'idpo'),
			'idclient0' => array(self::BELONGS_TO, 'Client', 'idclient'),
			'idstatusm0' => array(self::BELONGS_TO, 'Statusm', 'idstatusm'),
			'poskuses' => array(self::HAS_MANY, 'Poskus', 'idpo'),
			'postatuslogs' => array(self::HAS_MANY, 'Postatuslog', 'idpo'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
                    'idprocdept0' => array(self::BELONGS_TO, 'Dept', 'idprocdept'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idpo' => 'Idpo',
			'idclient' => 'Client',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'idstatusm' => 'Status',
			'dlvddate' => 'Dlvry Date',
			'startdate' => 'Start Date',
			'totamt' => 'Total Amt',
			'instructions' => 'Instructions',
                    'idprocdept' => 'Factory',
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

		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('idclient',$this->idclient);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('idstatusm',$this->idstatusm);
		$criteria->compare('dlvddate',$this->dlvddate,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('totamt',$this->totamt,true);
		$criteria->compare('instructions',$this->instructions,true);
                $criteria->compare('idprocdept',$this->idprocdept,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}