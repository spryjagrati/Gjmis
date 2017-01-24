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
            if (!in_array(10, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        $modeln = new SkuexportnForm;
        $model = new SkuexportForm;
        $modelwi = new WorksheetiForm;
        $modelex = new WorksheetForm;
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
        $models = new Sku('search');
        $models->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $models->attributes = $_GET['Sku'];

        if (isset($_POST['SkuexportForm'])) {
            $model->attributes = $_POST['SkuexportForm'];

            if ($model->validate()) {
                if ($model->idclient == 1) {
                    $amazon = new Amazon($model->skuid);
                    $amazon->export($model->skuid);
                }
                if ($model->idclient == 9) {
                    $ca = new Ca($model->skuid);
                    $ca->export($model->skuid);
                }
                if ($model->idclient == 10) {
                    $jov = new Jov($model->skuid);
                    $jov->export($model->skuid);
                }
                if ($model->idclient == 8) {
                    $vg = new Vg($model->skuid);
                    $vg->export($model->skuid);
                }
                if ($model->idclient == 0) {
                    $allvenue = new Allvenue($model->skuid);
                    $allvenue->export($model->skuid);
                }
            }
        }

        if (isset($_POST['WorksheetiForm'])) {
            $modelwi->attributes = $_POST['WorksheetiForm'];
            $worksheet = new Worksheet($modelwi->skuid, $modelwi->idclient);
            $worksheet->export($modelwi->skuid, $modelwi->idclient);
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
            $modelbossi->attributes = $_POST['BossiForm'];
            $boss = new Boss($modelbossi->skuid);
            $boss->export($modelbossi->skuid);
        }

        if (isset($_POST['CodeiForm'])) {
            $modelcodei->attributes = $_POST['CodeiForm'];
            $code = new Code($modelcodei->skuid);
            $code->export($modelcodei->skuid);
        }

        if (isset($_POST['HtiForm'])) {
            $modelhti->attributes = $_POST['HtiForm'];
            $ht = new Ht($modelhti->skuid);
            $ht->export($modelhti->skuid);
        }

        if (isset($_POST['ZyiForm'])) {
            $modelzyi->attributes = $_POST['ZyiForm'];
            $zy = new Zy($modelzyi->skuid);
            $zy->export($modelzyi->skuid);
        }

        if (isset($_POST['QbiForm'])) {
            $modelqbi->attributes = $_POST['QbiForm'];
            $qb = new Qb($modelqbi->skuid);
            $qb->export($modelqbi->skuid);
        }

        if (isset($_POST['Code_zkiForm'])) {
            $modelcode_zki->attributes = $_POST['Code_zkiForm'];
            $code_zk = new Code_zk($modelcode_zki->skuid);
            $code_zk->export($modelcode_zki->skuid);
        }

        if (isset($_POST['Code_thiForm'])) {
            $modelcode_thi->attributes = $_POST['Code_thiForm'];
            $code_th = new Code_th($modelcode_thi->skuid);
            $code_th->export($modelcode_thi->skuid);
        }

        if (isset($_POST['QoviForm'])) {
            $modelqovi->attributes = $_POST['QoviForm'];
            $qov = new Qov($modelqovi->skuid);
            $qov->export($modelqovi->skuid);
        }

        if (isset($_POST['QjciForm'])) {
            $modelqjci->attributes = $_POST['QjciForm'];
            $qjc = new Qjc($modelqjci->skuid);
            $qjc->export($modelqjci->skuid);
        }
        
        if (isset($_POST['JziForm'])) {
            $modeljzi->attributes = $_POST['JziForm'];
            $jz = new Jz($modeljzi->skuid);
            $jz->export($modeljzi->skuid);
        }

        if (isset($_POST['SkuexportnForm'])) {
            $modeln->attributes = $_POST['SkuexportnForm'];

            $values = explode(",", $modeln->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            if ($modeln->validate()) {

                if ($modeln->idclient == 1) {
                    $amazon = new Amazon($skuid);
                    $amazon->export($skuid);
                }
                if ($modeln->idclient == 9) {
                    $ca = new Ca($skuid);
                    $ca->export($skuid);
                }
                if ($modeln->idclient == 10) {
                    $jov = new Jov($skuid);
                    $jov->export($skuid);
                }
                if ($modeln->idclient == 8) {
                    $vg = new Vg($skuid);
                    $vg->export($skuid);
                }
                if ($modeln->idclient == 0) {
                    $allvenue = new Allvenue($skuid);
                    $allvenue->export($skuid);
                }
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
            $boss->export($skuid);
        }

        if (isset($_POST['CodeForm'])) {
            $modelcode->attributes = $_POST['CodeForm'];
            $values = explode(",", $modelcode->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code = new Code($skuid);
            $code->export($skuid);
        }

        if (isset($_POST['HtForm'])) {
            $modelht->attributes = $_POST['HtForm'];
            $values = explode(",", $modelht->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $ht = new Ht($skuid);
            $ht->export($skuid);
        }

        if (isset($_POST['ZyForm'])) {
            $modelzy->attributes = $_POST['ZyForm'];
            $values = explode(",", $modelzy->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $zy = new Zy($skuid);
            $zy->export($skuid);
        }

        if (isset($_POST['QbForm'])) {
            $modelqb->attributes = $_POST['QbForm'];
            $values = explode(",", $modelqb->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qb = new Qb($skuid);
            $qb->export($skuid);
        }

        if (isset($_POST['Code_zkForm'])) {
            $modelcode_zk->attributes = $_POST['Code_zkForm'];
            $values = explode(",", $modelcode_zk->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code_zk = new Code_zk($skuid);
            $code_zk->export($skuid);
        }

        if (isset($_POST['Code_thForm'])) {
            $modelcode_th->attributes = $_POST['Code_thForm'];
            $values = explode(",", $modelcode_th->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $code_th = new Code_th($skuid);
            $code_th->export($skuid);
        }

        if (isset($_POST['QovForm'])) {
            $modelqov->attributes = $_POST['QovForm'];
            $values = explode(",", $modelqov->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qov = new Qov($skuid);
            $qov->export($skuid);
        }

        if (isset($_POST['QjcForm'])) {
            $modelqjc->attributes = $_POST['QjcForm'];
            $values = explode(",", $modelqjc->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $qjc = new Qjc($skuid);
            $qjc->export($skuid);
        }
        
        if (isset($_POST['JzForm'])) {
            $modeljz->attributes = $_POST['JzForm'];
            $values = explode(",", $modeljz->skucode);
            $values = $this->arraycheck($values);
            $skuid = $this->getsku($values);
            $jz = new Jz($skuid);
            $jz->export($skuid);
        }

        $this->render('index', array(
            'model' => $model, 'modeln' => $modeln, 'models' => $models, 'modelex' => $modelex,
            'modelq' => $modelq, 'modelsn' => $modelsn, 'modelbb' => $modelbb, 'modelwi' => $modelwi,
            'modelqi' => $modelqi, 'modelsni' => $modelsni, 'modelbbi' => $modelbbi, 'modelboss' => $modelboss,
            'modelbossi' => $modelbossi, 'modelcode' => $modelcode, 'modelcodei' => $modelcodei, 'modelhti' => $modelhti, 'modelht' => $modelht,
            'modelzy' => $modelzy, 'modelzyi' => $modelzyi, 'modelqb' => $modelqb, 'modelqbi' => $modelqbi, 'modelcode_zk' => $modelcode_zk , 'modelcode_zki' =>$modelcode_zki,
            'modelcode_th' => $modelcode_th, 'modelcode_thi' => $modelcode_thi, 'modelqov' => $modelqov, 'modelqovi' => $modelqovi, 'modelqjc' => $modelqjc, 'modelqjci' => $modelqjci,
            'modeljz' => $modeljz, 'modeljzi' => $modeljzi
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

    
    //worksheet export 
     public function Worksheet($skuids, $client) {

$ids = explode(",", $skuids);
        $repeat = count($ids);

        // get a reference to the path of PHPExcel classes
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

        $totalsku = array();

        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));

            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $stones = array();
            
            foreach ($skustones as $skustone) {
                $stones[] = array('pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => $skustone->idsetting0->name,
                    'month' => $skustone->idstone0->month,
                    'color' => $skustone->idstone0->color,
                    //isset($skustone->idstone0->idclarity0->name)?'clarity'=>$skustone->idstone0->idclarity0->name,:'';
                    'shape' => trim($skustone->idstone0->idshape0->name),
                    'size' => $skustone->idstone0->idstonesize0->size,
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' => $skustone->idstone0->treatmeth,
                    'ppc' => $skustone->idstone0->curcost,
                    'pps' => (($skustone->idstone0->curcost) * ($skustone->idstone0->weight)),
                    'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 'type' => $skustone->idstone0->idstonem0->type);
            }
            $skuimages = $sku->skuimages(array('type' => 'MISG'));
            //$skuimages=$sku->skuimages(array('condition'=>$client));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }

            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;


            if (!is_null($id) && $id !== '' && $id !== 0) {
                $cpf = 0;
                $rhodium = 0;
                $cost = ComSpry::calcSkuCostArray($id);
                $totcost = ComSpry::calcSkuCost($id);
                foreach ($cost['fixcost'] as $fcost) {
                    $cpf += $fcost['val'];
                }
                foreach ($cost['factor'] as $fcost) {
                    $cpf += $fcost['val'];
                }
                foreach ($cost['formula'] as $fcost) {
                    $cpf += $fcost['val'];
                }
            }

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf);
        }
       // echo('<pre>');print_r($totalsku);die();
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        //
        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
          $objReader = PHPExcel_IOFactory::createReader("Excel2007");

        // Set properties
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Lot')
                ->setCellValue('B1', 'Design')
                ->setCellValue('C1', 'Image')
                ->setCellValue('D1', 'Size')
                ->setCellValue('E1', 'Metal')
                ->setCellValue('F1', 'Gross')
                ->setCellValue('G1', 'Aprx')
                ->setCellValue('H1', '$/gm')
                ->setCellValue('I1', 'Silver')
                ->setCellValue('J1', 'Labor')
                ->setCellValue('K1', '')
                ->setCellValue('L1', 'Bagging')
                ->setCellValue('M1', '')
                ->setCellValue('N1', 'Stone')
                ->setCellValue('P1', 'Stn')
                ->setCellValue('Q1', 'Avg')
                ->setCellValue('R1', 'Stn')
                ->setCellValue('S1', 'Stn')
                ->setCellValue('T1', 'Stn')
                ->setCellValue('U1', 'Dia')
                ->setCellValue('V1', 'Avg')
                ->setCellValue('W1', 'Dia')
                ->setCellValue('X1', 'Dia')
                ->setCellValue('Y1', 'Total')
                ->setCellValue('Z1', '')
                ->setCellValue('AA1', 'Profit')
                ->setCellValue('AB1', 'Price')
                ->setCellValue('AC1', 'GMW')
                ->setCellValue('A2', '#')
                ->setCellValue('B2', '')
                ->setCellValue('C2', '')
                ->setCellValue('D2', '')
                ->setCellValue('E2', 'Type')
                ->setCellValue('F2', 'Wt.')
                ->setCellValue('G2', 'Mtl. Wt.')
                ->setCellValue('H2', '')
                ->setCellValue('I2', 'Amt.')
                ->setCellValue('J2', 'CPFR')
                ->setCellValue('K2', 'Setting')
                ->setCellValue('L2', 'Cost')
                ->setCellValue('M2', 'Total')
                ->setCellValue('N2', 'Description')
                ->setCellValue('O2', 'Product Remarks')
                ->setCellValue('P2', 'Pcs')
                ->setCellValue('Q2', 'Wt.')
                ->setCellValue('R2', '$/Ct.')
                ->setCellValue('S2', '$/Pc')
                ->setCellValue('T2', 'Amt.')
                ->setCellValue('U2', 'Pcs')
                ->setCellValue('V2', 'Wt.')
                ->setCellValue('W2', '$/Ct.')
                ->setCellValue('X2', 'Amt.')
                ->setCellValue('Y2', 'Cost')
                ->setCellValue('Z2', 'Findings')
                ->setCellValue('AA2', 'Margin')
                ->setCellValue('AB2', '$')
                ->setCellValue('AC2', 'Ct.');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->freezePane('A3');
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('J1:K1');
        $objPHPExcel->getActiveSheet()->mergeCells('L1:M1');

       /*Values loop Start*/ 

        $i=3;
        $j=1;    
       
              foreach($totalsku as $totalsku) {
            $count=count($totalsku[2]);      
            $cou[]=$count;

            $x= ''; $t=''; $q=''; $v=''; $c='';$lop='';
            
            for($loop=0; $loop < $count; $loop++){
                 
                 $x_array='X'.($i + $loop);
                 $x[]=$x_array;  
                 $t_array='T'.($i + $loop);
                 $t[]=$t_array;   
                 $q_array='Q'.($i + $loop);
                 $q[]=$q_array; 
                 $v_array='V'.($i + $loop);
                 $v[]=$v_array;  
                 $c_array='C'.($i+$loop);
                 $c[]=$c_array; 
                 $lop[]=$i+$loop;         
            }
            if(!empty($count)) {

            $X=implode('+',$x); 
            $T=implode('+',$t); 
            $Q=implode('+',$q); 
            $V=implode('+',$v);
      
        /*row merge for image display*/

            if($count < 15 ){ 
                        
                if($count == 1){ $en=end($lop) + 14;}
                if($count == 2){ $en=end($lop) + 13;}
                if($count == 3){ $en=end($lop) + 12;}
                if($count == 4){ $en=end($lop) + 11;}
                if($count == 5){ $en=end($lop) + 10;}
                if($count == 6){ $en=end($lop) + 9;}
                if($count == 7){ $en=end($lop) + 8;}
                if($count == 8){ $en=end($lop) + 7;}
                if($count == 9){ $en=end($lop) + 6;} 
                if($count == 10){ $en=end($lop) + 5;}
                if($count == 11){ $en=end($lop) + 4;}
                if($count == 12){ $en=end($lop) + 3;}
                if($count == 13){ $en=end($lop) + 2;}
                if($count == 14){ $en=end($lop) + 1;} 
                
                $objPHPExcel->getActiveSheet()->mergeCells(reset($c).':C'.$en); 
            }
            else{
                
                $objPHPExcel->getActiveSheet()->mergeCells(reset($c).':'.(end($c)));
            }
        }

        /*End row merge for image display*/
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $j);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $i, $totalsku[0]['skucode'])
                                               ->setCellValue('D' . $i, $totalsku[1]['size'])
                                               ->setCellValue('E' . $i, $totalsku[4])
                                               ->setCellValue('F' . $i, $totalsku[0]['grosswt']);          
            $objPHPExcel->setActiveSheetIndex()->getStyle('F' . $i)->getNumberFormat()->setFormatCode('##0.#0'); 
              
             if(!empty($count)) {  
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $i, '= F' . ($i + 0) .'- (' .$Q. '+' .$V.  ') / 5' );
            }
            else{
              $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $i, '= F' . ($i + 0)); 
            }  
         $objPHPExcel->setActiveSheetIndex()->getStyle('G' . $i)->getNumberFormat()->setFormatCode('##0.#0');
        
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $i, $totalsku[7])  
                                                 ->setCellValue('I' . $i, '=(G' . ($i) . '*H' . ($i) . ')')                    
                                                 ->setCellValue('J' . $i, $totalsku[10])
                                                 ->setCellValue('K' . $i, $totalsku[8]['stoset'])
                                                 ->setCellValue('L' . $i, $totalsku[8]['bagging'])
                                                 ->setCellValue('M' . $i, '=SUM(L' . ($i) . ':J' . ($i) . ')');

            $objPHPExcel->setActiveSheetIndex()->getStyle('H' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('I' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('J' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('K' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('L' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('M' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');        

           
            /*For images*/           
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            //$base= dirname(dirname(Yii::app()->basePath));             
            if(($totalsku[3][0])){
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('image');
                $objDrawing->setDescription('image');                         
                $objDrawing->setPath(Yii::app()->basePath . '/..' .$totalsku[3][0]);                           
                $objDrawing->setCoordinates('C'.($i+0));                         
                $objDrawing->setOffsetX(10);
                $objDrawing->setOffsetY(10);
                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            }


            /*If stone and diamond not available*/
            if(empty($totalsku[2])){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$i, $totalsku[1]['review']);
            }

            for ($k = 0; $k < $count; $k++) { 

                if ($totalsku[2][$k]['type'] != "diamond") {           
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size'])
                                                            ->setCellValue('O' . ($i + $k), $totalsku[2][$k]['reviews'])
                                                            ->setCellValue('P' . ($i + $k), $totalsku[2][$k]['pieces'])
                                                            ->setCellValue('Q' . ($i + $k), '= P' . ($i + $k) . ' * ' . $totalsku[2][$k]['weight']); 
                        $objPHPExcel->setActiveSheetIndex()->getStyle('Q' . ($i + $k))->getNumberFormat()->setFormatCode('#,##0.#0');
                        if(isset($totalsku[2][$k]['weight'])){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.($i+$k), ($totalsku[2][$k]['ppc']/$totalsku[2][$k]['weight']));}
                        else{
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.($i+$k), '');  
                        }
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . ($i + $k), ($totalsku[2][$k]['ppc'] / $totalsku[2][$k]['weight']));
                        $objPHPExcel->setActiveSheetIndex()->getStyle('R' . ($i + $k))->getNumberFormat()->setFormatCode('#,##0.#0');
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . ($i + $k), '=IF(R' . ($i + $k) . '>0,Q' . ($i + $k) . '*R' . ($i + $k) . ',P' . ($i + $k) . '*S' . ($i + $k) . ')');
                        $objPHPExcel->setActiveSheetIndex()->getStyle('T' . ($i + $k))->getNumberFormat()->setFormatCode('#,##0.#0');
                } 
                else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size'])
                                                        ->setCellValue('O' . ($i + $k), $totalsku[2][$k]['reviews']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . ($i + $k), $totalsku[2][$k]['pieces'])
                                                        ->setCellValue('V' . ($i + $k), '= U' . ($i + $k) . ' * ' . $totalsku[2][$k]['weight'])
                                                        ->setCellValue('W' . ($i + $k), $totalsku[2][$k]['ppc'] / $totalsku[2][$k]['weight'])
                                                        ->setCellValue('X' . ($i + $k), '=V' . ($i + $k) . '*W' . ($i + $k) . '');

                    $objPHPExcel->setActiveSheetIndex()->getStyle('X' . ($i + $k))->getNumberFormat()->setFormatCode('##0.##0');
                    $objPHPExcel->setActiveSheetIndex()->getStyle('V' . ($i + $k))->getNumberFormat()->setFormatCode('##0.####0');
                }         
            }
  

            if(!empty($count)){
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Y' . $i, '='.$X. '+' .$T. '+M' . ($i) . '+I' . ($i) . ''); 
            }else{
                 $objPHPExcel->setActiveSheetIndex()->setCellValue('Y' . $i, '=M' . ($i) . '+I' . ($i) . '');  
            }
            $objPHPExcel->setActiveSheetIndex()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
      
         
            if (isset($totalsku[8]['find'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, $totalsku[8]['find']);
                $objPHPExcel->setActiveSheetIndex()->getStyle('Z' . $i)->getNumberFormat()->setFormatCode('##0.#0');
            } 
            else{
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, '');
            }
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, '=((Y' . ($i) . '+Z' . ($i) . ')*(0.1))')
                        ->setCellValue('AB' . $i, '=ROUND(SUM(Y' . ($i) . ':AA' . ($i) . '),1)')
                        ->setCellValue('AC' . $i, '=(Q' . ($i + 0) . '+Q' . ($i + 1) . '+Q' . ($i + 2) . '+Q' . ($i + 3) . '+Q' . ($i + 4) . '+Q' . ($i + 5) . '+Q' . ($i + 6) . '+Q' . ($i + 7) . '+Q' . ($i + 8) . '+Q' . ($i + 9) . '+Q' . ($i + 10) . '+Q' . ($i + 11) . '+Q' . ($i + 12) . '+Q' . ($i + 13) . '+Q' . ($i + 14) . '+V' . ($i + 0) . '+V' . ($i + 1) . '+V' . ($i + 2) . '+V' . ($i + 3) . '+V' . ($i + 4) . '+V' . ($i + 5) . '+V' . ($i + 6) . '+V' . ($i + 7) . '+V' . ($i + 8) . '+V' . ($i + 9) . '+V' . ($i + 10) . '+V' . ($i + 11) . '+V' . ($i + 12) . '+V' . ($i + 13) . '+V' . ($i + 14) . ')-(Q' . ($i + 0) . '+Q' . ($i + 1) . '+Q' . ($i + 2) . '+Q' . ($i + 3) . '+Q' . ($i + 4) . '+Q' . ($i + 5) . '+Q' . ($i + 6) . '+Q' . ($i + 7) . '+V' . ($i + 0) . '+V' . ($i + 1) . '+V' . ($i + 2) . '+V' . ($i + 3) . '+V' . ($i + 4) . '+V' . ($i + 5) . '+V' . ($i + 6) . '+V' . ($i + 7) . ')*5/100');
               
            $objPHPExcel->setActiveSheetIndex()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode('"$"#0.0"0"');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');  
          
            if($count < 15){     
                $i = $i  + 15;
            }
            else{
                $i = $i + $count;
            }  
            $total_ids[]=$i-1;
            $j++; 
        }  

        /*Values loop End*/  
        
        /*Sheet style*/ 

        $styleThickBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC2')->applyFromArray($styleThickBorderOutline);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $styleThickBlackBorderOutline = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );


       $cou_a=max($total_ids);  
        for ($l = 3; $l < $cou_a + 1; $l++) {        
            $objPHPExcel->getActiveSheet()->getStyle('A' . $l . ':AC' . $l)->applyFromArray($styleThinBlackBorderOutline);
     
        } 
        foreach($total_ids as $co){           
            $objPHPExcel->getActiveSheet()->getStyle('A' . $co. ':AC' . $co)->applyFromArray($styleThickBlackBorderOutline);
        } 
    /*End Sheet Style*/ 
       
        spl_autoload_register(array('YiiBase', 'autoload'));
        //$objPHPExcel = ComSpry::checkaliases($objPHPExcel,$client);
        spl_autoload_unregister(array('YiiBase', 'autoload'));

//                $objPHPExcel->getActiveSheet()->mergeCells('C11:C17');
        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type:application/xlsx');
        header('Content-Disposition:attachment;filename="worksheet.xlsx"');
        header('Cache-Control:max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
        Yii::app()->end();
    }
  
      public function Quotesheet_master($skuids, $client) {     //generates quotesheet for master page only ** menu->master 
         $ids = explode(",", $skuids);
        $repeat = count($ids);


        // get a reference to the path of PHPExcel classes
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

        $totalsku = array();

        $clientinfo = Client::model()->find('idclient=:idclient', array(':idclient' => trim($client)));

        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));

            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $stones = array();
            $stonecost = 0;
            $stonenum = 0;
            $diamond_wt = 0;
            foreach ($skustones as $skustone) {
                $stonenum++;
                $stones[] = array('pieces' => $skustone->pieces, 'reviews' => $skustone->reviews, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    //'clarity'=>$skustone->idstone0->idclarity0->name,
                    'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    'month' => $skustone->idstone0->month,'tmeth' => $skustone->idstone0->treatmeth, 'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight);
                $stonecost += ($skustone->idstone0->weight) * ($skustone->idstone0->curcost);

                if ($skustone->idstone0->idstonem0->type == "diamond") {
                    $diamond_wt += ($skustone->pieces * $skustone->idstone0->weight);
                }
            }

            $skuimages = $sku->skuimages(array('type' => 'Gall'));
//           $skuimages=$sku->skuimages(array('condition'=>$client,'type'=>'Gall'));
//            $skuimages=$sku->skuimages(array('condition'=>$client));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }

            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;


            if (!is_null($id) && $id !== '' && $id !== 0) {

                $cost = ComSpry::calcSkuCost($id);
                $cost += (($clientinfo->commission) / 100) * $cost;
            }


            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $diamond_wt);
        }


        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        //
        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Image')
                ->setCellValue('B1', 'GJ#')
                ->setCellValue('C1', 'Category')
                ->setCellValue('D1', 'Gemstone(s) Description')
                ->setCellValue('E1', 'Gemstone(s)')
                ->setCellValue('F1', 'Product Remarks')
                ->setCellValue('G1', 'Metal')
                ->setCellValue('H1', 'Size')
                ->setCellValue('I1', 'Qty')
                ->setCellValue('J1', 'Gross Wt')
                ->setCellValue('K1', 'Gem Wt')
                ->setCellValue('L1', 'Dia Wt')
                ->setCellValue('M1', 'Metal Wt');
               // ->setCellValue('N1', 'Price')
               // ->setCellValue('O1', 'Amount');


        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->freezePane('A2');
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);



        for ($i = 2; $i <= $repeat + 1; $i++) {
            $stonecount = '';
            $stonereview = '';
            $stonearray = array();

            foreach ($totalsku[$i - 2][2] as $stone) {
                if (trim($stone['reviews']) != "") {
                    $stonereview .= $stone['reviews'] . ', ';
                }
                if ($stone['name'] != "") {
                    $stonecount .=($stone['name'] . ' ' . $stone['shape'] . ' ' . $stone['size'] . ' - ' . $stone['pieces'] . 'Pcs + ');
                    $stonearray[] = $stone['name'];
                }
            }
            $stonefinal = implode(",", array_unique($stonearray));
            $stonecount = substr_replace($stonecount, "", -2, -1);
            $stonereview = substr_replace($stonereview, "", -2, -1);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $totalsku[$i - 2][0]['skucode']);

            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $i, $totalsku[$i - 2][1]['type'])
                    ->setCellValue('D' . $i, $stonecount)
                    ->setCellValue('E' . $i, $stonefinal)
                    ->setCellValue('F' . $i, $stonereview)
                    ->setCellValue('G' . $i, $totalsku[$i - 2][4])
                    ->setCellValue('H' . $i, $totalsku[$i - 2][1]['size'])
                    ->setCellValue('I' . $i, '')
                    ->setCellValue('J' . $i, $totalsku[$i - 2][0]['grosswt'])
                    ->setCellValue('K' . $i, $totalsku[$i - 2][0]['totstowei'] - $totalsku[$i - 2][9]);
            if ($totalsku[$i - 2][9] !== 0) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, $totalsku[$i - 2][9]);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, $totalsku[$i - 2][0]['totmetalwei']);
            $objPHPExcel->setActiveSheetIndex()->getStyle('M' . $i)->getNumberFormat()->setFormatCode('##0.#0');
                 //   ->setCellValue('N' . $i, $totalsku[$i - 2][8])
                  //  ->setCellValue('O' . $i, ''); **/
        }

        $styleThickBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleThickBorderOutline);

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        for ($l = 2; $l <= $repeat + 1; $l++) {

            $objPHPExcel->getActiveSheet()->getStyle('A' . $l . ':M' . $l)->applyFromArray($styleThinBlackBorderOutline);
        }

for ($i = 2; $i <= $repeat+1; $i++) {
          $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
          $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(125);
          if(isset($totalsku[$i-2][3][0])){
          $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setName('image');
          $objDrawing->setDescription('image');
          $objDrawing->setOffsetX(10);
          $objDrawing->setOffsetY(10);
          $objDrawing->setPath(Yii::app()->basePath . '/..' . $totalsku[$i-2][3][0]);
          $objDrawing->setCoordinates('A'.($i+0));
          $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
          }
        }

        spl_autoload_register(array('YiiBase', 'autoload'));
        // $objPHPExcel = ComSpry::checkaliases($objPHPExcel,$client);
        spl_autoload_unregister(array('YiiBase', 'autoload'));


        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Quote.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');


        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));


        Yii::app()->end();
    }





}
