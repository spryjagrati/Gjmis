<?php

/**
 * This is the model class for table "{{invoice}}".
 *
 * The followings are the available columns in table '{{invoice}}':
 * @property integer $idinvoice
 * @property integer $idpo
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $activ
 *
 * The followings are the available model relations:
 * @property Po $idpo0
 */
class Invoice extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Invoice the static model class
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
            return '{{invoice}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idlocation', 'required'),
                    array('updby, activ', 'numerical', 'integerOnly'=>true),
                    array('extname', 'length', 'max'=>256),
                    array('idpo', 'length', 'max'=>32),
                    array('cdate, mdate', 'safe'),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('idinvoice,invoice_num,idlocation,retrn,ship, cdate, mdate, updby, activ, createdby', 'safe', 'on'=>'search'),
            );
    }

    /***
     * spry behaviours
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
                    'idlocation0' => array(self::BELONGS_TO, 'Locations', 'idlocation'),
                    'iddept0' => array(self::BELONGS_TO, 'Dept', 'idlocation'),
                    'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
                    'locusers' => array(self::HAS_MANY, 'User', ['idlocation'=>'idlocation']),
                    'idlocationinvoice0' => array(self::HAS_ONE, 'Locationinvoice', 'idinvoice'),
                    'totalSkus' => array(self::STAT, 'Invoiceposkus', 'idinvoice','select'=> 'SUM(shipqty)','condition'=>'activ=1'),
                    'invoicePoskus' => array(self::HAS_MANY, 'Invoiceposkus','idinvoice')
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'idinvoice' => 'Idinvoice',
                    'cdate' => 'Create',
                    'idpo' => 'PO #',
                    'mdate' => 'Modifies',
                    'updby' => 'Update By',
                    'activ' => 'Activ',
                    'idlocation'=> 'Location',
                    'deptto'=> 'Dept To',
                    'createdby' => 'Created By',
                    'idsku' => 'SKU ID',
                    'retrn' => 'Return',
                    'ship' => 'Ship',
                    'invoice_num'=>'Invoice Number',
                    'extname'=>'External Name'
            );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
            $criteria=new CDbCriteria;
            $criteria->with=array('iddept0','iduser0','idlocation0');
            $criteria->together = true;
            $criteria->compare('idlocation0.idusers',1);
            $criteria->compare('idinvoice',$this->idinvoice);
            $criteria->compare('cdate',$this->cdate,true);
            $criteria->compare('mdate',$this->mdate,true);
            $criteria->compare('iduser0.username',$this->updby,true);
            $criteria->compare('invoice_num',$this->invoice_num);
            $criteria->compare('activ',$this->activ);
            $criteria->compare('createdby',$this->createdby);
            $criteria->compare('iddept0.location',$this->idlocation);
            $criteria->compare('retrn',$this->retrn);
            $criteria->compare('ship',$this->ship);

            return new CActiveDataProvider(get_class($this), array(
                    'criteria'=>$criteria,
            ));
    }


    public function searchInvoices()
    {
        $criteria=new CDbCriteria;
        $id= Yii::app()->user->id;
        $user=User::model()->findByPk($id);
        
        if($id !== '1'){
            $criteria->compare('idlocation', $user['iddept']);
            $criteria->compare('createdby',$id);  
        }
        
        $criteria->compare('idinvoice',$this->idinvoice);
        $criteria->compare('cdate',$this->cdate,true);
        $criteria->compare('mdate',$this->mdate,true);
        $criteria->compare('invoice_num',$this->invoice_num);
        $criteria->compare('retrn',$this->retrn);
        $criteria->compare('ship',$this->ship);
        return new CActiveDataProvider(get_class($this), array(
                'criteria'=>$criteria,
        ));
    }


    /**
     * Defining scopes
     */
    public function scopes() {
        return array(
            'latest'=>array(
                  'order'=>'cdate DESC',
                  'limit'=>1,
            ),
        );
    }

    /* get total invoice amount */
    public function getTotalAmount() {
        $invoiceposkus = $this->invoicePoskus;
        $totalskuprice = 0;

        foreach($invoiceposkus as $invoiceposku){
            if($invoiceposku->activ == 1){
                if($this->iddept0->idlocation == 1){
                    $totalskuprice +=  ($invoiceposku->shipqty * (ComSpry::calcSkuCost($invoiceposku->idsku)));

                }else{
                    $locationstocks = Deptskulog::model()->findByAttributes(array('idsku'=>$invoiceposku->idsku,'iddept'=>$this->idlocation,'po_num'=>$invoiceposku->idpo));
                    if (isset($locationstocks))
                        $totalskuprice +=  ($invoiceposku->shipqty * ($locationstocks->pricepp));

                }
            }
        }

        if(!empty($totalskuprice)){
            return(round($totalskuprice ,2));
        }
    }

    /**
     * get total invoice amount
     */
    public function getTotalPrice() {
        $invoiceposkus = $this->invoicePoskus;
        $totalskuprice1 = array();
        $totalskuprice2 = array();
        $movement = false;
        
        foreach($invoiceposkus as $invoiceposku){
            if($invoiceposku->activ == 1){
                if($invoiceposku->movements==1){
                    $movement = true;
                    $deptskulog = Deptskulog::model()->findByAttributes(array('idsku' => $invoiceposku->idsku, 'iddept' => $invoiceposku->idinvoice0->idlocation, 'po_num' => $invoiceposku->idinvoice0->idpo), 'pricepp > 0');
                    
                    if (isset($deptskulog))
                        $totalskuprice1[] = $invoiceposku->shipqty * $deptskulog->pricepp;
                }
                else if($invoiceposku->movements==2){
                    $deptskulog = Deptskulog::model()->findByAttributes(array('idsku' => $invoiceposku->idsku, 'iddept' => $invoiceposku->idinvoice0->idlocation, 'po_num' => $invoiceposku->idinvoice0->idpo), 'pricepp > 0');
                    
                    if (isset($deptskulog))
                        $totalskuprice2[] = $invoiceposku->shipqty * $deptskulog->pricepp;
                }
            }
        }
        
        if(!empty($totalskuprice1) && $movement){
            return(round(array_sum($totalskuprice1) ,2));
        }
        else if(!empty($totalskuprice2) && !$movement){
            return(round(array_sum($totalskuprice2) ,2));
        }
    }
}
