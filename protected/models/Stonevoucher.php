<?php

/**
 * This is the model class for table "{{stonevoucher}}".
 *
 * The followings are the available columns in table '{{stonevoucher}}':
 * @property integer $idstonevoucher
 * @property integer $issuedto
 * @property integer $issuedfrom
 * @property string $cdate
 * @property string $mdate
 * @property string $code
 * @property integer $acknow
 */
class Stonevoucher extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stonevoucher the static model class
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
		return '{{stonevoucher}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('issuedto', 'required'),
			array('issuedto, issuedfrom, acknow', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>64),
			array('mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstonevoucher,updby, issuedto, issuedfrom, cdate, mdate, code, acknow', 'safe', 'on'=>'search'),
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
                    'iddept0' => array(self::BELONGS_TO, 'Dept', 'issuedto'),
                    'iddept1' => array(self::BELONGS_TO, 'Dept', 'issuedfrom'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstonevoucher' => 'Voucher ID',
			'issuedto' => 'Issued To',
			'issuedfrom' => 'Issued From',
			'cdate' => 'Creation Date',
			'mdate' => 'Modified Date',
			'code' => 'Voucher Code',
			'acknow' => 'Acknowledge',
			'updby' => 'Updated By',
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

		$criteria->compare('idstonevoucher',$this->idstonevoucher);
		$criteria->compare('issuedto',$this->issuedto);
		$criteria->compare('issuedfrom',$this->issuedfrom);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('acknow',$this->acknow);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}