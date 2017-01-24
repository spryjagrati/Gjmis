<?php

/**
 * This is the model class for table "{{postatuslog}}".
 *
 * The followings are the available columns in table '{{postatuslog}}':
 * @property integer $idpostatuslog
 * @property integer $idpo
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $idstatusm
 * @property string $instructions
 *
 * The followings are the available model relations:
 * @property Po $idpo0
 * @property Statusm $idstatusm0
 */
class Postatuslog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Postatuslog the static model class
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
		return '{{postatuslog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('mdate', 'required'),
			array('idpo, updby, idstatusm', 'numerical', 'integerOnly'=>true),
			array('instructions', 'length', 'max'=>128),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idpostatuslog, idpo, cdate, mdate, updby, idstatusm, instructions', 'safe', 'on'=>'search'),
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
			'idpo0' => array(self::BELONGS_TO, 'Po', 'idpo'),
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
			'idpostatuslog' => 'Idpostatuslog',
			'idpo' => 'Idpo',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'idstatusm' => 'Status',
			'instructions' => 'Instructions',
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

		$criteria->compare('idpostatuslog',$this->idpostatuslog);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('idstatusm',$this->idstatusm);
		$criteria->compare('instructions',$this->instructions,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}