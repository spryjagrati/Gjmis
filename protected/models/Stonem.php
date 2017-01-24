<?php

/**
 * This is the model class for table "{{stonem}}".
 *
 * The followings are the available columns in table '{{stonem}}':
 * @property integer $idstonem
 * @property string $name
 * @property string $type
 * @property string $scountry
 * @property string $creatmeth
 * @property string $treatmeth
 * The followings are the available model relations:
 * @property Stone[] $stones
 */
class Stonem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stonem the static model class
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
		return '{{stonem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>45),
                    array('treatmeth,scountry', 'length', 'max'=>64),
			array('type', 'length', 'max'=>16),
			array('creatmeth', 'length', 'max'=>64),
                    array('name','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idstonem, name, type', 'safe', 'on'=>'search'),
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
			'stones' => array(self::HAS_MANY, 'Stone', 'idstonem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstonem' => 'Idstonem',
			'name' => 'Name',
                    'type' => 'Type',
                    'scountry' => 'Source Country',
                    'creatmeth' => 'Create Method',
                    'treatmeth' => 'Treat Method',
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

		$criteria->compare('idstonem',$this->idstonem);
		$criteria->compare('name',$this->name,true);
                $criteria->compare('type',$this->type);
                $criteria->compare('scountry',$this->scountry,true);
                $criteria->compare('creatmeth',$this->creatmeth,true);
                $criteria->compare('treatmeth',$this->treatmeth);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTypes(){
            return array(
                'precious'=>'precious',
                'semi-precious'=>'semi-precious',
                'diamond'=>'diamond',
            );
        }
}
