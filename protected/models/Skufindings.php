<?php

/**
 * This is the model class for table "{{skufindings}}".
 *
 * The followings are the available columns in table '{{skufindings}}':
 * @property integer $idskufindings
 * @property integer $idsku
 * @property integer $idfinding
 * @property integer $qty
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Finding $idfinding0
 * @property Sku $idsku0
 */
class Skufindings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skufindings the static model class
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
		return '{{skufindings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku, idfinding', 'required'),
			array('idskufindings, idsku, idfinding, qty, updby', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('cdate, mdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskufindings, idsku, idfinding, qty, cdate, mdate, updby, name', 'safe', 'on'=>'search'),
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
			'idfinding0' => array(self::BELONGS_TO, 'Finding', 'idfinding'),
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
			'idskufindings' => 'Idskufindings',
			'idsku' => 'Idsku',
			'idfinding' => 'Finding',
			'qty' => 'Qty',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'name' => 'Name',
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
                //if(!isset($this->mdate)){
                    $criteria->with=array('idsku0','idfinding0','iduser0');
                //}
                $criteria->together = true;
		$criteria->compare('idskufindings',$this->idskufindings);
		$criteria->compare('idsku0.skucode',$this->idsku);
		$criteria->compare('idfinding0.name',$this->idfinding);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('iduser0.username',$this->updby);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}