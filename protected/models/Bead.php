<?php

/**
 * This is the model class for table "{{beadsku}}".
 *
 * The followings are the available columns in table '{{beadsku}}':
 * @property integer $idbeadsku
 * @property string $beadskucode
 * @property string $dimhei
 * @property string $dimwid
 * @property string $dimlen
 * @property string $grosswt
 * @property string $totmetalwei
 * @property string $totstowei
 * @property integer $numstones
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 */
class Bead extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bead the static model class
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
		return '{{beadsku}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('beadskucode,totmetalwei', 'required'),
			array('numstones, updby', 'numerical', 'integerOnly'=>true),
			array('beadskucode', 'length', 'max'=>128),
			array('type', 'length', 'max'=>45),
			array('sub_category', 'length', 'max'=>128),
			array('size', 'length', 'max'=>45),
			array('dimhei, dimwid, dimlen', 'length', 'max'=>5),
			array('grosswt , magnetwt', 'length', 'max'=>9),
			array('totmetalwei, totstowei', 'length', 'max'=>7),
			array('cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idbeadsku, beadskucode, dimhei, dimwid, dimlen, grosswt, totmetalwei, totstowei, numstones, cdate, mdate, updby', 'safe', 'on'=>'search'),
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
			'beadimages' => array(self::HAS_MANY, 'Beadimages', 'idbeadsku'),
			'beadmetals' => array(self::HAS_MANY, 'Beadmetals', 'idbeadsku'),
			'beadfinding' => array(self::HAS_MANY, 'Beadfinding', 'idbeadsku'),
			'beadstones' => array(self::HAS_MANY, 'Beadstones', 'idbeadsku'),
			'metals' => array(self::HAS_MANY, 'Metal',array('idmetal'=>'idmetal'), 'through'=> 'beadmetals'),
			'stones' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'beadstones'),
			'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idbeadsku' => 'Idbeadsku',
			'beadskucode' => 'SKU #',
			'type' => 'Type',
			'sub_category' => 'Sub Type',
			'size' => 'Size',
			'magnetwt' => 'Magnet wt',
			'dimhei' => 'Dimhei',
			'dimwid' => 'Dimwid',
			'dimlen' => 'Dimlen',
			'grosswt' => 'Gross wt',
			'totmetalwei' => 'Tot Metal wt',
			'totstowei' => 'Tot Stone wt',
			'numstones' => 'Num Stones',
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

		$criteria->compare('idbeadsku',$this->idbeadsku);
		$criteria->compare('beadskucode',$this->beadskucode,true);
		$criteria->compare('dimhei',$this->dimhei,true);
		$criteria->compare('dimwid',$this->dimwid,true);
		$criteria->compare('dimlen',$this->dimlen,true);
		$criteria->compare('grosswt',$this->grosswt,true);
		$criteria->compare('totmetalwei',$this->totmetalwei,true);
		$criteria->compare('totstowei',$this->totstowei,true);
		$criteria->compare('numstones',$this->numstones);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTypes(){
        return CHtml::listData(Category::model()->findAll('parent=:parent', array(':parent' =>0)),'category','category');
    } 

    public function getSubtypes(){
        return CHtml::listData(Category::model()->findAll('parent <> 0'), 'category', 'category');
    } 

    public function topStoneWeightNum(){
        $stodata = Bead::model()->getDbConnection()->createCommand('select sum(st.weight*ss.pieces) wt, sum(ss.pieces) ns from {{beadstones}} ss, {{stone}} st where idbeadsku=' . $this->idbeadsku . ' and ss.idstone=st.idstone')->queryRow();
        return $stodata;
    }
}