<?php

class SkuexportController extends Controller {

    public $layout = '//layouts/column2_new';

    public function actionIndex() {
       
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {    
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }

            if(!isset($_GET['export'])){
                $variable = 1;
            }else{
                $variable = $_GET['export'];
            }
            if (!in_array(ComSpry::export_access_array($variable), $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        
        $modelamn = new AmazonnForm;
        $modelam = new AmazonForm;
        $modelvgn = new VgnForm;
        $modelvg = new VgForm;
        $modelcan = new CanForm;
        $modelca = new CaForm;
        $modeljovn = new JovnForm;
        $modeljov = new JovForm;
        $modelwi = new WorksheetiForm;
        $modelex = new WorksheetForm;
        $modelnewwi = new WorksheetinewForm;
        $modelnewex = new WorksheetnewForm;
        $modelq = new QuotesheetForm;
        $modelqi = new QuotesheetiForm;
        $modelsn = new SnForm;
        $modelsni = new SniForm;
        $modelbb = new BbForm;
        $modelbbi = new BbiForm;
        $modelboss = new BossForm;
        $modelbossi = new BossiForm;
        $modelcode = new CodeForm;
        $modelcodei = new CodeiForm;
        $modelht = new HtForm;
        $modelhti = new HtiForm;
        $modelzy = new ZyForm;
        $modelzyi = new ZyiForm;
        $modelqb = new QbForm;
        $modelqbi = new QbiForm;
        $modelcode_zk = new Code_zkForm;
        $modelcode_zki = new Code_zkiForm;
        $modelcode_th = new Code_thForm;
        $modelcode_thi = new Code_thiForm; 
        $modelqov = new QovForm;
        $modelqovi = new QoviForm;
        $modelqjc = new QjcForm;
        $modelqjci = new QjciForm;
        $modeljz = new JzForm;
        $modeljzi = new JziForm;
        $modelrs = new RsForm;
        $modelrsi = new RsiForm;
        $modelsnn = new SnnForm;
        $modelsnni = new SnniForm;
        $modelgtdf = new GtdfForm;
        $modelgtdfi = new GtdfiForm;
        
        
        
        $models = new Sku('search');
        $models->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $models->attributes = $_GET['Sku'];

        
        if (isset($_POST['AmazonForm'])) { 
            if(!$_POST['AmazonForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            $modelam->attributes = $_POST['AmazonForm'];
            $amazon = new Amazon($modelam->skuid);
            if($_POST['type'] == 1){
                $amazon->export($modelam->skuid);
            }else{
                ImageExport::export($modelam->skuid, $amazon);
            }
        }
        if (isset($_POST['CaForm'])) { 
            if(!$_POST['CaForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            $modelca->attributes = $_POST['CaForm'];
            $ca = new Ca($modelca->skuid);
            if($_POST['type'] == 1){
                $ca->export($modelca->skuid);
            }else{
                ImageExport::export($modelca->skuid, $ca);
            }
        }
        if (isset($_POST['JovForm'])) {
            if(!$_POST['JovForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            $modeljov->attributes = $_POST['JovForm'];
            $jov = new Jov($modeljov->skuid);
            
            if($_POST['type'] == 1){
                $jov->export($modeljov->skuid);
            }else{
                ImageExport::export($modeljov->skuid, $jov);
            }
        }
        if (isset($_POST['VgForm'])) {
            if(!$_POST['VgForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            $modelvg->attributes = $_POST['VgForm'];
            $vg = new Vg($modelvg->skuid);
            
            if($_POST['type'] == 1){
                $vg->export($modelvg->skuid);
            }else{
                ImageExport::export($modelvg->skuid, $vg);
            }
        }
        if (isset($_POST['WorksheetiForm'])) {
            $modelwi->attributes = $_POST['WorksheetiForm'];
            $worksheet = new Worksheet($modelwi->skuid, $modelwi->idclient);
            $worksheet->export($modelwi->skuid, $modelwi->idclient);
        }
        if (isset($_POST['WorksheetinewForm'])) {
            $modelnewwi->attributes = $_POST['WorksheetinewForm'];
            $worksheet = new Worksheet_new($modelnewwi->skuid, $modelnewwi->idclient);
            $worksheet->export($modelnewwi->skuid, $modelnewwi->idclient);
        }
        if (isset($_POST['SniForm'])) {
            $modelsni->attributes = $_POST['SniForm'];
            $sn = new Sn($modelsni->skuid, $modelsni->idclient);
            $sn->export($modelsni->skuid, $modelsni->idclient);
        }
        if (isset($_POST['BbiForm'])) {
            $modelbbi->attributes = $_POST['BbiForm'];
            $bb = new Bb($modelbbi->skuid, $modelbbi->idclient);
            $bb->export($modelbbi->skuid, $modelbbi->idclient);
        }
        if (isset($_POST['QuotesheetiForm'])) {
            $modelqi->attributes = $_POST['QuotesheetiForm'];
            $quotesheet = new Quotesheet($modelqi->skuid, $modelqi->idclient);
            $quotesheet->export($modelqi->skuid, $modelqi->idclient);
        }
        if (isset($_POST['BossiForm'])) {
            if(!$_POST['BossiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            $modelbossi->attributes = $_POST['BossiForm'];
            $boss = new Boss($modelbossi->skuid);
            
            if($_POST['type'] == 1){
                $boss->export($modelbossi->skuid);
            }else{
                ImageExport::export($modelbossi->skuid, $boss);
            }
        }

        if (isset($_POST['CodeiForm'])) {
            if(!$_POST['CodeiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelcodei->attributes = $_POST['CodeiForm'];
            $code = new Code($modelcodei->skuid);
            
            if($_POST['type'] == 1){
                $code->export($modelcodei->skuid);
            }else{
                ImageExport::export($modelcodei->skuid, $code);
            }
        }

        if (isset($_POST['HtiForm'])) {
            if(!$_POST['HtiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelhti->attributes = $_POST['HtiForm'];
            $ht = new Ht($modelhti->skuid);
            
            if($_POST['type'] == 1){
                $ht->export($modelhti->skuid);
            }else{
                ImageExport::export($modelhti->skuid, $ht);
            }
        }

        if (isset($_POST['ZyiForm'])) {
            if(!$_POST['ZyiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelzyi->attributes = $_POST['ZyiForm'];
            $zy = new Zy($modelzyi->skuid);
            
            if($_POST['type'] == 1){
                $zy->export($modelzyi->skuid);
            }else{
                ImageExport::export($modelzyi->skuid, $zy);
            }
        }

        if (isset($_POST['QbiForm'])) {
            if(!$_POST['QbiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelqbi->attributes = $_POST['QbiForm'];
            $qb = new Qb($modelqbi->skuid);
            
            if($_POST['type'] == 1){
                $qb->export($modelqbi->skuid);
            }else{
                ImageExport::export($modelqbi->skuid, $qb);
            }
        }

        if (isset($_POST['Code_zkiForm'])) {
            if(!$_POST['Code_zkiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelcode_zki->attributes = $_POST['Code_zkiForm'];
            $code_zk = new Code_zk($modelcode_zki->skuid);
            
            if($_POST['type'] == 1){
                $code_zk->export($modelcode_zki->skuid);
            }else{
                ImageExport::export($modelcode_zki->skuid, $code_zk);
            }
        }

        if (isset($_POST['Code_thiForm'])) {
            if(!$_POST['Code_thiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelcode_thi->attributes = $_POST['Code_thiForm'];
            $code_th = new Code_th($modelcode_thi->skuid);
            
            if($_POST['type'] == 1){
                $code_th->export($modelcode_thi->skuid);
            }else{
                ImageExport::export($modelcode_thi->skuid, $code_th);
            }
        }

        if (isset($_POST['QoviForm'])) {
            if(!$_POST['QoviForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelqovi->attributes = $_POST['QoviForm'];
            $qov = new Qov($modelqovi->skuid);
            
            if($_POST['type'] == 1){
                $qov->export($modelqovi->skuid);
            }else{
                ImageExport::export($modelqovi->skuid, $qov);
            }
        }

        if (isset($_POST['QjciForm'])) {
            if(!$_POST['QjciForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelqjci->attributes = $_POST['QjciForm'];
            $qjc = new Qjc($modelqjci->skuid);
            
            if($_POST['type'] == 1){
                $qjc->export($modelqjci->skuid);
            }else{
                ImageExport::export($modelqjci->skuid, $qjc);
            }
        }
        
        if (isset($_POST['JziForm'])) {
            if(!$_POST['JziForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modeljzi->attributes = $_POST['JziForm'];
            $jz = new Jz($modeljzi->skuid);
            
            if($_POST['type'] == 1){
                $jz->export($modeljzi->skuid);
            }else{
                ImageExport::export($modeljzi->skuid, $jz);
            }
        }

        if (isset($_POST['RsiForm'])) {
            if(!$_POST['RsiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelrsi->attributes = $_POST['RsiForm'];
            $rs = new Rs($modelrsi->skuid);
            if($_POST['type'] == 1){
                $rs->export($modelrsi->skuid);
            }else{
                ImageExport::export($modelrsi->skuid, $rs);
            }  
        }

         if (isset($_POST['SnniForm'])) {
            if(!$_POST['SnniForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelsnni->attributes = $_POST['SnniForm'];
            $snni = new Snn($modelsnni->skuid);
            if($_POST['type'] == 1){
                $snni->export($modelsnni->skuid);
            }else{
                ImageExport::export($modelsnni->skuid, $snni);
            }  
        }
        if (isset($_POST['GtdfiForm'])) {
            if(!$_POST['GtdfiForm']['skuid']){
                throw new CHttpException('Please check the entered values again');
            }
            
            $modelgtdfi->attributes = $_POST['GtdfiForm'];
            $gtdf = new Gtdf($modelgtdfi->skuid);
            if($_POST['type'] == 1){
                $gtdf->export($modelgtdfi->skuid);
            }else{
                ImageExport::export($modelgtdfi->skuid, $gtdf);
            }  
        }
        
        if (isset($_POST['AmazonnForm'])) {
            $modelex->attributes = $_POST['AmazonnForm'];
            $values = explode(",", $modelex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $amazon = new Amazon($skuid);
            if($_POST['type'] == 1){
                $amazon->export($skuid);
            }else{
                ImageExport::export($skuid, $amazon);
            }
        }
        
        if (isset($_POST['VgnForm'])) {
            $modelex->attributes = $_POST['VgnForm'];
            $values = explode(",", $modelex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $vg = new Vg($skuid);
            
            if($_POST['type'] == 1){
                $vg->export($skuid);
            }else{
                ImageExport::export($skuid, $vg);
            }
        }
        
        if (isset($_POST['JovnForm'])) {
            $modelex->attributes = $_POST['JovnForm'];
            $values = explode(",", $modelex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $jov = new Jov($skuid);
            
            if($_POST['type'] == 1){
                $jov->export($skuid);
            }else{
                ImageExport::export($skuid, $jov);
            }
        }
        
        if (isset($_POST['CanForm'])) {
            $modelex->attributes = $_POST['CanForm'];
            $values = explode(",", $modelex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $ca = new Ca($skuid);
            if($_POST['type'] == 1){
                $ca->export($skuid);
            }else{
                ImageExport::export($skuid, $ca);
            }
        }

        if (isset($_POST['WorksheetForm'])) {
            $modelex->attributes = $_POST['WorksheetForm'];
            $values = explode(",", $modelex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $worksheet = new Worksheet($skuid, $modelex->idclient);
            $worksheet->export($skuid, $modelex->idclient);
        }
        if (isset($_POST['WorksheetnewForm'])) {
            $modelnewex->attributes = $_POST['WorksheetnewForm'];
            $values = explode(",", $modelnewex->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $worksheet = new Worksheet_new($skuid, $modelnewex->idclient);
            $worksheet->export($skuid, $modelnewex->idclient);
        }
        
        if (isset($_POST['QuotesheetForm'])) {
            $modelq->attributes = $_POST['QuotesheetForm'];
            $values = explode(",", $modelq->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $quotesheet = new Quotesheet($skuid, $modelq->idclient);
            $quotesheet->export($skuid, $modelq->idclient);
        }

        if (isset($_POST['SnForm'])) {
            $modelsn->attributes = $_POST['SnForm'];
            $values = explode(",", $modelsn->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $sn = new Sn($skuid, $modelsn->idclient);
            $sn->export($skuid, $modelsn->idclient);
        }


        if (isset($_POST['BbForm'])) {
            $modelbb->attributes = $_POST['BbForm'];
            $values = explode(",", $modelbb->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $bb = new Bb($skuid, $modelbb->idclient);
            $bb->export($skuid, $modelbb->idclient);
        }

        if (isset($_POST['BossForm'])) {
            $modelboss->attributes = $_POST['BossForm'];
            $values = explode(",", $modelboss->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $boss = new Boss($skuid);
            
            if($_POST['type'] == 1){
                $boss->export($skuid);
            }else{
                ImageExport::export($skuid, $boss);
            }
        }

        if (isset($_POST['CodeForm'])) {
            $modelcode->attributes = $_POST['CodeForm'];
            $values = explode(",", $modelcode->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code = new Code($skuid);
            
            if($_POST['type'] == 1){
                $code->export($skuid);
            }else{
                ImageExport::export($skuid, $code);
            }
        }

        if (isset($_POST['HtForm'])) {
            $modelht->attributes = $_POST['HtForm'];
            $values = explode(",", $modelht->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $ht = new Ht($skuid);
            
            if($_POST['type'] == 1){
                $ht->export($skuid);
            }else{
                ImageExport::export($skuid, $ht);
            }
        }

        if (isset($_POST['ZyForm'])) {
            $modelzy->attributes = $_POST['ZyForm'];
            $values = explode(",", $modelzy->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $zy = new Zy($skuid);
            
            if($_POST['type'] == 1){
                $zy->export($skuid);
            }else{
                ImageExport::export($skuid, $zy);
            }
        }

        if (isset($_POST['QbForm'])) {
            $modelqb->attributes = $_POST['QbForm'];
            $values = explode(",", $modelqb->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qb = new Qb($skuid);
            
            if($_POST['type'] == 1){
                $qb->export($skuid);
            }else{
                ImageExport::export($skuid, $qb);
            }
        }

        if (isset($_POST['Code_zkForm'])) {
            $modelcode_zk->attributes = $_POST['Code_zkForm'];
            $values = explode(",", $modelcode_zk->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code_zk = new Code_zk($skuid);
            
            if($_POST['type'] == 1){
                $code_zk->export($skuid);
            }else{
                ImageExport::export($skuid, $code_zk);
            }
        }

        if (isset($_POST['Code_thForm'])) {
            $modelcode_th->attributes = $_POST['Code_thForm'];
            $values = explode(",", $modelcode_th->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code_th = new Code_th($skuid);
            
            if($_POST['type'] == 1){
                $code_th->export($skuid);
            }else{
                ImageExport::export($skuid, $code_th);
            }
        }

        if (isset($_POST['QovForm'])) {
            $modelqov->attributes = $_POST['QovForm'];
            $values = explode(",", $modelqov->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qov = new Qov($skuid);
            
            if($_POST['type'] == 1){
                $qov->export($skuid);
            }else{
                ImageExport::export($skuid, $qov);
            }
        }

        if (isset($_POST['QjcForm'])) {
            $modelqjc->attributes = $_POST['QjcForm'];
            $values = explode(",", $modelqjc->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qjc = new Qjc($skuid);
            
            if($_POST['type'] == 1){
                $qjc->export($skuid);
            }else{
                ImageExport::export($skuid, $qjc);
            }
        }
        
        if (isset($_POST['JzForm'])) {
            $modeljz->attributes = $_POST['JzForm'];
            $values = explode(",", $modeljz->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $jz = new Jz($skuid);
            
            if($_POST['type'] == 1){
                $jz->export($skuid);
            }else{
                ImageExport::export($skuid, $jz);
            }
        }

        if (isset($_POST['RsForm'])) {
            $modelrs->attributes = $_POST['RsForm'];
            $values = explode(",", $modelrs->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $rs = new Rs($skuid);
            
            if($_POST['type'] == 1){
                $rs->export($skuid);
            }else{
                ImageExport::export($skuid, $rs);
            }
        }

        if (isset($_POST['SnnForm'])) {
            $modelsnn->attributes = $_POST['SnnForm'];
            $values = explode(",", $modelsnn->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $snn = new Snn($skuid);
            
            if($_POST['type'] == 1){
                $snn->export($skuid);
            }else{
                ImageExport::export($skuid, $snn);
            }
        }
        if (isset($_POST['GtdfForm'])) {
            $modelgtdf->attributes = $_POST['GtdfForm'];
            $values = explode(",", $modelgtdf->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $gtdf = new Gtdf($skuid);
            
            if($_POST['type'] == 1){
                $gtdf->export($skuid);
            }else{
                ImageExport::export($skuid, $gtdf);
            }
        }

        
        $this->render('index', array(
            'modelex' => $modelex,'models'  => $models,
            'modelq' => $modelq, 'modelsn' => $modelsn, 'modelbb' => $modelbb, 'modelwi' => $modelwi,
            'modelnewwi' => $modelnewwi,'modelnewex' => $modelnewex,
            'modelqi' => $modelqi, 'modelsni' => $modelsni, 'modelbbi' => $modelbbi, 'modelboss' => $modelboss,
            'modelbossi' => $modelbossi, 'modelcode' => $modelcode, 'modelcodei' => $modelcodei, 'modelhti' => $modelhti, 'modelht' => $modelht,
            'modelzy' => $modelzy, 'modelzyi' => $modelzyi, 'modelqb' => $modelqb, 'modelqbi' => $modelqbi, 'modelcode_zk' => $modelcode_zk , 'modelcode_zki' =>$modelcode_zki,
            'modelcode_th' => $modelcode_th, 'modelcode_thi' => $modelcode_thi, 'modelqov' => $modelqov, 'modelqovi' => $modelqovi, 'modelqjc' => $modelqjc, 'modelqjci' => $modelqjci,
            'modeljz' => $modeljz, 'modeljzi' => $modeljzi,'modelam' => $modelam, 'modelamn' => $modelamn,'modelvg' => $modelvg, 'modelvgn' => $modelvgn,'modelca' => $modelca, 'modelcan' => $modelcan,
            'modeljov' => $modeljov, 'modeljovn' => $modeljovn, 'modelrs' =>$modelrs , 'modelrsi' => $modelrsi,
            'modelsnn' =>$modelsnn , 'modelsnni' => $modelsnni,'modelgtdf'=>$modelgtdf, 'modelgtdfi'=>$modelgtdfi,
        ));
    }

    public function arraycheck($array) {

        $array1 = array();
        foreach ($array as $key => $values) {
            if ($values !== " ") {
                $array1[$key] = $values;
            }
        }

        return $array1;
    }

    public function getsku($values) {
        $ids = array();
        foreach ($values as $value) {
            $sku = Sku::model()->find('skucode=:skucode', array(':skucode' => trim($value)));
            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again');
            } else {
                $ids[] = $sku->idsku;
            }
        }
        $skuid = implode(",", $ids);
        return $skuid;
    }

    public function actionSearch($term)
     {
          if(Yii::app()->request->isAjaxRequest && !empty($term))
        {
              $variants = array();
              $criteria = new CDbCriteria;
              $criteria->select='skucode';
              $criteria->addSearchCondition('skucode',$term.'%',false);
              $tags = Sku::model()->findAll($criteria);
              if(!empty($tags))
              {
                foreach($tags as $tag)
                {
                    $variants[] = $tag->attributes['skucode'];
                }
              }
              echo CJSON::encode($variants);
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
     }

    public function actionexportApproval($id){ 
        Approval::export($id);
    }
    
    public function actionexportQuote($id){ 
        Quote::export($id);
    }



}
