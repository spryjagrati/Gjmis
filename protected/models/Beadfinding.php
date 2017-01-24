<?php

/**
 * This is the model class for table "{{beadfinding}}".
 *
 * The followings are the available columns in table '{{beadfinding}}':
 * @property integer $idbeadfinding
 * @property integer $idbeadsku
 * @property integer $qty
 * @property string $idfinding
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 */
class Beadfinding extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Beadfinding the static model class
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
		return '{{beadfinding}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idbeadsku, idfinding',  'required'),
			array('idbeadsku, qty, updby', 'numerical', 'integerOnly'=>true),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idbeadfinding, idbeadsku, qty, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
			'idfinding0' => array(self::BELONGS_TO, 'Finding', 'idfinding'),
			'idbead0' => array(self::BELONGS_TO, 'Bead', 'idbeadsku'),
           	'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbeadfinding' => 'Idbeadfinding',
			'idbeadsku' => 'Idbeadsku',
			'idfinding' => 'Finding',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'updby' => 'Updby',
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idbeadfinding',$this->idbeadfinding);
		$criteria->compare('idbeadsku',$this->idbeadsku);
		$criteria->compare('idfinding',$this->idfinding);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}