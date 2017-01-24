<?php

/**
 * This is the model class for table "{{skustones}}".
 *
 * The followings are the available columns in table '{{skustones}}':
 * @property integer $idskustones
 * @property integer $idsku
 * @property integer $idstone
 * @property integer $pieces
 * @property integer $idsetting
 * @property string $type
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $height
 * @property string $diasize
 * @property string $mmsize
 * @property string $sievesize
 * The followings are the available model relations:
 * @property Setting $idsetting0
 * @property Sku $idsku0
 * @property Stone $idstone0
 */
class Skustones extends CActiveRecord
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
		return '{{skustones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku, idstone, pieces, idsetting', 'required'),
                        array('height,mmsize,diasize,sievesize', 'length', 'max'=>5),
			array('idsku,pieces, idsetting, updby', 'numerical', 'integerOnly'=>true),
			array('type','length', 'max'=>8),
			array('reviews','length', 'max'=>255),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskustones, idsku, idstone, pieces, height,mmsize, diasize, sievesize, idsetting, type, cdate, mdate, updby, reviews', 'safe', 'on'=>'search'),
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
			'idsetting0' => array(self::BELONGS_TO, 'Setting', 'idsetting'),
			'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
                        'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idskustones' => 'Idskustones',
			'idsku' => 'Idsku',
			'idstone' => 'Stone',
                        'height' => 'Height',
                        'mmsize' => 'MM Size',
                        'diasize' => 'Diagonal Size',
                        'sievesize' => 'Sieve Size',
			'pieces' => 'Pieces',
			'idsetting' => 'Setting',
			'type' => 'Type',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
                        'reviews' => 'Reviews',
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
                $criteria->with=array('idstone0','idsku0','idsetting0','iduser0');
		$criteria->compare('idskustones',$this->idskustones);
		$criteria->compare('idsku0.skucode',$this->idsku);
		$criteria->compare('idstone0.namevar',$this->idstone);
		$criteria->compare('pieces',$this->pieces);
		$criteria->compare('idsetting0.name',$this->idsetting);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('iduser0.username',$this->updby);
                $criteria->compare('height',$this->height,true);
                $criteria->compare('mmsize',$this->mmsize,true);
                $criteria->compare('diasize',$this->diasize,true);
                $criteria->compare('sievesize',$this->sievesize,true);
                $criteria->compare('reviews',$this->reviews,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getTypes(){
            return array(
                'Accent'=>'Accent',
                'Center'=>'Center',
            );
        }
}