<?php

/**
 * This is the model class for table "{{skucontent}}".
 *
 * The followings are the available columns in table '{{skucontent}}':
 * @property integer $idskucontent
 * @property integer $idsku
 * @property string $name
 * @property string $brand
 * @property string $descr
 * @property string $type
 * @property string $usedfor
 * @property string $attributedata
 * @property string $targetusers
 * @property string $searchterms
 * @property string $resizable
 * @property string $sizelowrange
 * @property string $sizeupprange
 * @property string $chaintype
 * @property string $clasptype
 * @property string $backfinding
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $size
 *
 * The followings are the available model relations:
 * @property Sku $idsku0
 */
class Skucontent extends CActiveRecord
{
	public $inputfile;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skucontent the static model class
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
		return '{{skucontent}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku, name, descr, type', 'required'),
			array('idsku, updby', 'numerical', 'integerOnly'=>true),
			array('name, brand, type, sizelowrange, sizeupprange, size, backfinding', 'length', 'max'=>45),
			array('chaintype, clasptype', 'length', 'max'=>35),
			array('descr,review, usedfor, attributedata, targetusers, searchterms', 'length', 'max'=>256),
			array('resizable', 'length', 'max'=>1),
			array('cdate,idkeywords,inputfile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskucontent,review, idkeywords, idsku, name, brand, descr, type, usedfor, attributedata, targetusers, searchterms, resizable, sizelowrange, sizeupprange, chaintype, clasptype, backfinding, cdate, mdate, updby, size', 'safe', 'on'=>'search'),
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
            'idkeywords0' => array(self::BELONGS_TO, 'Keywords', 'idkeywords'), //25 sept,2014
			
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
			'idskucontent' => 'Idskucontent',
			'idsku' => 'Idsku',
			'name' => 'Name',
			'brand' => 'Brand',
			'descr' => 'Title',
			'type' => 'Type',
			'usedfor' => 'Used For',
			'attributedata' => 'Attributes',
			'targetusers' => 'Target Users',
			'searchterms' => 'Bullet points',
			'resizable' => 'Resizable',
			'sizelowrange' => 'Size lowrange',
			'sizeupprange' => 'Size upprange',
			'chaintype' => 'Chain Type',
			'clasptype' => 'Clasp Type',
			'backfinding' => 'Back Finding',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'size' => 'Size',
            'idkeywords'=>'Keyword',
            'review'=>'Review',
            'inputfile'=>'Upload File',
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

		$criteria->compare('idskucontent',$this->idskucontent);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('usedfor',$this->usedfor,true);
		$criteria->compare('attributedata',$this->attributedata,true);
		$criteria->compare('targetusers',$this->targetusers,true);
		$criteria->compare('searchterms',$this->searchterms,true);
		$criteria->compare('resizable',$this->resizable,true);
		$criteria->compare('sizelowrange',$this->sizelowrange,true);
		$criteria->compare('sizeupprange',$this->sizeupprange,true);
		$criteria->compare('chaintype',$this->chaintype,true);
		$criteria->compare('clasptype',$this->clasptype,true);
		$criteria->compare('backfinding',$this->backfinding,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('size',$this->size);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getResOpts(){
            return array(
                'Y'=>'Y',
                'N'=>'N',
            );
        }

       public function getTypes(){
            return CHtml::listData(Category::model()->findAll('parent=:parent', array(':parent' =>0)),'category','category');
        }
}
