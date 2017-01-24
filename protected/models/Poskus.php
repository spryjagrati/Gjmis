<?php

/**
 * This is the model class for table "{{poskus}}".
 *
 * The followings are the available columns in table '{{poskus}}':
 * @property integer $idposkus
 * @property integer $idpo
 * @property integer $idsku
 * @property integer $qty
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $totamt
 * @property string $stonevar
 * @property string $reforder
 * @property string $usnum
 * @property string $descrip
 * @property string $ext
 * @property string $remark
 * @property string $refno
 * @property string $custsku
 * @property string $appmetwt
 * @property string $itemtype
 * @property string $itemmetal
 * @property string $metalstamp

 *
 * The followings are the available model relations:
 * @property Po $idpo0
 * @property Sku $idsku0
 * @property Poskustatus[] $poskustatuses
 * @property Poskustatuslog[] $poskustatuslogs
 */
class Poskus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Poskus the static model class
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
		return '{{poskus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idpo, qty', 'required'),
                        array('idsku','required','message'=>'sku # is required'),
			array('idpo, idsku, qty, updby', 'numerical', 'integerOnly'=>true),
			array('totamt, appmetwt', 'length', 'max'=>9),
			array('stonevar,  reforder, usnum', 'length', 'max'=>45),
			array('descrip, remark', 'length', 'max'=>128),
			array('ext, refno', 'length', 'max'=>8),
                        array('custsku, itemtype', 'length', 'max'=>16),
			array('itemmetal, metalstamp', 'length', 'max'=>32),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idposkus, idpo, idsku, qty, cdate, mdate, updby, totamt, stonevar, reforder, usnum, descrip, ext, remark', 'safe', 'on'=>'search'),
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
                    'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
                    'poskustatus' => array(self::HAS_ONE, 'Poskustatus', 'idposku'),
                    'poskustatuslogs' => array(self::HAS_MANY, 'Poskustatuslog', 'idposku'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
                    'metalstamp0' => array(self::BELONGS_TO, 'Metalstamp', 'metalstamp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idposkus' => 'Idposkus',
			'idpo' => 'Idpo',
			'idsku' => 'Idsku',
                      
			'qty' => 'Qty',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'totamt' => 'Tot Amt',
			'stonevar' => 'Stonevar',
			'reforder' => 'Order #',
			'usnum' => 'US #',
			'descrip' => 'Description',
			'ext' => 'Ext',
			'remark' => 'Remark',
                        'refno' => 'Ref #',
			'custsku' => 'Client #',
			'appmetwt' => 'App Met wt',
			'itemtype' => 'Item',
			'itemmetal' => 'Metal',
			'metalstamp' => 'Metal Stamp',
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

		$criteria->compare('idposkus',$this->idposkus);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('totamt',$this->totamt,true);
		$criteria->compare('stonevar',$this->stonevar,true);
		$criteria->compare('reforder',$this->reforder,true);
		$criteria->compare('usnum',$this->usnum,true);
		$criteria->compare('descrip',$this->descrip,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('remark',$this->remark,true);
                $criteria->compare('refno',$this->refno,true);
		$criteria->compare('custsku',$this->custsku,true);
		$criteria->compare('appmetwt',$this->appmetwt,true);
		$criteria->compare('itemtype',$this->itemtype,true);
		$criteria->compare('itemmetal',$this->itemmetal,true);
		$criteria->compare('metalstamp',$this->metalstamp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}