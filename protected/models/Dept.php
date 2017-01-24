<?php

/**
 * This is the model class for table "{{dept}}".
 *
 * The followings are the available columns in table '{{dept}}':
 * @property integer $iddept
 * @property string $name
 * @property string $location
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Deptmetallog[] $deptmetallogs
 * @property Deptstonelog[] $deptstonelogs
 * @property Poskustatus[] $poskustatuses
 * @property Poskustatuslog[] $poskustatuslogs
 */
class Dept extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Dept the static model class
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
		return '{{dept}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, location, type,idlocation', 'required'),
			array('name, location, phone', 'length', 'max'=>45),
			array('type', 'length', 'max'=>1),
                        array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iddept, name, location, type,idlocation, phone', 'safe', 'on'=>'search'),
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
			'deptmetallogs' => array(self::HAS_MANY, 'Deptmetallog', 'refsent'),
                        'idlocation0' => array(self::BELONGS_TO, 'Locations', 'idlocation'),
			'deptstonelogs' => array(self::HAS_MANY, 'Deptstonelog', 'refsent'),
			'poskustatuses' => array(self::HAS_MANY, 'Poskustatus', 'idprocdept'),
			'poskustatuslogs' => array(self::HAS_MANY, 'Poskustatuslog', 'idprocdept'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iddept' => 'Iddept',
			'name' => 'Name',
			'location' => 'Area',
			'type' => 'Type',
			'idlocation' => 'Location',
			'phone' => 'Phone',
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

		$criteria->compare('iddept',$this->iddept);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('location',$this->location,true);
		//$criteria->compare('type',$this->getDeptType($this->type));
                $criteria->compare('type',$this->type,true);
                $criteria->compare('idlocation',$this->idlocation,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getDeptTypes()
        {
            return array(
                'c'=>'cost entry',
                'm'=>'manufacturing',
                's'=>'sales',
                'w'=>'writing',
                'p'=>'procurement',
            );

        }

        public function getDeptTypeLabel($type)
        {
            $typeLables=array(
                'c'=>'cost entry',
                'm'=>'manufacturing',
                's'=>'sales',
                'w'=>'writing',
                'p'=>'procurement',
            );
            if(is_null($type) || $type==""){
                return null;
            }else{
                return $typeLables[substr($type, 0, 1)];
            }
        }

        /* This function is needed by the ComSpry::getTypeDepts to get the typename property of this model
         *
         */
        public function getLocname(){
            return $this->idlocation0->name.'-'.$this->name;
        }

        public function getDeptname($id){
            $dept = Dept::model()->findbypk($id);
            
            if($dept){
                return $dept->name.' - '.$dept->idlocation0->name;
            }
        }
}