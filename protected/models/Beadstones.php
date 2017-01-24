<?php

/**
 * This is the model class for table "{{beadstones}}".
 *
 * The followings are the available columns in table '{{beadstones}}':
 * @property integer $idbeadstones
 * @property integer $idbeadsku
 * @property integer $idstone
 * @property integer $pieces
 * @property string $lgsize
 * @property string $smsize
 * @property string $remark
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 */
class Beadstones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Beadstones the static model class
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
		return '{{beadstones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idbeadsku, idstone,gem_wt', 'required'),
			array('idbeadsku, idstone, pieces, updby', 'numerical', 'integerOnly'=>true),
			array('lgsize, smsize', 'length', 'max'=>5),
			array('remark', 'length', 'max'=>256),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idbeadstones, idbeadsku, idstone, pieces, lgsize, smsize, remark, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
			'idsetting0' => array(self::BELONGS_TO, 'Setting', 'idsetting'),
			'idbead0' => array(self::BELONGS_TO, 'Bead', 'idbeadsku'),
			'idstone0' => array(self::BELONGS_TO, 'Stone', 'idstone'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbeadstones' => 'Idbeadstones',
			'idbeadsku' => 'Idbeadsku',
			'idstone' => 'Stone',
			'idsetting' =>'Setting',
			'pieces' => 'Pieces',
			'lgsize' => 'Longest Size',
			'smsize' => 'Small Size',
			'remark' => 'Remark',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'updby' => 'Updby',
			'gem_wt' =>'Gem Wt'
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

		$criteria->compare('idbeadstones',$this->idbeadstones);
		$criteria->compare('idbeadsku',$this->idbeadsku);
		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('pieces',$this->pieces);
		$criteria->compare('lgsize',$this->lgsize,true);
		$criteria->compare('smsize',$this->smsize,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}