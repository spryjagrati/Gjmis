<?php

/**
 * This is the model class for table "{{finding}}".
 *
 * The followings are the available columns in table '{{finding}}':
 * @property integer $idfinding
 * @property string $name
 * @property string $weight
 * @property string $cost
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $descri
 * @property string $size
 * @property string $supplier
 * @property integer $idmetal
 * @property string $miracle
 *
 * The followings are the available model relations:
 * @property Skufindings[] $skufindings
 */
class Finding extends CActiveRecord
{
    
    
        public $stocks;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Finding the static model class
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
		return '{{finding}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, weight, cost, idmetal', 'required'),
			array('updby, idmetal', 'numerical', 'integerOnly'=>true),
			array('supplier', 'length', 'max'=>45),
			array('name', 'length', 'max'=>128),
			array('weight, cost', 'length', 'max'=>9),
                        array('miracle', 'length', 'max'=>7),
			array('size', 'length', 'max'=>8),
			array('descri', 'length', 'max'=>64),
			array('cdate', 'safe'),
                        array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idfinding, name, weight, cost, cdate, mdate, updby, descri, size, supplier, idmetal, miracle, $stocks', 'safe', 'on'=>'search'),
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
                        'skufindings' => array(self::HAS_MANY, 'Skufindings', 'idfinding'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
                    'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idfinding' => 'Idfinding',
			'name' => 'Name',
			'weight' => 'Weight(Gms)',
			'cost' => 'Price P.Pc',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'descri' => 'Description',
                    'size' => 'Size/Length',
                    'supplier' => 'Supplier Name',
                    'idmetal' => 'Metal',
                    'miracle' => 'Miracle Variable',
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

		$criteria->compare('idfinding',$this->idfinding);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('descri',$this->descri,true);
                $criteria->compare('size',$this->size,true);
                $criteria->compare('supplier',$this->supplier,true);
                $criteria->compare('idmetal',$this->idmetal);
                $criteria->compare('miracle',$this->miracle);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}