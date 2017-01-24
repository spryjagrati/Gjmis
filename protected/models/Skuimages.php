<?php

/**
 * This is the model class for table "{{skuimages}}".
 *
 * The followings are the available columns in table '{{skuimages}}':
 * @property integer $idskuimages
 * @property integer $idsku
 * @property string $image
 * @property string $imgalt
 * @property string $cdate
 * @property string $mdate
 * @property string $type
 * @property integer $updby
 * @property integer $idclient
 *
 * The followings are the available model relations:
 * @property Client $idclient0
 * @property Sku $idsku0
 */
class Skuimages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Skuimages the static model class
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
		return '{{skuimages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idsku, image, type', 'required'),
			array('idsku, updby, idclient', 'numerical', 'integerOnly'=>true),
			array('image, imgalt', 'length', 'max'=>128),
			array('type', 'length', 'max'=>4),
			array('cdate', 'safe'),
                        array('image','length', 'max'=>124, 'on'=>'duplicate'),
			array('image','file','types'=>'jpg,png','maxSize'=>1024 * 1024, 'tooLarge'=>'The file was larger than 1024KB. Please upload a smaller file.', 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idskuimages, idsku, image, imgalt, cdate, mdate, type, updby, idclient', 'safe', 'on'=>'search'),
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
			'idclient0' => array(self::BELONGS_TO, 'Client', 'idclient'),
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
			'idskuimages' => 'Idskuimages',
			'idsku' => 'Idsku',
			'image' => 'Image',
			'imgalt' => 'Alt Text',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'type' => 'Type',
			'updby' => 'Updated By',
			'idclient' => 'Client',
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

		$criteria->compare('idskuimages',$this->idskuimages);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('imgalt',$this->imgalt,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare('idclient',$this->idclient);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getTypes(){
            return array(
                'MISG'=>'MIS Gallery',
                'Gall'=>'Gallery',
                'Vgal'=>'Vgallery',
                'V1'=>'View1',
                'V2'=>'View2',
                'V3'=>'View3',
            );
        }

        public function getImageThumbUrl(){
            return Yii::app()->baseUrl."/images/".Client::getClientImgFolder($this->idclient) . 'thumb'."/".$this->image;
        }

        public function getImageUrl(){
            return Yii::app()->baseUrl."/images/".Client::getClientImgFolder($this->idclient) . Client::getClientStdImgSize($this->idclient)."/".$this->image;
        }
}