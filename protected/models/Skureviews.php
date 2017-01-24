<?php

/**
 * This is the model class for table "{{skureviews}}".
 *
 * The followings are the available columns in table '{{skureviews}}':
 * @property integer $idreview
 * @property integer $idsku
 * @property varchar $review
 * The followings are the available model relations:
 * @property Setting $idsetting0
 * @property Sku $idsku0
 * @property Stone $idstone0
 */
class Skureviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skustones the static model class
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
		return '{{skureviews}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku', 'required'),
			array('idsku, idskureview', 'numerical', 'integerOnly'=>true),
			array('reviews','length', 'max'=>255),
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
			'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idskureview' => 'Idskureview',
			'idsku' => 'Idsku',
			'reviews' => 'Reviews',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
		);
	}
}