<?php

/**
 * This is the model class for table "{{skumetals}}".
 *
 * The followings are the available columns in table '{{skumetals}}':
 * @property integer $idskumetals
 * @property integer $idsku
 * @property integer $idmetal
 * @property string $weight
 * @property string $weiunit
 * @property string $usage
 * @property string $lossfactor
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 *
 * The followings are the available model relations:
 * @property Metal $idmetal0
 * @property Sku $idsku0
 */
class Skumetals extends CActiveRecord
{
        public $skucode_search;
        public $metal_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skumetals the static model class
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
		return '{{skumetals}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku, idmetal', 'required'),
			array('idsku, idmetal, updby', 'numerical', 'integerOnly'=>true),
			array('weight', 'length', 'max'=>9),
			array('lossfactor', 'length', 'max'=>4),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskumetals, idsku, idmetal, weight, usage, lossfactor, cdate, mdate, updby,skucode_search,metal_search', 'safe', 'on'=>'search'),
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
			'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
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
			'idskumetals' => 'Idskumetals',
			'idsku' => 'Idsku',
			'idmetal' => 'Metal',
			'weight' => 'Weight',
			'usage' => 'Usage',
			'lossfactor' => 'Loss Factor',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
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
                $criteria->scopes='search';
                $criteria->with=array('idsku0','idmetal0');
                $criteria->together = true;
		$criteria->compare('idskumetals',$this->idskumetals);
		$criteria->compare('idsku0.skucode',$this->idsku);
		$criteria->compare('idmetal0.namevar',$this->idmetal);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('usage',$this->usage,true);
		$criteria->compare('lossfactor',$this->lossfactor,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
                
                $criteria->with[] = 'idsku0';
                $criteria->with[] = 'idmetal0';
                $criteria->together = true;
                $criteria->compare( 'idsku0.skucode', $this->skucode_search, true );
                $criteria->compare( 'idmetal0.namevar', $this->metal_search, true );

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}