<?php

/**
 * This is the model class for table "{{sku}}".
 *
 * The followings are the available columns in table '{{sku}}':
 * @property integer $idsku
 * @property string $skucode
 * @property string $tdnum
 * @property string $cdate
 * @property string $mdate
 * @property integer $updby
 * @property integer $leadtime
 * @property string $refpo
 * @property integer $parentsku
 * @property string $parentrel
 * @property string $taxcode
 * @property string $dimunit
 * @property string $dimdia
 * @property string $dimhei
 * @property string $dimwid
 * @property string $dimlen
 * @property string $totmetalwei
 * @property string $metweiunit
 * @property string $totstowei
 * @property string $stoweiunit
 * @property integer $numstones
 * @property string $grosswt
 * The followings are the available model relations:
 * @property Poskus[] $poskuses
 * @property Po $refpo0
 * @property Sku $parentsku0
 * @property Sku[] $skus
 * @property Skuaddon[] $skuaddons
 * @property Skucontent[] $skucontents
 * @property Skuimages[] $skuimages
 * @property Skumetals[] $skumetals
 * @property Skuselmap[] $skuselmaps
 * @property Skustones[] $skustones
 */
class Sku extends CActiveRecord
{
    
    
    public $type;
    public $gemstone;
    public $met_not_more;
    public $met_not_less;
    public $gem_shape;
    public $gem_size;
    public $sku_size;
    public $sku_metals;
    public $stone_check;
    public $stone_check2;
    public $stone_check3;
    public $stone_check4;
    public $totcost;
    public $keyword;
    public $wt_to;
    public $wt_from;
    public $gemstone2;
    public $gem_size2;
    public $gem_shape2;
    public $gemwt;
    public $diawt;
    public $finding;
    public $tot_cost;
    public $cost_not_more;
    public $cost_not_less;
    
    /**
     * Returns the static model of the specified AR class.
     * @return Sku the static model class
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
        return '{{sku}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('skucode', 'required'),
            array('updby, leadtime,  parentsku, numstones, ', 'numerical', 'integerOnly'=>true),
            array('skucode,  parentrel, taxcode', 'length', 'max'=>45),
            array('skucode, sub_category', 'length', 'max'=>128),
            array('dimunit, metweiunit, stoweiunit', 'length', 'max'=>16),
            array('tdnum , refpo, gemstone2, gem_size2, gem_shape2', 'length', 'max'=>120),
            array('dimdia, dimhei, dimwid, dimlen', 'length', 'max'=>5),
            array('grosswt, totstowei, totmetalwei', 'length', 'max'=>9),
            array('cdate,tot_cost', 'safe'),
            array('skucode','unique','message'=>'Duplicate SkuCode exists'),
           // array('tot_cost', 'length', 'max'=>11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('idsku,gemstone2,gem_size2,gem_shape2,stone_check,stone_check3,stone_check4,stone_check2,wt_from,keyword,wt_to, skucode,tdnum,height, met_not_more,met_not_less,mmsize, diasize, sievesize, cdate, mdate, updby, leadtime, refpo, parentsku, parentrel, taxcode, dimunit, dimdia, dimhei, dimwid, dimlen, totmetalwei, metweiunit, totstowei, stoweiunit, numstones, type, gemstone, gem_shape, gem_size, sku_size, sku_metals, sub_category,finding ,cost_not_more,cost_not_less', 'safe', 'on'=>'search'),
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
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'poskuses' => array(self::HAS_MANY, 'Poskus', 'idsku'),
            'parentsku0' => array(self::BELONGS_TO, 'Sku', 'parentsku'),
            'skus' => array(self::HAS_MANY, 'Sku', 'parentsku'),
            'skuaddons' => array(self::HAS_MANY, 'Skuaddon', 'idsku'),
            'skucontent' => array(self::HAS_ONE, 'Skucontent', 'idsku'),
            'skuimages' => array(self::HAS_MANY, 'Skuimages', 'idsku'),
            'skumetals' => array(self::HAS_MANY, 'Skumetals', 'idsku'),
            'skuselmaps' => array(self::HAS_MANY, 'Skuselmap', 'idsku'),
            'skufindings' => array(self::HAS_MANY, 'Skufindings', 'idsku'),
            'skustones' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'skustones2' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'skustones3' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'skustones4' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'skustones5' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'skustones6' => array(self::HAS_MANY, 'Skustones', 'idsku'),
            'stones' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones'),
            'stones2' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones2'),
            'stones3' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones3'),
            'stones4' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones4'),
            'stones5' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones5'),
            'stones6' => array(self::HAS_MANY, 'Stone', array('idstone'=>'idstone'), 'through'=>'skustones6'),
            'keywords' => array(self::HAS_MANY, 'Keywords', array('idkeywords'=>'id'), 'through'=>'skucontent'),
            'sizes' => array(self::HAS_MANY, 'Stonesize', array('idstonesize'=>'idstonesize'), 'through'=>'stones'),
            'sizes2' => array(self::HAS_MANY, 'Stonesize', array('idstonesize'=>'idstonesize'), 'through'=>'stones4'),
            'sizes3' => array(self::HAS_MANY, 'Stonesize', array('idstonesize'=>'idstonesize'), 'through'=>'stones3'),
            'sizes4' => array(self::HAS_MANY, 'Stonesize', array('idstonesize'=>'idstonesize'), 'through'=>'stones6'),
            'shapes' => array(self::HAS_MANY, 'Shape', array('idshape'=>'idshape'), 'through'=>'stones2'),
            'shapes2' => array(self::HAS_MANY, 'Shape', array('idshape'=>'idshape'), 'through'=>'stones5'),
            'shapes3' => array(self::HAS_MANY, 'Shape', array('idshape'=>'idshape'), 'through'=>'stones3'),
            'shapes4' => array(self::HAS_MANY, 'Shape', array('idshape'=>'idshape'), 'through'=>'stones4'),
            'iduser0' => array(self::BELONGS_TO, 'User', 'updby'),
            'metals' => array(self::HAS_MANY, 'Metal',array('idmetal'=>'idmetal'), 'through'=> 'skumetals'),
            'skureviews' => array(self::HAS_MANY, 'Skureviews', 'idsku'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idsku' => 'Idsku',
            'skucode' => 'SKU#',
            'tdnum' => 'TD #',
            'cdate' => 'Created',
            'mdate' => 'Modified',
            'updby' => 'Created By',
            'leadtime' => 'Lead Time',
            'refpo' => 'Ref#',
            'parentsku' => 'Parent SKU',
            'parentrel' => 'Relation',
            'taxcode' => 'Taxcode',
            'dimunit' => 'Unit',
            'dimdia' => 'Dia',
            'dimhei' => 'Height',
            'dimwid' => 'Width',
            'dimlen' => 'Length',
            'totmetalwei' => 'Tot Metal wt',
            'metweiunit' => 'Metal wt Unit',
            'totstowei' => 'Tot Stone wt',
            'stoweiunit' => 'Stone wt Unit',
            'numstones' => 'Num Stones',
            'grosswt' => 'Gross Wt',
            'gem_shape' => 'Shape',
            'gem_size' => 'Size',
            'gem_shape2' => 'Shape2',
            'gem_size2' => 'Size2',
            'sku_metals' => 'Metals',
            'met_not_less' => 'Metal Wt. Not Less Than',
            'met_not_more' => 'Metal Wt. Not More Than',
            'totcost'=>'Total cost',
            'sub_category' => 'Sub Type',
            'wt_from'=>'Stone Wt From',
            'wt_to'=>'To',
            'gemwt' =>'Tot Gem wt',
            'diawt' => 'Tot Diamond wt',
            'tot_cost'=>'Sku Cost',
            'cost_not_less' => 'Cost Not Less Than',
            'cost_not_more' => 'Cost Not More Than',
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
            if(!empty($this->met_not_less)){
                  $criteria->addCondition("totmetalwei > :met_not_less");
                  $criteria->params[':met_not_less']=$this->met_not_less;
            }
            if(!empty($this->met_not_more)){
                  $criteria->addCondition("totmetalwei < :met_not_more ");
                  $criteria->params[':met_not_more']=$this->met_not_more;
            }
            if(!empty($this->updby)){
                $criteria->with[] = 'iduser0';
                $criteria->compare('iduser0.username',$this->updby);
            }
            if(!empty($this->wt_to) && empty($this->wt_from) ){
                    $criteria->addCondition("totstowei <= :wt_to ");
                    $criteria->params[':wt_to']=$this->wt_to;
            }
            if(empty($this->wt_to) && !empty($this->wt_from) ){
                    $this->totstowei = $this->wt_from;
            }
            if(!empty($this->wt_from) && !empty($this->wt_to)){
                  $criteria->addCondition("totstowei >= :wt_from");
                  $criteria->params[':wt_from']=$this->wt_from;

                  $criteria->addCondition("totstowei <= :wt_to ");
                  $criteria->params[':wt_to']=$this->wt_to;
            }
            if(!empty($this->cost_not_less)){
                  $criteria->addCondition("tot_cost > :cost_not_less");
                  $criteria->params[':cost_not_less']=$this->cost_not_less;
            }
            if(!empty($this->cost_not_more)){
                  $criteria->addCondition("tot_cost < :cost_not_more ");
                  $criteria->params[':cost_not_more']=$this->cost_not_more;
            }
            
            $criteria->compare('idsku',$this->idsku);
            $criteria->compare('skucode',$this->skucode,true);
            $criteria->compare('tdnum',$this->tdnum,true);
            $criteria->compare('cdate',$this->cdate,true);
            $criteria->compare('mdate',$this->mdate,true);
            $criteria->compare('leadtime',$this->leadtime);
            $criteria->compare('refpo',$this->refpo);
            $criteria->compare('parentsku',$this->parentsku);
            $criteria->compare('parentrel',$this->parentrel,true);
            $criteria->compare('taxcode',$this->taxcode,true);
            $criteria->compare('dimunit',$this->dimunit,true);
            $criteria->compare('dimdia',$this->dimdia,true);
            $criteria->compare('dimhei',$this->dimhei,true);
            $criteria->compare('dimwid',$this->dimwid,true);
            $criteria->compare('dimlen',$this->dimlen,true);
            $criteria->compare('totmetalwei',$this->totmetalwei,true);
            $criteria->compare('metweiunit',$this->metweiunit,true);
            $criteria->compare('totstowei',$this->totstowei,true);
            $criteria->compare('stoweiunit',$this->stoweiunit,true);
            $criteria->compare('sub_category',$this->sub_category,true);
            $criteria->compare('grosswt',$this->grosswt); 
            
            if( !empty($this->numstones) && !empty($this->stone_check)){
            
                $criteria->together = true;
                $criteria->compare('skustones2.pieces',$this->numstones);
                
                if(!empty($this->gemstone)){
                    $criteria->compare('stones2.namevar',$this->gemstone, true);
                }
                if(!empty($this->gem_shape)){
                    $criteria->with[] = 'shapes';
                    $criteria->compare('shapes.name',$this->gem_shape, true);
                }   
                if(!empty($this->gem_size)){
                    $criteria->with[] = 'sizes4';
                    $criteria->compare('sizes4.size',$this->gem_size, true);
                }
            }
            else{
                    $criteria->compare('numstones',$this->numstones);
                    if(!empty($this->gem_shape)) $criteria->with[] = 'shapes';
                    if(!empty($this->gem_size)) $criteria->with[] = 'sizes';
                    if(!empty($this->updby) || !empty($this->type) || !empty($this->totstowei) ||  !empty($this->keyword) || !empty($this->gemstone) || !empty($this->gem_shape) || !empty($this->gem_size) || !empty($this->sku_metals)){
                        $criteria->together = true;
                    }

                    if(!empty($this->gemstone) && empty($this->gem_shape) && empty($this->gem_size)){
                        $criteria->with = array('stones');
                        $criteria->compare('stones.namevar',$this->gemstone, true);
                    }
                    else if(!empty($this->gemstone) || !empty($this->gem_shape)){
                    //  shape comes thru stones2
                        $criteria->with[] = 'stones2';
                        $criteria->compare('stones2.namevar',$this->gemstone, true);
                        $criteria->compare('shapes.name',$this->gem_shape, true);
                    if(!empty($this->gem_size)){
                        //size comes thru stones - all together
                        $criteria->compare('stones.namevar',$this->gemstone, true);
                        $criteria->compare('sizes.size',$this->gem_size, true);
                        $criteria->addCondition('skustones2.idskustones=skustones.idskustones','AND');
                    }
                    }else if(!empty($this->gemstone) || !empty($this->gem_size)){
                        //size comes thru stones
                        $criteria->compare('stones.namevar',$this->gemstone, true);
                        $criteria->compare('sizes.size',$this->gem_size, true);
                    }else if(!empty($this->gem_shape) || !empty($this->gem_size)){
                        $criteria->compare('shapes.name',$this->gem_shape, true);
                        $criteria->compare('sizes.size',$this->gem_size, true);
                        //both are of the same stone
                        $criteria->compare('stones2.idstone','stones.idstone', true);
                    }
            }
            
            
            if($this->gemstone2 && $this->stone_check2 && !$this->stone_check3 && !$this->stone_check4){
                    $criteria->with[] = 'stones3';
                    $criteria->together = true;
                    $criteria->compare('stones3.namevar',$this->gemstone2);
                }
                
            if($this->gem_size2 && $this->stone_check3 && !$this->stone_check2 && !$this->stone_check4){
                    $criteria->with[] = 'sizes2';
                    $criteria->together = true;
                    $criteria->compare('sizes2.size',$this->gem_size2);
                }
                
            if($this->gem_shape2 && $this->stone_check4 && !$this->stone_check2 && !$this->stone_check3){
                    $criteria->with[] = 'shapes2';
                    $criteria->together = true;
                    $criteria->compare('shapes2.name',$this->gem_shape2);
                }
            
            if($this->gemstone2 && $this->stone_check2 && $this->gem_shape2 && $this->stone_check3 && !$this->stone_check4){
                $criteria->with[] = 'stones3';
                $criteria->with[] = 'shapes3';
                $criteria->together = true;
                $criteria->compare('shapes3.name',$this->gem_shape2, true);
                $criteria->compare('stones3.namevar',$this->gemstone2, true);
            }
            
            if($this->gem_size2 && $this->stone_check3 && $this->gem_shape2 && $this->stone_check4 && !$this->stone_check2){
                $criteria->with[] = 'sizes3';
                $criteria->with[] = 'shapes4';
                $criteria->together = true;
                $criteria->compare('shapes4.name',$this->gem_shape2, true);
                $criteria->compare('sizes3.size',$this->gem_size2, true);
            }
            
            if($this->gemstone2 && $this->stone_check2 && $this->gem_size2 && $this->stone_check4 && !$this->stone_check3){
                $criteria->with[] = 'sizes2';
                $criteria->with[] = 'stones3';
                $criteria->together = true;
                $criteria->compare('stones3.namevar',$this->gemstone2, true);
                $criteria->compare('sizes2.size',$this->gem_size2, true);
            }
            
            if($this->gemstone2 && $this->stone_check2 && $this->gem_size2 && $this->stone_check4 && $this->gem_shape2 && $this->stone_check3){
                $criteria->with[] = 'stones3';
                $criteria->with[] = 'sizes2';
                $criteria->with[] = 'shapes3';
                $criteria->together = true;
                $criteria->compare('sizes2.size',$this->gem_size2, true);
                $criteria->compare('shapes3.name',$this->gem_shape2, true);
                $criteria->compare('stones3.namevar',$this->gemstone2, true);
            }
                
             
                
            // 21 dec, 2015
            if(!empty($this->keyword)) {
                //nested relational search
                $criteria->with[] = "keywords";
                $criteria->compare ('keywords.keyword',$this->keyword, true);
            }
            if(!empty($this->type)){ 
                $criteria->with[] = 'skucontent';
                $criteria->compare( 'skucontent.type', $this->type, false );}
            if(!empty($this->sku_size)) $criteria->compare( 'skucontent.size', $this->sku_size, true );
            if(!empty($this->sku_metals)){$criteria->with[] = 'metals'; $criteria->compare( 'metals.namevar', $this->sku_metals, true );}
            if(!empty($this->finding)){ $criteria->with[] = 'skufindings';
                $criteria->compare( 'skufindings.idfinding', $this->finding, false );}
            $criteria->group = 't.idsku';
            return new CActiveDataProvider(get_class($this), array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>15,
                    ),
            ));
    }

    public function getRelTypes()
    {
        return array(
            'variant'=>'variant',
            'upgrade'=>'upgrade',
        );

    }
    public function hasCookie($name)
    {
      return !empty(Yii::app()->request->cookies[$name]->value);
    }

    public function getCookie($name)
    {
      return Yii::app()->request->cookies[$name]->value;
    } 

    public function setCookie($name, $value)
    {
      $cookie = new CHttpCookie($name,$value);
      Yii::app()->request->cookies[$name] = $cookie;
    }

    public function removeCookie($name)
    {
      unset(Yii::app()->request->cookies[$name]);
    }
    public function getChecked($idsku){
        $res=$this->hasCookie('save-selection');
       if($res)
           { 
            $cookie_data= $this->getCookie('save-selection');
             $cookie_data=stripslashes($cookie_data);
            $cookie_data=  json_decode($cookie_data);
         // print_r($cookie_data);die();

         return in_array($idsku,$cookie_data)?1:0;
       }
       else{

           return false;
       }
    }
    public function getChecked_admin($idsku){
        $res=$this->hasCookie('save-selection-admin');
       if($res)
           { 
            $cookie_data= $this->getCookie('save-selection-admin');
             $cookie_data=stripslashes($cookie_data);
            $cookie_data=  json_decode($cookie_data);
         // print_r($cookie_data);die();

         return in_array($idsku,$cookie_data)?1:0;
       }
       else{

           return false;
       }
    }
    
    public function topStoneWeightNum(){
        $stodata = Sku::model()->getDbConnection()->createCommand('select sum(st.weight*ss.pieces) wt, sum(ss.pieces) ns from {{skustones}} ss, {{stone}} st where idsku=' . $this->idsku . ' and ss.idstone=st.idstone')->queryRow();
        return $stodata;
    }

    public function DiamondWeightNum(){
        $stodata = Sku::model()->getDbConnection()->createCommand('select sum(st.weight*ss.pieces) wt, sum(ss.pieces) ns from {{skustones}} ss, {{stone}} st where idsku=' . $this->idsku . ' and ss.idstone=st.idstone and upper(st.namevar) like upper("%Diamond%")')->queryRow();
        return $stodata;
    }
 
    public function getTypes(){
            return CHtml::listData(Category::model()->findAll('parent <> 0'), 'category', 'category');
        }   

    public function checkSkus($sku){
        return  Sku::model()->findByAttributes(array( 'skucode' => trim($sku))) ? true : false;
    }

    public function getgemwt($idsku){
        $array = $this->checkGemDiaWeight($idsku);
        if($array['gemwt'] == 0){return '-';}else{return $array['gemwt'];}
    }
    public function getdiawt($idsku){
        $array = $this->checkGemDiaWeight($idsku);
        if($array['diawt'] == 0){ return '-';}else{return $array['diawt'];}
    }

    public function checkGemDiaWeight($idsku){
        $diawt = 0 ; $gemwt = 0;
        $skustone = Skustones::model()->findAll(array(
            'condition' => 'idsku=:skuid',
            'params'=>array(':skuid'=>$idsku)
        ));
        foreach($skustone as $keystone){
            $piece = $keystone->pieces;
            $stone = Stone::model()->findByAttributes(array('idstone' => $keystone->idstone));
            $stonename = Stonem::model()->findAll(array(
                'condition' =>'idstonem=:stonem AND  name LIKE :match',
                'params' =>array(':stonem' => $stone->idstonem , ':match' =>'%Diamond%')
            ));
            if(!empty($stonename)){$diawt = $diawt + ($stone->weight * $piece);}
            else{$gemwt = $gemwt + ($stone->weight * $piece) ;}
        } 
        return $weight = array('diawt' => $diawt , 'gemwt' => $gemwt);
    }
        
}
