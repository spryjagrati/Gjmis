<?php

/**
 * This is the model class for table "{{metal}}".
 *
 * The followings are the available columns in table '{{metal}}':
 * @property integer $idmetal
 * @property integer $idmetalm
 * @property integer $idmetalstamp
 * @property string $currentcost
 * @property string $prevcost
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $lossfactor
 *
 * The followings are the available model relations:
 * @property Costadd[] $costadds
 * @property Deptmetallog[] $deptmetallogs
 * @property Metalm $idmetalm0
 * @property Metalstamp $idmetalstamp0
 * @property Metalcostlog[] $metalcostlogs
 * @property Skumetals[] $skumetals
 */
class Metal extends CActiveRecord
{
    
        
        public $stocks;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Metal the static model class
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
		return '{{metal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idmetalm, idmetalstamp,namevar,chemcost,currentcost', 'required'),
			array('idmetalm, idmetalstamp, updby', 'numerical', 'integerOnly'=>true),
			array('currentcost, prevcost', 'length', 'max'=>11),
			array('lossfactor', 'length', 'max'=>5),
			array('cdate', 'safe'),
                        array('namevar, chemcost','length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('namevar, idmetal, idmetalm, idmetalstamp, currentcost, prevcost, cdate, mdate, updby, lossfactor, stocks', 'safe', 'on'=>'search'),
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
			'costadds' => array(self::HAS_MANY, 'Costadd', 'idmetal'),
			'deptmetallogs' => array(self::HAS_MANY, 'Deptmetallog', 'idmetal'),
			'idmetalm0' => array(self::BELONGS_TO, 'Metalm', 'idmetalm'),
			'idmetalstamp0' => array(self::BELONGS_TO, 'Metalstamp', 'idmetalstamp'),
			'metalcostlogs' => array(self::HAS_MANY, 'Metalcostlog', 'idmetal'),
			'skumetals' => array(self::HAS_MANY, 'Skumetals', 'idmetal'),
                        'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmetal' => 'Idmetal',
			'idmetalm' => 'Metal',
			'idmetalstamp' => 'Stamp',
			'currentcost' => 'Cost',
			'prevcost' => 'Pre Cost',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'lossfactor' => 'Lossfactor',
                    'namevar' => 'Name',
                    'chemcost' => 'Chemical Cost',
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

		$criteria->compare('idmetal',$this->idmetal);
		$criteria->compare('idmetalm',$this->idmetalm);
		$criteria->compare('idmetalstamp',$this->idmetalstamp);
		$criteria->compare('currentcost',$this->currentcost,true);
		$criteria->compare('prevcost',$this->prevcost,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('lossfactor',$this->lossfactor,true);
		$criteria->compare('chemcost',$this->chemcost,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

}