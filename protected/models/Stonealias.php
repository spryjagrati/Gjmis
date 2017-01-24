<?php

/**
 * This is the model class for table "{{stonealias}}".
 *
 * The followings are the available columns in table '{{stonealias}}':
 * @property integer $idstone_alias
 * @property integer $idstone
 * @property integer $export
 * @property integer $idproperty
 * @property string $alias
 */
class Stonealias extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{stonealias}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idstonem,export, idproperty, alias', 'required'),
			array('idstonem, export, idproperty', 'numerical', 'integerOnly'=>true),
			array('alias', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idstone_alias, idstonem, export, idproperty, alias', 'safe', 'on'=>'search'),
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
			'idstone_alias' => 'Idstone Alias',
			'idstonem' => 'Stone',
			'export' => 'Export',
			'idproperty' => 'Property',
			'alias' => 'Alias',
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

		$criteria->compare('idstone_alias',$this->idstone_alias);
		$criteria->compare('idstonem',$this->idstonem);
		$criteria->compare('export',$this->export);
		$criteria->compare('idproperty',$this->idproperty);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stonealias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getstone($idstonem){
//    	$name = '';
//        $stone = Stone::model()->find('idstone=:idstone', array(':idstone' => $idstone));
//        $name = $stone->namevar;
//        $shape = Shape::model()->find('idshape=:idshape', array(':idshape' => $stone->idshape));
//        $name = $name .'-'.$shape->name;
//        $size = Stonesize::model()->find('idstonesize=:idstonesize', array(':idstonesize' => $stone->idstonesize));
//        $name = $name . '-'.$size->size.'-'.$stone->quality;
//
//         return $name;
        $stone = Stonem::model()->find('idstonem=:idstonem',array(':idstonem' => $idstonem));
        return $stone->name;
    }

}
