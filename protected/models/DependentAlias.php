<?php

/**
 * This is the model class for table "{{dependent_alias}}".
 *
 * The followings are the available columns in table '{{dependent_alias}}':
 * @property integer $id
 * @property integer $idaliases
 * @property string $column
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Aliases $idaliases0
 */
class DependentAlias extends CActiveRecord
{
    
      public $target;
      public $field;
      public $primary;
      
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dependent_alias}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idaliases, column', 'required'),
			array('idaliases', 'numerical', 'integerOnly'=>true),
			array('column, alias', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idaliases, column, alias, target, field, primary', 'safe', 'on'=>'search'),
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
			'idaliases0' => array(self::BELONGS_TO, 'Aliases', 'idaliases'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idaliases' => 'Idaliases',
			'column' => 'Column',
			'alias' => 'Value',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with[] = 'idaliases0';
                
		$criteria->compare('t.column',$this->column,true);
		$criteria->compare('t.alias',$this->alias,true);
                
                $criteria->compare( 'idaliases0.aTarget', $this->target);
                $criteria->compare( 'idaliases0.aField', $this->field, true );
                $criteria->compare( 'idaliases0.initial', $this->primary, true );
                //return print_r($criteria); die(); 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DependentAlias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
