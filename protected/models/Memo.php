<?php

/**
 * This is the model class for table "{{memo}}".
 *
 * The followings are the available columns in table '{{memo}}':
 * @property integer $idmemo
 * @property string $code
 * @property integer $iddptfrom
 * @property integer $memoto
 * @property string $remark
 * @property integer $status
 * @property integer $type
 * @property string $memoreturn
 * @property string $returndate
 * @property string $cdate
 * @property string $mdate
 * @property integer $createdby
 * @property integer $updatedby
 */
class Memo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Memo the static model class
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
		return '{{memo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, iddptfrom, memoto, status, type, createdby, updatedby', 'required'),
			array('iddptfrom, status, type, createdby, updatedby, idmetalm', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>64),
			array('remark, memoto', 'length', 'max'=>512),
			array('memoreturn', 'length', 'max'=>2),
			array('returndate, cdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idmemo, code, iddptfrom, memoto, remark, status, type, memoreturn, returndate, cdate, mdate, createdby, updatedby', 'safe', 'on'=>'search'),
		);
	}
        
        /**
         * defining scopes for the model
         */
        public function scopes(){
            return array(
                'approval' => array(
                    'condition' => 'type=1',
                ),
                'quote' => array(
                    'condition' => 'type=2',
                )
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
                    'iddept' => array(self::BELONGS_TO, 'Dept', 'iddptfrom'),
                    'metalm' => array(self::BELONGS_TO, 'Metalm', 'idmetalm'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idmemo' => 'Idmemo',
			'code' => 'Code',
			'iddptfrom' => 'Dept From',
			'memoto' => 'To',
			'remark' => 'Remark',
			'status' => 'Status',
			'type' => 'Type',
			'memoreturn' => 'Memoreturn',
			'returndate' => 'Returndate',
			'cdate' => 'Cdate',
			'mdate' => 'Mdate',
			'createdby' => 'Createdby',
			'updatedby' => 'Updatedby',
			'idmetalm' => 'Metal Type',
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

		$criteria->compare('idmemo',$this->idmemo);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('iddptfrom',$this->iddptfrom);
		$criteria->compare('memoto',$this->memoto);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('memoreturn',$this->memoreturn,true);
		$criteria->compare('returndate',$this->returndate,true);
		$criteria->compare('cdate',$this->cdate,true);
		$criteria->compare('mdate',$this->mdate,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updatedby',$this->updatedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * behaviors expressed by the model
         */
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
	            'createdByColumn' => 'createdby',
	            'updatedByColumn' => 'updatedby',
	        ),
	    );
	}
        
        public function approved(){
            $this->type = 1;
            return $this;
        }
        
        public function quotified(){
            $this->type = 2;
            return $this;
        }
        
        public function codify(){
            if (!isset($this->code)){
                $this->code = $this->getCode();
            }
            return $this;
        }
        
        public function getStatus($type){
            if($type == 1){
                return  array(1=>"Active", 2=>"Inactive");
            }else{
                return  array(1=>"Active", 2=>"Inactive", 3 => 'Returned');
            }
            
        }
        
        private function getCode(){
           preg_match_all('#(?<=\s|\b)\pL#u', Dept::model()->findbypk($this->iddptfrom)->name, $result);
           
           if($this->type == 2){
               $code = 'Q';
           }else{
               $code = 'M';
           }
           
           $code .= implode('', $result[0]);
           $code .= ' '.(Memo::model()->count('iddptfrom = :dpt and cdate >= :crdate and cdate < :brdate and type = :type', array(':dpt' => $this->iddptfrom, ':crdate' => date('Y').'-01-01', ':brdate' => date('Y-m-d', strtotime(' +1 day')), ':type' => $this->type)) + 1);
           $code .= '/'.date('y').'-'.(date('y')+1);
           return $code;
        }
        
        public function metalConversionArray(){
            return array(
                '.925 Silver' => array(
                    '9K Gold' => 0,
                    '10K Gold' => (15/100),
                    '14K Gold' => (25/100),
                    '18K Gold' => (50/100),
                    '22K Gold' => (75/100),
                ),
                '10K Gold' => array(
                    '14K Gold' => (10/100),
                    '18K Gold' => (35/100),
                    '22K Gold' => (60/100),
                ),
                '14K Gold' => array(
                    '18K Gold' => (25/100),
                    '22K Gold' => (50/100),
                ),
            );
        }
}