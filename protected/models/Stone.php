<?php

/**
 * This is the model class for table "{{stone}}".
 *
 * The followings are the available columns in table '{{stone}}':
 * @property integer $idstone
 * @property integer $idshape
 * @property integer $idclarity
 * @property string $color
 * @property string $scountry
 * @property string $cut
 * @property string $type
 * @property string $quality
 * @property string $creatmeth
 * @property string $treatmeth
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property string $curcost
 * @property string $prevcost
 * @property integer $idstonem
 * @property integer $idstonesize
 * @property string $namevar
 * @property string $weight
 * @property string $month
 *
 * The followings are the available model relations:
 * @property Costadd[] $costadds
 * @property Deptstonelog[] $deptstonelogs
 * @property Skustones[] $skustones
 * @property Clarity $idclarity0
 * @property Shape $idshape0
 * @property Stonesize $idstonesize0
 * @property Stonem $idstonem0
 * @property Stonecostlog[] $stonecostlogs
 */
class Stone extends CActiveRecord
{
    
    
        public $stocks;
        public $oldattributes;
       
        
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stone the static model class
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
		return '{{stone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('curcost, idstonem, jewelry_type,idstonesize,idshape,namevar', 'required'),
			array('idshape, idclarity, updby, idstonem, idstonesize', 'numerical', 'integerOnly'=>true),
			array('color', 'length', 'max'=>20),
			array('creatmeth, treatmeth', 'length', 'max'=>64),
			array('cut, type, quality, ,month', 'length', 'max'=>16),
			array('curcost, prevcost', 'length', 'max'=>9),
            array('weight', 'length', 'max'=>9),
			array('namevar,scountry', 'length', 'max'=>64),
			array('cdate, mdate,weight,color,idshape,namevar', 'safe'),
			array('jewelry_type','stonesizevalidation', 'on'=>'insert,update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('weight,month ,idstone, idshape, idclarity, color, scountry, cut, type, quality, creatmeth, treatmeth, cdate, mdate, updby, curcost, prevcost, idstonem, idstonesize, namevar,review', 'safe', 'on'=>'search'),
		);


	}

	public function stonesizevalidation($attribute,$params){
		if($this->$attribute == 1){
			$req = CValidator::createValidator('required', $this, 'cut,weight,color,quality' );
			$req->validate( $this );
			
		}
		
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
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'costadds' => array(self::HAS_MANY, 'Costadd', 'idstone'),
			'deptstonelogs' => array(self::HAS_MANY, 'Deptstonelog', 'idstone'),
			'skustones' => array(self::HAS_MANY, 'Skustones', 'idstone'),
			'idclarity0' => array(self::BELONGS_TO, 'Clarity', 'idclarity'),
			'idshape0' => array(self::BELONGS_TO, 'Shape', 'idshape'),
			'idstonesize0' => array(self::BELONGS_TO, 'Stonesize', 'idstonesize'),
			'idstonem0' => array(self::BELONGS_TO, 'Stonem', 'idstonem'),
			'stonecostlogs' => array(self::HAS_MANY, 'Stonecostlog', 'idstone'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idstone' => 'Stone',
			'idshape' => 'Shape',
			'idclarity' => 'Clarity',
			'color' => 'Color',
			'scountry' => 'Country of Origin',
			'cut' => 'Cut',
			'type' => 'Type',
			'quality' => 'Grade',
			'creatmeth' => 'Creation Method',
			'treatmeth' => 'Gemstone Treatment',
			'cdate' => 'Created',
			'mdate' => 'Modified',
			'updby' => 'Updated By',
			'curcost' => 'Price',
			'prevcost' => 'Pre Price',
			'idstonem' => 'Gemstone',
			'idstonesize' => 'Size',
			'namevar' => 'Stone Alias',
            'weight' => 'Carat Wt',
            'month' => 'Month',
            'jewelry_type' => 'Jewelry Type',
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

		$criteria->compare('idstone',$this->idstone);
		$criteria->compare('idshape',$this->idshape);
		$criteria->compare('idclarity',$this->idclarity);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('scountry',$this->scountry,true);
		$criteria->compare('cut',$this->cut,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('quality',$this->quality,true);
		$criteria->compare('creatmeth',$this->creatmeth,true);
		$criteria->compare('treatmeth',$this->treatmeth,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('updby',$this->updby);
		$criteria->compare(('weight'!=0)?round(('curcost'/'weight'),2):'curcost',$this->curcost);
		$criteria->compare('prevcost',$this->prevcost,true);
		$criteria->compare('idstonem',$this->idstonem);
		$criteria->compare('idstonesize',$this->idstonesize);
		$criteria->compare('namevar',$this->namevar,true);
        $criteria->compare('weight',$this->weight);
        $criteria->compare('month',$this->month);
        $criteria->compare('jewelry_type',$this->jewelry_type);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function getName(){
            return $this->idstonem0->name.'-'.$this->idshape0->name.'-'.$this->idstonesize0->size.'-'.$this->quality;
        }
        
        public function afterFind() {
            $this->oldattributes = $this->attributes; 
        }
        
        public function afterSave() {
            if ($this->oldattributes['weight'] != $this->weight){
                foreach($this->skustones as $skustone){
                    $stodata = $skustone->idsku0->topStoneWeightNum();
                    $skustone->idsku0->totstowei = 0 + ($stodata['wt']);
                    $skustone->idsku0->numstones = 0 + ($stodata['ns']);
                    $stonewt = (0 + ($stodata['wt'])) / 5;
                    $skustone->idsku0->totmetalwei = $skustone->idsku0->grosswt - $stonewt;
                    $skustone->idsku0->save();
                    
                    $metal = Skumetals::model()->find('idsku=:idsku', array(':idsku' => $skustone->idsku));
                    $metal->weight = $skustone->idsku0->totmetalwei;
                    $metal->save();
                }
            }
        }
        public function hasCookie($name){
	      return !empty(Yii::app()->request->cookies[$name]->value);
	    }

	    public function getCookie($name){
	      return Yii::app()->request->cookies[$name]->value;
	    } 

	    public function setCookie($name, $value){
	      $cookie = new CHttpCookie($name,$value);
	      Yii::app()->request->cookies[$name] = $cookie;
	    }
	    public function removeCookie($name){
	    	unset(Yii::app()->request->cookies[$name]);
	    }

	    public function getChecked_admin($idstone){
	        $res=$this->hasCookie('save-selection-stone');
	       	if($res){ 
	            $cookie_data= $this->getCookie('save-selection-stone');
	            $cookie_data=stripslashes($cookie_data);
	            $cookie_data=  json_decode($cookie_data);
	         	return in_array($idstone,$cookie_data)?1:0;
	       	}
	       	else{
	           return false;
	       	}
    	}
	
}
