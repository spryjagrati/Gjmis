<?php

/**
 * This is the model class for table "{{beadimages}}".
 *
 * The followings are the available columns in table '{{beadimages}}':
 * @property integer $idbeadimages
 * @property integer $idbeadsku
 * @property string $image
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 */
class Beadimages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Beadimages the static model class
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
		return '{{beadimages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idbeadsku, image, type', 'required'),
			array('idbeadsku, updby', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>128),
			array('type', 'length', 'max'=>4),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idbeadimages, idbeadsku, image, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
			//'idclient0' => array(self::BELONGS_TO, 'Client', 'idclient'),
			'idbead0' => array(self::BELONGS_TO, 'Bead', 'idbeadsku'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbeadimages' => 'Idbeadimages',
			'idbeadsku' => 'Idbeadsku',
			'image' => 'Image',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'updby' => 'Updby',
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idbeadimages',$this->idbeadimages);
		$criteria->compare('idbeadsku',$this->idbeadsku);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider($this, array(
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
        return Yii::app()->baseUrl."/bead_images/".Client::getClientImgFolder(null) . 'thumb'."/".$this->image;
    }

    public function getImageUrl(){
        return Yii::app()->baseUrl."/bead_images/".Client::getClientImgFolder(null) . Client::getClientStdImgSize(null)."/".$this->image;
    }
 }