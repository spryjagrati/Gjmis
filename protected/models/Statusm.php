<?php

/**
 * This is the model class for table "{{statusm}}".
 *
 * The followings are the available columns in table '{{statusm}}':
 * @property integer $idstatusm
 * @property string $name
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Po[] $pos
 * @property Poskustatus[] $poskustatuses
 * @property Poskustatuslog[] $poskustatuslogs
 * @property Postatuslog[] $postatuslogs
 * @property Statusnav[] $statusnavs
 */
class Statusm extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Statusm the static model class
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
		return '{{statusm}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type', 'required'),
			array('name', 'length', 'max'=>45),
			array('type', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstatusm, name, type', 'safe', 'on'=>'search'),
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
			'pos' => array(self::HAS_MANY, 'Po', 'idstatusm'),
			'poskustatuses' => array(self::HAS_MANY, 'Poskustatus', 'idstatusm'),
			'poskustatuslogs' => array(self::HAS_MANY, 'Poskustatuslog', 'idstatusm'),
			'postatuslogs' => array(self::HAS_MANY, 'Postatuslog', 'idstatusm'),
			'statusnavs' => array(self::HAS_MANY, 'Statusnav', 'idstatust'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstatusm' => 'Idstatusm',
			'name' => 'Name',
			'type' => 'Type',
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

		$criteria->compare('idstatusm',$this->idstatusm);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getTypes(){
            return array(
                'PO'=>'PO',
                'ITEM'=>'ITEM',
                'REQ'=>'REQ',
            );
        }

        /* This function is needed by the ComSpry::getTypenameStatusms to get the typename property of this model
         * 
         */
        public function getTypename(){
            return $this->type.'-'.$this->name;
        }
}