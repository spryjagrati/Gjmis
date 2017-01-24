<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ComSpry extends CController {

    public function getAllUserDropDownList() {
        return CHtml::listData(User::model()->findAll(), 'username', 'username');
    }

    public function findaliases($value, $id) {
        if (isset($value)) {
            $alias = Aliases::model()->find('initial=:initial and aTarget=:id', array(':initial' => $value, ':id' => $id));
            if (isset($alias->alias)) {
                $deptAliases = DependentAlias::model()->findAll('idaliases=:idaliases', array(':idaliases' => $alias->id));
                if (isset($deptAliases)) {
                    return ['alias' => $alias->alias, 'deptAlias' => $deptAliases];
                } else {
                    return ['alias' => $alias->alias];
                }
            }
        }
    }

    public function findalias($value, $id){
      if(isset($value)){
        $alias = Aliases::model()->find('initial=:initial and aTarget=:id', array(':initial' => $value, ':id' => $id));
      }
      if(isset($alias) && ($alias->alias == 'sterling-silver'))
       return ucwords (str_replace('-', ' ', $alias->alias));
       else
        return $value;
    }

   public function findstone($value){
     if(isset($value)){
        $alias = Aliases::model()->find('initial=:initial', array(':initial' => $value));
      }
      if(isset($alias) && ($alias->alias == 'diamond'))
        return $value;
        else
            return ucwords($alias->alias);
    } 


   public function findmetal($value){
      if(isset($value)){
        $alias = Aliases::model()->find('initial=:initial', array(':initial' => $value));
      }
      if(isset($alias) && ($alias->alias == 'sterling-silver'))
       return '.925 Sterling Silver';
       else
        return $value;
   
    }


    /**
     * 
     * @return type
     * get list of metals
     * by Sprymohit
     * 29-04-2014
     */
    public function getMetalList() {
        return CHtml::listData(Metal::model()->findAll(array('order' => 'namevar ASC')), 'namevar', 'namevar');
    }

    public function getMetals() {
        return CHtml::listData(Metal::model()->findAll(array('order' => 'namevar ASC')), 'idmetal', 'namevar');
    }

    /**
     * 
     * @return type
     * get list of stone with name,$data[stone_name] = stone_name
     * by Sprymohit
     * 23-04-2014
     */
    public function getStonesList() {
        // return CHtml::listData(Stone::model()->findAll(array('order'=>'namevar ASC')),'idstone','name');
        $sql = 'select tbl_stone.namevar as namevar, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['namevar']] = $row['name'];
        }
        return $data;
    }

    public function getStones() {
        // return CHtml::listData(Stone::model()->findAll(array('order'=>'namevar ASC')),'idstone','name');
        $sql = 'select idstone as id, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where  tbl_stone.jewelry_type = 1 and tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['id']] = $row['name'];
        }
        return $data;
    }

        public function getStone(){
        $sql = 'select idstone as id, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where tbl_stone.idstone = '.$_GET['id'].' and tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
       foreach ($rows as $row) {
            $data[$row['id']] = $row['name'];
        }
        return $data;
    }
   


    public function getStonesData() {
        // return CHtml::listData(Stone::model()->findAll(array('order'=>'namevar ASC')),'idstone','name');
        $sql = 'select idstone as id, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        $data = '';
        foreach ($rows as $row) {
            $data .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
        return $data;
    }

    /**
     * 
     * @return type
     * get list of sku codes, called by skustones's _search.php
     * by Sprymohit
     * 23-04-14
     */
    public function getSku() {
        $sql = "select skucode from tbl_sku order by skucode ASC";
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_sku');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['skucode']] = $row['skucode'];
        }
        return ($data);
    }
    
    public function getSkucode(){
        $sql = "select idsku,skucode from tbl_sku order by skucode ASC";
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_sku');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['idsku']] = $row['skucode'];
        }
        return ($data);

    }

    /*
      public function getSkus(){
      $sql = "select skucode from tbl_sku order by skucode ASC";
      $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
      $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
      foreach($rows as $row){
      $data[] = $row['skucode'];


      }
      return ($data);
      } */

    public function getSkus1($iddept) {
        //print_r(trim($iddept));die();
        $sql = "SELECT l.idsku as idsku, s.skucode as skucode from tbl_locationstocks l, tbl_sku s where l.idsku = s.idsku and l.iddept = " . $iddept . " order by s.skucode ASC";
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_sku');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();

        if (isset($rows) && !empty($rows)) {
            foreach ($rows as $row) {
                $data[] = $row['skucode'];
            }
            return ($data);
        }
    }

    public function getSkus() {
        $sql = "select skucode from tbl_sku order by skucode ASC";
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_sku');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[] = $row['skucode'];
        }
        return ($data);
    }

    public function getChemicals() {
        return CHtml::listData(Chemical::model()->findAll(), 'idchemical', 'name');
    }

    public function getLocations() {
        $depts = Dept::model()->findAll();
        $data = array();
        foreach ($depts as $dept) {
            $data[$dept->iddept] = $dept->name . '-' . $dept->idlocation0->name;
        }
        return $data;
    }

    /**
     * 
     * @return string
     * get locations for dept to.
     * by Sprymohit
     * 15-05-2014
     */
    public function getLocationsdeptfrom() {
        $depts = Dept::model()->findAll();
        $data = array();
        foreach ($depts as $dept) {
            $data[$dept->iddept] = $dept->name . '-' . $dept->idlocation0->name;
        }
        return $data;
    }

    public function getLocation() {
        return CHtml::listData(Locations::model()->findAll(), 'idlocation', 'name');
    }

    /**
     * 
     * @return type
     * get list of settings, 
     * by Sprymohit
     * 23-04-14
     */
    public function getSettingsList() {
        return CHtml::listData(Setting::model()->findAll(), 'name', 'name');
    }

    public function getSettings() {
        return CHtml::listData(Setting::model()->findAll(), 'idsetting', 'name');
    }

    public function getMasterMetals() {
        return CHtml::listData(Metalm::model()->findAll(array('order' => 'name ASC')), 'idmetalm', 'name');
    }

    public function getMetalStamps() {
        return CHtml::listData(Metalstamp::model()->findAll(), 'idmetalstamp', 'name');
    }

    public function getShapes() {
        return CHtml::listData(Shape::model()->findAll(array('order' => 'name ASC')), 'idshape', 'name');
    }

    public function getClarities() {
        return CHtml::listData(Clarity::model()->findAll(array('order' => 'name ASC')), 'idclarity', 'name');
    }

    public function getStonesizes() {
        return CHtml::listData(Stonesize::model()->findAll(array('order' => 'size ASC')), 'idstonesize', 'size');
    }

    public function getStonem() {
        return CHtml::listData(Stonem::model()->findAll(array('order' => 'name ASC')), 'idstonem', 'name');
    }

    public function getClients() {
        return CHtml::listData(Client::model()->findAll(), 'idclient', 'name');
    }

    /**
     * 
     * @return type
     * finding list
     * by Sprymohit
     * 20-04-2014
     */
    public function getFindingslist() {
        return CHtml::listData(Finding::model()->findAll(array('order' => 'name ASC')), 'name', 'name');
    }

    public function getOptions() {
        return CHtml::listData(Aliases::model()->findAll(), 'option', 'option');
    }

    public function getFindings() {
        return CHtml::listData(Finding::model()->findAll(array('order' => 'name ASC')), 'idfinding', 'name');
    }

    public function getCostadds() {
        return CHtml::listData(Costadd::model()->findAll(array('order' => 'name ASC')), 'idcostadd', 'name');
    }

    public function getStatusms() {
        return CHtml::listData(Statusm::model()->findAll(), 'idstatusm', 'name');
    }

    public function getTypeStatusms($type) {
        return CHtml::listData(Statusm::model()->findAll('type=:type', array(':type' => $type)), 'idstatusm', 'name');
    }

    public function getDepts() {
        $items = Dept::model()->findAll();
        foreach ($items as $item) {
            $list[$item->iddept] = $item->idlocation0->name . '-' . $item->name;
        }
        return ($list);
    }

    public function getCategories(){
      return CHtml::listData(Category::model()->findAll('parent=:parent', array(':parent' =>0)), 'id', 'category');
     }

    public function getTypeLocDepts($type) {
        return CHtml::listData(Dept::model()->findAll('type=:type', array(':type' => $type)), 'iddept', 'locname');
    }

    public function getLocDepts() {
        $data = array();
        $dept = Dept::model()->find('iddept=' . User::model()->findByPk(Yii::app()->user->id)->iddept);

        $data[$dept->iddept] = $dept->name . '-' . $dept->idlocation0->name;

        return $data;
    }

    public function getDefSalesDept() {
        return Yii::app()->params['defsalesdept'];
    }

    public function getDefPoDept($id) {
        return Poskus::model()->find('idpo=:id', array(':id' => $id))->poskustatus->idprocdept;
    }

    public function getTypenameStatusms() {
        return CHtml::listData(Statusm::model()->findAll(), 'idstatusm', 'typename');
    }

    public function getSkuIdFromCode($skucode) {
        $idsku = -1;
        $sku = Sku::model()->find('skucode=:skucode', array(':skucode' => $skucode));
        $idsku = (isset($sku) && $sku !== '') ? $sku->idsku : -1;
        return $idsku;
    }

    public function getDefItemStatusm() {
        $status = 0;
        $status = Yii::app()->params['defitemstatus'];
        return $status;
    }

    public function getDefPoStatusm() {
        $status = 0;
        $status = Yii::app()->params['defpostatus'];
        return $status;
    }

    public function getDefPoAlocStatusm() {
        $status = 0;
        $status = Yii::app()->params['defpoalocstatusm'];
        return $status;
    }

    public function getDefPoPdStatusm() {
        $status = 0;
        $status = Yii::app()->params['defpopdstatusm'];
        return $status;
    }

    public function getDefPoExStatusm() {
        $status = 0;
        $status = Yii::app()->params['defpoexstatusm'];
        return $status;
    }

    public function getDefReqStatusm() {
        $status = 0;
        $status = Yii::app()->params['defreqstatus'];
        return $status;
    }

    public function getDefReqffStatusm() {
        $status = 0;
        $status = Yii::app()->params['defreqffstatusm'];
        return $status;
    }

    public function getDefProcDept() {
        $dept = 0;
        $dept = Yii::app()->params['defprocdept'];
        return $dept;
    }

    public function getTransStatuses($idstatusm) {
        $tostatus = CHtml::listData(Statusnav::model()->getDbConnection()->createCommand('select s.idstatusm id, s.name name from {{statusm}} s, {{statusnav}} sn
            where s.idstatusm=sn.idstatust and sn.idstatusf=' . $idstatusm)->queryAll(), 'id', 'name');
        $fstatus = CHtml::listData(array(Statusm::model()->findByPk($idstatusm)), 'idstatusm', 'name');
        return $fstatus + $tostatus;
    }

    public function calcSkuCost($sku) {
        /* TODO: check if $sku is integer, if then calculate with idsku or else calculate with skucode/ title
         * total cost=metal cost + stone cost + setting cost + bagging cost + chemical cost + finding costs + fixed costs + greater of thres and normal cost
         */
        $idsku = (is_numeric($sku)) ? $sku : ComSpry::getSkuIdFromCode($sku);
        if (!$idsku)
            return $idsku;

        //init
        $cost = 0;
        $connection = Yii::app()->db;
        //$connection->active=true;
        // get metal cost
        $sql = 'select sum(total) from (select sum(m.currentcost*sm.weight) total from {{metal}} m, {{skumetals}} sm where sm.idsku=:idsku and m.idmetal=sm.idmetal group by sm.idmetal) cost';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $metalcost = $command->queryScalar();
        $cost+=$metalcost;

        //get stone cost
        $sql = 'select sum(total) from (select sum(s.curcost*ss.pieces) total from {{stone}} s, {{skustones}} ss where ss.idsku=:idsku and s.idstone=ss.idstone group by ss.idstone) cost';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $stonecost = $command->queryScalar();
        $cost+=$stonecost;

        //get setting cost
        $sql = 'select sum(res.sc*res.pcs) from (select s.setcost sc,sum(ss.pieces) pcs from {{skustones}} ss, {{setting}} s ';
        $sql.='where ss.idsku=:idsku and s.idsetting=ss.idsetting group by ss.idsetting) res';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $settingcost = $command->queryScalar();
        $cost+=$settingcost;

        //get bagging cost
        $sql = 'select sum(res.bc*res.pcs) from (select s.bagcost bc,sum(ss.pieces) pcs from {{skustones}} ss, {{setting}} s ';
        $sql.='where ss.idsku=:idsku and s.idsetting=ss.idsetting group by ss.idsetting) res';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $baggingcost = $command->queryScalar();
        $cost+=$baggingcost;

        // get chemical cost
        $sql = 'select sum(m.chemcost*sm.weight) from {{metal}} m, {{skumetals}} sm where sm.idsku=:idsku and m.idmetal=sm.idmetal group by sm.idmetal';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $chemcost = $command->queryScalar();
        $cost+=$chemcost;

        // get finding cost
        $sql = 'select sum(f.cost*sf.qty) from {{finding}} f, {{skufindings}} sf where sf.idsku=:idsku and f.idfinding=sf.idfinding';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $findingcost = $command->queryScalar();
        $cost+=$findingcost;

        // miracle cap finding
        $sql = 'select sum(f.miracle*sf.qty) from {{finding}} f, {{skufindings}} sf where sf.idsku=:idsku and f.idfinding=sf.idfinding and f.idfinding = 13 group by sf.idfinding';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $miraclecost = $command->queryScalar();
        $cost+=$miraclecost;

        // get fixed costs
        $sql = 'select a.name name, sum(a.fixcost*sa.qty) val from {{skuaddon}} sa, {{costadd}} a where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and a.fixcost<>0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $fixedcost = $command->queryAll();
        foreach ($fixedcost as $fixedcoste) {
            $cost+=$fixedcoste['val'];
        }


        // get addon - metal factor costs
        $sql = 'select a.name name, sum(a.factormetal*sm.wt*sa.qty) val from tbl_skuaddon sa, tbl_costadd a, ';
        $sql.='(select idmetal id, sum(weight) wt from {{skumetals}} where idsku=:idsku group by idmetal) sm ';
        $sql.='where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and sm.id=a.idmetal and a.fixcost=0 and a.factormetal<>0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $addmfaccost = $command->queryAll();
        foreach ($addmfaccost as $addmfaccoste) {
            $cost+=$addmfaccoste['val'];
        }


        // get addon - formula cost + thres cost - compare
        $sql = 'select a.costformula cf,a.threscostformula tcf,sm.wt mw,sa.qty cq from {{skuaddon}} sa, {{costadd}} a, ';
        $sql.='(select idmetal id, sum(weight) wt from {{skumetals}} where idsku=:idsku group by idmetal) sm ';
        $sql.='where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and sm.id=a.idmetal and a.fixcost=0 and a.factormetal=0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $formulamatrix = $command->queryAll();
        $formcost = 0;
        foreach ($formulamatrix as $compform) {
            $m = $compform['mw'];
            $cf = $compform['cf'];
            $tcf = $compform['tcf'];
            $cq = $compform['cq'];
            eval("\$cf = \"$cf\";");
            $cf = ComSpry::calculateString($cf);
            eval("\$tcf = \"$tcf\";");
            $tcf = ComSpry::calculateString($tcf);
            $formcost+=($cf > $tcf) ? $cf * $cq : $tcf * $cq;
        }
        $cost+=$formcost;

        //close and return
        //$connection->active=false;
        return $cost;
    }

    public function calcSkuCostArray($sku) {
        /* TODO: check if $sku is integer, if then calculate with idsku or else calculate with skucode/ title
         * total cost=metal cost + stone cost + setting cost + bagging cost + chemical cost + finding costs + fixed costs + greater of thres and normal cost
         */
        $idsku = (is_numeric($sku)) ? $sku : ComSpry::getSkuIdFromCode($sku);
        if (!$idsku)
            return $idsku;

        //init
        $cost[] = '';
        $connection = Yii::app()->db;
        //$connection->active=true;
        // get metal cost
        $sql = 'select sum(total) from (select sum(m.currentcost*sm.weight) total from {{metal}} m, {{skumetals}} sm where sm.idsku=:idsku and m.idmetal=sm.idmetal group by sm.idmetal) cost';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $metalcost = $command->queryScalar();
        $cost['metal'] = $metalcost;

        //get stone cost
        $sql = 'select sum(total) from (select sum(s.curcost*ss.pieces) total from {{stone}} s, {{skustones}} ss where ss.idsku=:idsku and s.idstone=ss.idstone group by ss.idstone) cost';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $stonecost = $command->queryScalar();
        $cost['stone'] = $stonecost;

        //get setting cost
        $sql = 'select sum(res.sc*res.pcs) from (select s.setcost sc,sum(ss.pieces) pcs from {{skustones}} ss, {{setting}} s ';
        $sql.='where ss.idsku=:idsku and s.idsetting=ss.idsetting group by ss.idsetting) res';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $settingcost = $command->queryScalar();
        $cost['stoset'] = $settingcost;

        //get bagging cost
        $sql = 'select sum(res.bc*res.pcs) from (select s.bagcost bc,sum(ss.pieces) pcs from {{skustones}} ss, {{setting}} s ';
        $sql.='where ss.idsku=:idsku and s.idsetting=ss.idsetting group by ss.idsetting) res';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $baggingcost = $command->queryScalar();
        $cost['bagging'] = $baggingcost;

        // get chemical cost
        $sql = 'select sum(m.chemcost*sm.weight) from {{metal}} m, {{skumetals}} sm where sm.idsku=:idsku and m.idmetal=sm.idmetal group by sm.idmetal';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $chemcost = $command->queryScalar();
        $cost['chem'] = $chemcost;

        // get finding cost
        $sql = 'select sum(f.cost*sf.qty) from {{finding}} f, {{skufindings}} sf where sf.idsku=:idsku and f.idfinding=sf.idfinding ';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $findingcost = $command->queryScalar();
        $cost['find'] = $findingcost;

        // miracle cap finding
        // will be added to settings cost
        $sql = 'select sum(f.miracle*sf.qty) from {{finding}} f, {{skufindings}} sf where sf.idsku=:idsku and f.idfinding=sf.idfinding and f.idfinding = 13 group by sf.idfinding';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $miraclecost = $command->queryScalar();
        $cost['stoset'] += $miraclecost;

        $labor = 0;

        // get fixed costs
        $sql = 'select a.name name, sum(a.fixcost*sa.qty) val from {{skuaddon}} sa, {{costadd}} a where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and a.fixcost<>0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $fixedcost = $command->queryAll();
        $cost['fixcost'] = $fixedcost;
        foreach ($fixedcost as $fixedcoste) {
            $labor+=$fixedcoste['val'];
        }

        // get addon - metal factor costs
        $sql = 'select a.name name, sum(a.factormetal*sm.wt*sa.qty) val from tbl_skuaddon sa, tbl_costadd a, ';
        $sql.='(select idmetal id, sum(weight) wt from {{skumetals}} where idsku=:idsku group by idmetal) sm ';
        $sql.='where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and sm.id=a.idmetal and a.fixcost=0 and a.factormetal<>0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $addmfaccost = $command->queryAll();
        $cost['factor'] = $addmfaccost;
        foreach ($addmfaccost as $addmfaccoste) {
            $labor+=$addmfaccoste['val'];
        }


        // get addon - formula cost + thres cost - compare
        $sql = 'select a.name name,a.costformula cf,a.threscostformula tcf,sm.wt mw,sa.qty cq from {{skuaddon}} sa, {{costadd}} a, ';
        $sql.='(select idmetal id, sum(weight) wt from {{skumetals}} where idsku=:idsku group by idmetal) sm ';
        $sql.='where sa.idsku=:idsku and a.idcostadd=sa.idcostaddon and sm.id=a.idmetal and a.fixcost=0 and a.factormetal=0 group by sa.idcostaddon';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idsku", $idsku);
        $formulamatrix = $command->queryAll();
        $formcost = array();
        foreach ($formulamatrix as $compform) {
            $m = $compform['mw'];
            $cf = $compform['cf'];
            $tcf = $compform['tcf'];
            $cq = $compform['cq'];
            eval("\$cf = \"$cf\";");
            $cf = ComSpry::calculateString($cf);
            eval("\$tcf = \"$tcf\";");
            $tcf = ComSpry::calculateString($tcf);
            $formulacost = ($cf > $tcf) ? $cf * $cq : $tcf * $cq;
            $formcost[] = array('name' => $compform['name'], 'val' => $formulacost);
            $labor+=$formulacost;
        }
        $cost['formula'] = $formcost;

        $cost['labor'] = $labor + $cost['stoset'] + $cost['bagging'];

        //close and return
        //$connection->active=false;
        return $cost;
    }

    public function calculateString($mathString) {
        $mathString = trim($mathString);     // trim white spaces
        if ($mathString == "")
            $mathString = "0";
        $mathString = preg_replace('[^0-9\.\+-\*\/\(\) ]', '', $mathString);    // remove any non-numbers chars; exception for math operators
        $compute = create_function("", "return (" . $mathString . ");");
        return 0 + $compute();
    }

    public function getCurrency() {
        return array(1 => "Dollar", 2 => 'Rupee', 3 => 'Pound');
    }

    public function getShipqty($idinvoice, $idsku, $idpo) {
        $invoiceposku = Invoiceposkus::model()->findByAttributes(array('idinvoice' => $idinvoice, 'idsku' => $idsku, 'idpo' => $idpo, 'movements' => 1));
        return ($invoiceposku->shipqty);
    }

    public function currencyName($id) {

        if ($id == 1) {
            return("Dollar");
        } elseif ($id == 2) {
            return("Rupee");
        } elseif ($id == 3) {
            return("Pound");
        }
    }

    public function getStonecount($iddept, $idstone) {
        $sum = Yii::app()->db->createCommand()
                ->select('sum(stonewt) as stonewt')
                ->from('tbl_stonestocks')
                ->where('idstone=:idstone and iddept = :iddept', array(':idstone' => $idstone, ':iddept' => $iddept))
                ->queryRow();
        if (!isset($sum['stonewt'])) {
            return 0;
        } else {
            return $sum['stonewt'];
        }
    }

    public function getUnserilizedata($uid) {
        $usermodel = User::model()->findByPk($uid);
        $values = unserialize($usermodel->accessdetails);
        return $values;
    }
    
    public function findCode($skuid)
    {
        $sku = Sku::model()->findByPk($skuid);
        $skucode = (isset($sku) && $sku !== '') ? $sku->skucode : '';
        return $skucode;
    }
    
    
    public static function export_access_array($id){
        $export_array = array(1 => 72 ,2=> 76, 3=>59, 4=>60, 5=>61, 6=>62, 7=>63, 8=>64, 9=>65, 10=>66, 11=>67, 12=>68,13=>69, 14=>70, 15=>71, 16=>72, 17=>73, 18=>74, 19 => 75,23=>80);
        return $export_array[$id];
    }

    public function getBeadStones() {
        $sql = 'select idstone as id, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where tbl_stone.jewelry_type = 2 and tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['id']] = $row['name'];
        }
        return $data;
    }


    public function getEarringFindings(){
        $sql = 'select distinct t1.idfinding,t1.name from tbl_finding t1 join(select idsku,idfinding from tbl_skufindings) t2 on t1.idfinding = t2.idfinding join( select idsku from tbl_skucontent where type = "Earrings") t3 on t2.idsku = t3.idsku';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_skucontent');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[$row['idfinding']] = $row['name'];
        }
        return $data;
    }
}

?>
