<?php

/**
 * This is the model class for table "{{matreq}}".
 *
 * The followings are the available columns in table '{{matreq}}':
 * @property integer $idmatreq
 * @property integer $idpo
 * @property integer $idmetal
 * @property integer $idstone
 * @property integer $idchemical
 * @property integer $idfinding
 * @property integer $idstatusm
 * @property string $cdate
 * @property string $mdate
 * @property string $sdate
 * @property integer $updby
 * @property integer $reqby
 * @property integer $reqto
 * @property string $edate
 * @property string $notes
 * @property string $rqty
 * @property string $qunit
 * @property string $type
 * @property string $fqty
 * @property string $estdate
 *
 * The followings are the available model relations:
 * @property Dept $reqby0
 * @property Dept $reqto0
 * @property Chemical $idchemical0
 * @property Finding $idfinding0
 * @property Metal $idmetal0
 * @property Po $idpo0
 * @property Statusm $idstatusm0
 * @property Stone $idstone0
 * @property Matreqlog[] $matreqlogs
 */
class Matreq extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Matreq the static model class
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
		return '{{matreq}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('rqty,reqby,reqto,type,idstatusm','required'),
                    array('idmetal','required','on'=>'metreq'),
                    array('idstone','required','on'=>'storeq'),
                    array('idchemical','required','on'=>'chemreq'),
                    array('idfinding','required','on'=>'findreq'),
			array('idmatreq, idpo, idmetal, idstone, idchemical, idfinding, idstatusm, updby, reqby, reqto', 'numerical', 'integerOnly'=>true),
			array('notes', 'length', 'max'=>254),
			array('rqty, fqty', 'length', 'max'=>9),
			array('qunit', 'length', 'max'=>8),
			array('type', 'length', 'max'=>16),
			array('cdate, mdate, sdate, edate, estdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmatreq, idpo, idmetal, idstone, idchemical, idfinding, idstatusm, cdate, mdate, sdate, updby, reqby, reqto, edate, notes, rqty, qunit, type, fqty, estdate', 'safe', 'on'=>'search'),
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
			'reqby0' => array(self::BELONGS_TO, 'Dept', 'reqby'),
			'reqto0' => array(self::BELONGS_TO, 'Dept', 'reqto'),
			'idchemical0' => array(self::BELONGS_TO, 'Chemical', 'idchemical'),
			'idfinding0' => array(self::BELONGS_TO, 'Finding', 'idfinding'),
			'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
			'idpo0' => array(self::BELONGS_TO, 'Po', 'idpo'),
			'idstatusm0' => array(self::BELONGS_TO, 'Statusm', 'idstatusm'),
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
			'matreqlogs' => array(self::HAS_MANY, 'Matreqlog', 'idmatreq'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmatreq' => 'Idmatreq',
			'idpo' => 'Idpo',
			'idmetal' => 'Metal',
			'idstone' => 'Stone',
			'idchemical' => 'Chemical',
			'idfinding' => 'Finding',
			'idstatusm' => 'Status',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'sdate' => 'Requested',
			'updby' => 'Updated By',
			'reqby' => 'Req By',
			'reqto' => 'Req Sent To',
			'edate' => 'End Date',
			'notes' => 'Notes',
			'rqty' => 'Req Qty',
			'qunit' => 'Unit',
			'type' => 'Type',
			'fqty' => 'Fullfilled Qty',
			'estdate' => 'Est Date',
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

		$criteria->compare('idmatreq',$this->idmatreq);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('idmetal',$this->idmetal);
		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('idchemical',$this->idchemical);
		$criteria->compare('idfinding',$this->idfinding);
		$criteria->compare('idstatusm',$this->idstatusm);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('sdate',$this->sdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('reqby',$this->reqby);
		$criteria->compare('reqto',$this->reqto);
		$criteria->compare('edate',$this->edate,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('rqty',$this->rqty,true);
		$criteria->compare('qunit',$this->qunit,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('fqty',$this->fqty,true);
		$criteria->compare('estdate',$this->estdate,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getReqTypes()
        {
            return array(
                'metal'=>'metal',
                'stone'=>'stone',
                'chemical'=>'chemical',
                'finding'=>'finding',
            );

        }
}