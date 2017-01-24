<?php

/**
 * This is the model class for table "{{accesstime}}".
 *
 * The followings are the available columns in table '{{accesstime}}':
 * @property integer $id
 * @property integer $logintime
 * @property integer $iduser
 */
class Accesstime extends CActiveRecord
{
    public $firstname;
    public $lastname;
    public $username;
    public $logintime;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{accesstime}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id,logintime, iduser', 'required'),
			array('logintime, iduser', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logintime, iduser', 'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'User', 'iduser'),
                        'total_loggedin'=>array(self::STAT,'Accesstime','id'),
                    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'logintime' => 'Logintime',
			'iduser' => 'Iduser',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('logintime',$this->logintime,true);
		$criteria->compare('iduser',$this->iduser);
                
                $criteria->compare('firstname', $this->firstname, true);
                //$criteria->with=array('users');
               
                $criteria->compare('username',$this->username);
                $criteria->addCondition('iduser ='.$id);
                $criteria->order='logintime DESC';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accesstime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
