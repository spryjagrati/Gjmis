<?php

/**
 * This is the model class for table "{{poskustatuslog}}".
 *
 * The followings are the available columns in table '{{poskustatuslog}}':
 * @property integer $idposkustatuslog
 * @property integer $idposku
 * @property integer $reqdqty
 * @property integer $processqty
 * @property integer $delqty
 * @property integer $idprocdept
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $rcvddate
 * @property string $dlvddate
 * @property integer $idstatusm
 * @property string $descrip
 * @property string $remark
 *
 * The followings are the available model relations:
 * @property Dept $idprocdept0
 * @property Poskus $idposku0
 * @property Statusm $idstatusm0
 */
class Poskustatuslog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Poskustatuslog the static model class
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
		return '{{poskustatuslog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idposku, idprocdept', 'required'),
			array('idposku, reqdqty, processqty, delqty, idprocdept, updby, idstatusm', 'numerical', 'integerOnly'=>true),
			array('descrip, remark', 'length', 'max'=>128),
                        array('cdate, rcvddate, dlvddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idposkustatuslog, idposku, reqdqty, processqty, delqty, idprocdept, cdate, mdate, updby, rcvddate, dlvddate, idstatusm', 'safe', 'on'=>'search'),
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
			'idprocdept0' => array(self::BELONGS_TO, 'Dept', 'idprocdept'),
			'idposku0' => array(self::BELONGS_TO, 'Poskus', 'idposku'),
			'idstatusm0' => array(self::BELONGS_TO, 'Statusm', 'idstatusm'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idposkustatuslog' => 'Idposkustatuslog',
			'idposku' => 'Idposku',
			'reqdqty' => 'Req Qty',
			'processqty' => 'Proc Qty',
			'delqty' => 'Dlv Qty',
			'idprocdept' => 'Idprocdept',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'rcvddate' => 'Rcv Date',
			'dlvddate' => 'Dlv Date',
			'idstatusm' => 'Status',
                    'descrip' => 'Desc',
                    'remark' => 'Remark',
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

		$criteria->compare('idposkustatuslog',$this->idposkustatuslog);
		$criteria->compare('idposku',$this->idposku);
		$criteria->compare('reqdqty',$this->reqdqty);
		$criteria->compare('processqty',$this->processqty);
		$criteria->compare('delqty',$this->delqty);
		$criteria->compare('idprocdept',$this->idprocdept);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('rcvddate',$this->rcvddate,true);
		$criteria->compare('dlvddate',$this->dlvddate,true);
		$criteria->compare('idstatusm',$this->idstatusm);
                $criteria->compare('descrip',$this->descrip,true);
                $criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}