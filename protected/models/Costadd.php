<?php

/**
 * This is the model class for table "{{costadd}}".
 *
 * The followings are the available columns in table '{{costadd}}':
 * @property integer $idcostadd
 * @property string $type
 * @property integer $idmetal
 * @property integer $idstone
 * @property string $factormetal
 * @property string $factorstone
 * @property string $fixcost
 * @property string $costformula
 * @property string $threscostformula
 * @property integer $idchemical
 * @property string $factorchem
 * @property integer $idsetting
 * @property string $factornumsto
 * @property string $name
 * @property string $factorsetting
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 *
 * The followings are the available model relations:
 * @property Chemical $idchemical0
 * @property Metal $idmetal0
 * @property Stone $idstone0
 * @property Setting $idsetting0
 * @property Skuaddon[] $skuaddons
 */
class Costadd extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Costadd the static model class
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
		return '{{costadd}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type,name', 'required'),
			array('idmetal, idstone, idchemical, idsetting, updby', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>8),
			array('factormetal, factorstone, factorchem, factornumsto, factorsetting', 'length', 'max'=>4),
			array('fixcost', 'length', 'max'=>6),
			array('costformula, threscostformula', 'length', 'max'=>45),
			array('name', 'length', 'max'=>128),
                    array('name','unique'),
                    array('cdate,mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idcostadd, type, idmetal, idstone, factormetal, factorstone, fixcost, costformula, threscostformula, idchemical, factorchem, idsetting, factornumsto, name, factorsetting, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
			'idchemical0' => array(self::BELONGS_TO, 'Chemical', 'idchemical'),
			'idmetal0' => array(self::BELONGS_TO, 'Metal', 'idmetal'),
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
			'idsetting0' => array(self::BELONGS_TO, 'Setting', 'idsetting'),
			'skuaddons' => array(self::HAS_MANY, 'Skuaddon', 'idcostaddon'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idcostadd' => 'Idcostadd',
			'type' => 'Type',
			'idmetal' => 'Metal',
			'idstone' => 'Stone',
			'factormetal' => 'Metal Factor',
			'factorstone' => 'Stone Factor',
			'fixcost' => 'Fix Cost',
			'costformula' => 'Cost formula',
			'threscostformula' => 'Thres Formula',
			'idchemical' => 'Chemical',
			'factorchem' => 'Chem Factor',
			'idsetting' => 'Setting',
			'factornumsto' => 'StoNum Factor',
			'name' => 'Name',
			'factorsetting' => 'Setting Factor',
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

		$criteria->compare('idcostadd',$this->idcostadd);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('idmetal',$this->idmetal);
		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('factormetal',$this->factormetal,true);
		$criteria->compare('factorstone',$this->factorstone,true);
		$criteria->compare('fixcost',$this->fixcost,true);
		$criteria->compare('costformula',$this->costformula,true);
		$criteria->compare('threscostformula',$this->threscostformula,true);
		$criteria->compare('idchemical',$this->idchemical);
		$criteria->compare('factorchem',$this->factorchem,true);
		$criteria->compare('idsetting',$this->idsetting);
		$criteria->compare('factornumsto',$this->factornumsto,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('factorsetting',$this->factorsetting,true);
                $criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getCaddTypes()
        {
            return array(
                'labor'=>'labor',
                'plating'=>'plating',
                'overhead'=>'overhead',
            );

        }


}