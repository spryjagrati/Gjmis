<?php

/**
 * This is the model class for table "{{stonestocks}}".
 *
 * The followings are the available columns in table '{{stonestocks}}':
 * @property integer $idstonestocks
 * @property integer $iddept
 * @property integer $idstone
 * @property integer $qty
 * @property integer $idpo
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $refrcvd
 * @property integer $refsent
 * @property integer $acknow
 * @property string $stonewt
 * @property integer $idlocation
 * @property integer $idstonevoucher
 * @property string $skuname
 * @property integer $set
 * @property string $remark
 */
class Stonestocks extends CActiveRecord
{
    
          public $gem_shape;
        public $gem_size;
        public $gemstone;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Stonestocks the static model class
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
		return '{{stonestocks}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddept, idstone, qty', 'required'),
			array('iddept, idstone, qty, idpo, updby, refrcvd, refsent, acknow, idlocation, idstonevoucher, set', 'numerical', 'integerOnly'=>true),
			array('stonewt', 'length', 'max'=>7),
			array('skuname', 'length', 'max'=>65),
			array('remark', 'length', 'max'=>128),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstonestocks, iddept, idstone, qty, idpo, cdate, mdate, updby, refrcvd, refsent, acknow, stonewt, idlocation, idstonevoucher, skuname, set, remark,gem_shape,gem_size,gemstone', 'safe', 'on'=>'search'),
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
			'iddept0' => array(self::BELONGS_TO, 'Dept', 'iddept'),
			'idpo0' => array(self::BELONGS_TO, 'Po', 'idpo'),
			'refrcvd0' => array(self::BELONGS_TO, 'Dept', 'refrcvd'),
			'refsent0' => array(self::BELONGS_TO, 'Dept', 'refsent'),
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
                        'stones' => array(self::BELONGS_TO, 'Stone', 'idstone'),
                        'sizes' => array(self::HAS_MANY, 'Stonesize', array('idstonesize'=>'idstonesize'), 'through'=>'idstone0'),
                        'shapes' => array(self::HAS_MANY, 'Shape', array('idshape'=>'idshape'), 'through'=>'stones'),
                        'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstonestocks' => 'Idstonestocks',
			'iddept' => 'Department',
			'idstone' => 'Stone',
			'qty' => 'Quantity',
			'idpo' => 'IdPO',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updby',
			'refrcvd' => 'Ref. Received',
			'refsent' => 'Ref. Sent',
                        'stonewt' => 'Total Stone Wt',
                        'idlocation' => 'Location',
                        'acknow' => 'Confirm',
                        'remark' => 'Remark',
                        'gemstone'=>'Stone Name',
                        'gem_shape' => 'Shape',
                        'gem_size' => 'Size',
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

		$criteria->compare('idstonestocks',$this->idstonestocks);
		$criteria->compare('iddept',$this->iddept);
		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('qty',$this->qty);
                /*---Sprymanish changes dec 28 start----- */
                $criteria->compare('stonewt',$this->stonewt);
		/*---Sprymanish changes dec 28 end----- */
                $criteria->compare('idpo',$this->idpo);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('refrcvd',$this->refrcvd);
		$criteria->compare('refsent',$this->refsent);
		$criteria->compare('idlocation',$this->idlocation);
		$criteria->compare('idstonevoucher',$this->idstonevoucher);
		$criteria->compare('remark',$this->remark);
                if(!empty($this->gemstone)) $criteria->with[] = 'idstone0';
                if(!empty($this->gem_shape)) $criteria->with[] = 'shapes';
                if(!empty($this->gem_size)) $criteria->with[] = 'sizes';
                if(!empty($this->gemstone) || !empty($this->gem_shape) || !empty($this->gem_size)) $criteria->together = true;
                if(!empty($this->gem_shape)) $criteria->compare('shapes.name',$this->gem_shape, true);
                if(!empty($this->gem_size)) $criteria->compare('sizes.size',$this->gem_size, true);
                if(!empty($this->gemstone)) $criteria->compare('idstone0.namevar',$this->gemstone, true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        
		));
	}
}