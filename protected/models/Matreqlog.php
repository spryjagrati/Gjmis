<?php

/**
 * This is the model class for table "{{matreqlog}}".
 *
 * The followings are the available columns in table '{{matreqlog}}':
 * @property integer $idtbl_matreqlog
 * @property integer $idmatreq
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $rqty
 * @property string $fqty
 * @property integer $idstatusm
 *
 * The followings are the available model relations:
 * @property Matreq $idmatreq0
 * @property Statusm $idstatusm0
 */
class Matreqlog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Matreqlog the static model class
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
		return '{{matreqlog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idtbl_matreqlog, idmatreq, updby, idstatusm', 'numerical', 'integerOnly'=>true),
			array('rqty, fqty', 'length', 'max'=>9),
			array('cdate, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idtbl_matreqlog, idmatreq, cdate, mdate, updby, rqty, fqty, idstatusm', 'safe', 'on'=>'search'),
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
			'idmatreq0' => array(self::BELONGS_TO, 'Matreq', 'idmatreq'),
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
			'idtbl_matreqlog' => 'Idtbl Matreqlog',
			'idmatreq' => 'Idmatreq',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'rqty' => 'Req Qty',
			'fqty' => 'Fulfill Qty',
			'idstatusm' => 'Status',
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

		$criteria->compare('idtbl_matreqlog',$this->idtbl_matreqlog);
		$criteria->compare('idmatreq',$this->idmatreq);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('rqty',$this->rqty,true);
		$criteria->compare('fqty',$this->fqty,true);
		$criteria->compare('idstatusm',$this->idstatusm);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}