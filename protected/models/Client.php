<?php

/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property integer $idclient
 * @property string $name
 * @property string $email
 * @property string $stimagesize
 * @property string $commission
 * @property string $imgfolder
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Clientparams[] $clientparams
 * @property Po[] $pos
 * @property Skuimages[] $skuimages
 * @property Skuselmap[] $skuselmaps
 */
class Client extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Client the static model class
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
		return '{{client}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, stimagesize, imgfolder,commission', 'required'),
			array('name, email', 'length', 'max'=>45),
			array('stimagesize', 'length', 'max'=>16),
			array('commission,imgfolder', 'length', 'max'=>4),
                    array('address', 'length', 'max'=>128),
                    array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idclient, name, email, stimagesize, commission, imgfolder', 'safe', 'on'=>'search'),
                    array('email','email'),
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
			'clientparams' => array(self::HAS_MANY, 'Clientparams', 'idclient'),
			'pos' => array(self::HAS_MANY, 'Po', 'idclient'),
			'skuimages' => array(self::HAS_MANY, 'Skuimages', 'idclient'),
			'skuselmaps' => array(self::HAS_MANY, 'Skuselmap', 'idclient'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idclient' => 'Idclient',
			'name' => 'Name',
			'email' => 'Email',
			'stimagesize' => 'Standard Image Dims',
			'commission' => 'Commission',
                    'imgfolder' => 'Img Folder',
                    'address' => 'Address',
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

		$criteria->compare('idclient',$this->idclient);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('stimagesize',$this->stimagesize,true);
		$criteria->compare('commission',$this->commission,true);
                $criteria->compare('imgfolder',$this->imgfolder,true);
                $criteria->compare('address',$this->address,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getClientImgFolder($id){
            return '';
        }


        public function getClientStdImgSize($id){
            return '650x650';
        }
}