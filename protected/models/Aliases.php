<?php

/**
 * This is the model class for table "{{aliases}}".
 *
 * The followings are the available columns in table '{{aliases}}':
 * @property integer $id
 * @property string $aTarget
 * @property string $aField
 * @property string $primary
 * @property string $alias
 * @property string $aSrcModel
 * @property string $aSrcField
 */
class Aliases extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{aliases}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('aTarget, aField, initial,option', 'required'),
			array('aTarget, aField, initial, alias', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, aTarget, aField, initial, alias, option', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'aTarget' => 'Target',
			'aField' => 'Field',
			'initial' => 'Primary',
			'alias' => 'Alias',
            'option'=>'Option',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('aTarget',$this->aTarget);
		$criteria->compare('aField',$this->aField,true);
		$criteria->compare('initial',$this->initial,true);
		$criteria->compare('alias',$this->alias,true);
        $criteria->compare('option',$this->option,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aliases the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
