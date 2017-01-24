<?php

/**
 * This is the model class for table "{{invoicereturn}}".
 *
 * The followings are the available columns in table '{{invoicereturn}}':
 * @property integer $idinvoicereturn
 * @property integer $idinvoice
 * @property integer $idpo
 * @property integer $idsku
 * @property integer $returnqty
 * @property integer $idinvoiceposku
 */
class Invoicereturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoicereturn the static model class
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
		return '{{invoicereturn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idinvoice, idpo, idsku, returnqty, idinvoiceposku', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idinvoicereturn, idinvoice, idpo, idsku, returnqty, idinvoiceposku', 'safe', 'on'=>'search'),
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
                    'idsku0' => array(self::BELONGS_TO, 'Sku', 'idsku'),
                    'idinvoicespokus0' => array(self::BELONGS_TO, 'Invoiceposkus', 'idinvoiceposku'),
                    'idinvoice0' => array(self::BELONGS_TO, 'Invoice', 'idinvoice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idinvoicereturn' => 'Idinvoicereturn',
			'idinvoice' => 'Idinvoice',
			'idpo' => 'Idpo',
			'idsku' => 'Idsku',
			'returnqty' => 'Returnqty',
			'idinvoiceposku' => 'Idinvoiceposku',
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

		$criteria->compare('idinvoicereturn',$this->idinvoicereturn);
		$criteria->compare('idinvoice',$this->idinvoice);
		$criteria->compare('idpo',$this->idpo);
		$criteria->compare('idsku',$this->idsku);
		$criteria->compare('returnqty',$this->returnqty);
		$criteria->compare('idinvoiceposku',$this->idinvoiceposku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getSkuStocks(){
            
            $locationstocks = Locationstocks::model()->findByAttributes(array('idsku'=>$this->idsku, 'po_num'=>$this->idpo, 'iddept'=>$this->idinvoice0->idlocation));
            
            return $locationstocks->totqty-$locationstocks->qtyship;
        }
}