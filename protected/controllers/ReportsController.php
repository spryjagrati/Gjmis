<?php

class ReportsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1_new';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions

                'actions'=>array('admin','metalreport','findingreport','stonereport','skureport','LocationStocks','stonestockreport','stonesummary','stoneStockDetail','stoneStockLedger','excelAll','deptSkuExport','locationStockLedger','locationstockLedgerExport'),

                'actions'=>array('admin','metalreport','excel','findingreport','stonereport','skureport','LocationStocks','stonestockreport','stonesummary','stoneStockDetail','stoneStockLedger','excelAll','deptSkuExport','locationStockLedger','locationstockLedgerExport'),

                'users'=>Yii::app()->getModule("user")->getAdmins(),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * List all Reports.
     */
    public function actionAdmin()
    {
        $this->render('admin',array(
        ));
    }

        /**
     * Metal Report
     */
    public function actionMetalReport()
    {
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(27, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $type='metal';
            $model=new Deptmetallog('search');$model->unsetAttributes();
            if(isset($_POST['Deptmetallog']))
                $model->iddept=$_POST['Deptmetallog']['iddept'];
            else
                $model->iddept=ComSpry::getDefProcDept();
            

            $this->render('metalReport',array(
                    'type'=>$type,'model'=>$model,
            ));
            
    }

        
        public function actionLocationStockLedger(){
            
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(58, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $type='sku';
            $model = new Deptskulog;        
            if(isset($_POST['Deptskulog']))
                $model->iddept=$_POST['Deptskulog']['iddept'];
            
            if(isset(Yii::app()->session['locationstockledger'])){
            $dept = Yii::app()->session['locationstockledger'];}else{
                $dept='';
            }
            
            if(!Yii::app()->request->isAjaxRequest)
            {
                Sku::model()->removeCookie('save-selection-admin');

            }
            
            if(isset($_POST['selected_sku'])){
               $res1=Sku::model()->hasCookie('save-selection-admin');
               if(!empty($res1)){
                    $res_cookie=Sku::model()->getCookie('save-selection-admin');
                    $res_cookie=  stripslashes($res_cookie);
                    $res_cookie= json_decode($res_cookie);
                    $json=  array_unique(array_merge($res_cookie,$_POST['selected_sku']));
               }
               else{
                   $json=$_POST['selected_sku'];
               }
                $json=  json_encode($json);
                Sku::model()->setCookie('save-selection-admin',$json);
            }
            
            $dept = isset($model->iddept)?$model->iddept:$dept;
            Yii::app()->session['locationstockledger'] = $dept;
                 
            if(isset($dept) && $dept!=""){
                
              $cond = " and iddept =".$dept;  
            }   
            else
                $cond="";
            
            $count = "select count(*) from (select dsp.idsku,dsp.iddeptskulog,s.skucode, sum(dsp.qty*dsp.pricepp)/sum(dsp.qty) as pricepp,((sum(dsp.qty*dsp.pricepp)/sum(dsp.qty))*(sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end))) as amount , metal_type, ss.size, sum(dsp.qty) as totqty,sum(case when dsp.refsent is null then 0 else dsp.qty end) as sipqty, (sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end)) as balqty from tbl_deptskulog dsp,(select * from tbl_sku) s,(select skm.idsku,skm.idskumetals,m.namevar as metal_type from tbl_skumetals skm,tbl_metal m where skm.idmetal=m.idmetal)sm, (select sks.idstone,sks.idsku,ssize.size from tbl_skustones sks, tbl_stone s, tbl_stonesize ssize where sks.idstone = s.idstone and s.idstonesize = ssize.idstonesize group by sks.idsku )ss where (s.idsku=dsp.idsku and sm.idsku=s.idsku and ss.idsku = s.idsku)  $cond  group by dsp.idsku) p";
            
            $sql = "select dsp.idsku as idsku,dsp.iddeptskulog,s.skucode, sum(dsp.qty*dsp.pricepp)/sum(dsp.qty) as pricepp,((sum(dsp.qty*dsp.pricepp)/sum(dsp.qty))*(sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end))) as amount , metal_type, ss.size, sum(dsp.qty) as totqty,sum(case when dsp.refsent is null then 0 else dsp.qty end) as sipqty, (sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end)) as balqty from tbl_deptskulog dsp,(select * from tbl_sku) s,(select skm.idsku,skm.idskumetals,m.namevar as metal_type from tbl_skumetals skm,tbl_metal m where skm.idmetal=m.idmetal)sm, (select sks.idstone,sks.idsku,ssize.size from tbl_skustones sks, tbl_stone s, tbl_stonesize ssize where sks.idstone = s.idstone and s.idstonesize = ssize.idstonesize group by sks.idsku )ss where (s.idsku=dsp.idsku and sm.idsku=s.idsku and ss.idsku = s.idsku) $cond group by dsp.idsku";
            $count = Yii::app()->db->createCommand($count)->queryScalar(); //the count
            $dataProvider = new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                 'keyField'=>'idsku',
                 'pagination'=>array(
                        'pageSize'=>50,
                    ),
            )); 
                
               $this->render('locationStockLedger',array(
                    'type'=>$type,'model'=>$model,'dataProvider' => $dataProvider
            ));
               
            
        }
        public function actionLocationstockLedgerExport(){
            if(isset($_COOKIE['save-selection-admin'])){   //check if cookie is set              
                $res_cookie=  stripslashes($_COOKIE['save-selection-admin']);
                $res_cookie= json_decode($res_cookie);
                 if (is_object($res_cookie)) {          
                    $res_cookie = get_object_vars($res_cookie);
                }                             
                else{
                   $res_cookie = $res_cookie;                            
                } 
                $skuid=  array_merge($res_cookie,$_POST['ids']);  //merge cookie values and checked values
                $skuid=  array_unique($skuid);  
                $ids =  $skuid;                     
            }  
            else{                          
                $ids =  $_POST['ids'];
            }
            $total =array();
           
            foreach($ids as $iddeptskulog){
                $count = "select count(dsp.idsku), dsp.idsku from tbl_deptskulog dsp,(select * from tbl_sku) s,(select skm.idsku,skm.idskumetals,m.namevar as metal_type from tbl_skumetals skm,tbl_metal m where skm.idmetal=m.idmetal)sm, (select sks.idstone,sks.idsku,ssize.size from tbl_skustones sks, tbl_stone s, tbl_stonesize ssize where sks.idstone = s.idstone and s.idstonesize = ssize.idstonesize group by sks.idsku )ss where (s.idsku=dsp.idsku and sm.idsku=s.idsku and ss.idsku = s.idsku) ";
                $count = Yii::app()->db->createCommand($count)->queryScalar(); //the count
                $sql = "select dsp.idsku,s.skucode, sum(dsp.qty*dsp.pricepp)/sum(dsp.qty) as pricepp,((sum(dsp.qty*dsp.pricepp)/sum(dsp.qty))*(sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end))) as amount , metal_type, ss.size, sum(dsp.qty) as totqty,sum(case when dsp.refsent is null then 0 else dsp.qty end) as sipqty, (sum(dsp.qty)-sum(case when dsp.refsent is null then 0 else dsp.qty end)) as balqty from tbl_deptskulog dsp,(select * from tbl_sku) s,(select skm.idsku,skm.idskumetals,m.namevar as metal_type from tbl_skumetals skm,tbl_metal m where skm.idmetal=m.idmetal)sm, (select sks.idstone,sks.idsku,ssize.size from tbl_skustones sks, tbl_stone s, tbl_stonesize ssize where sks.idstone = s.idstone and s.idstonesize = ssize.idstonesize group by sks.idsku )ss where (s.idsku=dsp.idsku and sm.idsku=s.idsku and ss.idsku = s.idsku) and dsp.iddeptskulog = $iddeptskulog group by dsp.idsku";
               // $rawData = Yii::app()->db->createCommand($sql);
                $dataProvider = new CSqlDataProvider($sql, array(
                    'totalItemCount'=>$count,
                     'keyField'=>'idsku',
                     'pagination'=>array(
                            'pageSize'=>50,
                        ),
                ));
                $data = $dataProvider->getData();
                $record[] = $data[0];
            }
            
            //echo "<pre>";print_r($record);die;
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
             spl_autoload_unregister(array('YiiBase','autoload'));

             
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
            ->setCellValue('A1', 'SKU#')
            ->setCellValue('B1', 'Metal Type')
            ->setCellValue('C1', "Size")
            ->setCellValue('D1', 'Total Qty ')
            ->setCellValue('E1', 'Shipp Qty')
            ->setCellValue('F1', 'Bal Qty')
            ->setCellValue('G1', 'Price')
            ->setCellValue('H1', 'Amount');
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
            $i = 0; 
            foreach($record as $values){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 2), $values['skucode']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 2), $values['metal_type']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 2), $values['size']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 2), $values['totqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 2), $values['sipqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 2), $values['balqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i + 2), $values['pricepp']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i + 2), $values['amount']);
                        $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);

            $styleThickBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
                );
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
          // Redirect output to a client's web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Sku-Report.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));    
            
        }    
        
        /**
     * Stone Report
     */
    public function actionStoneReport()
    {
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(26, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $type='stone';
            
            $model=new Stonestocks('search');$model->unsetAttributes();
            if(isset($_POST['Stonestocks']))
                $model->iddept=$_POST['Stonestocks']['iddept'];
                 
                
            
            if(Yii::app()->session['iddeptstonereport']){
                $dept = Yii::app()->session['iddeptstonereport'];}else{
                $dept='';
            }
           
            
              
            $dept = isset($model->iddept)?$model->iddept:$dept; 
            if($dept){
            $count=Yii::app()->db->createCommand('select count(*) from (select dsl.idstone, sm.name stone, sh.name shape, s.quality, ss.size, dsl.stonewt, dsl.qty, mr.rqty rqty from
            (select idstone,(SUM(CASE WHEN qty > 0 THEN stonewt WHEN qty = 0 THEN stonewt ELSE 0 END) - ABS(SUM(CASE WHEN qty < 0 THEN stonewt ELSE 0 END))) AS stonewt, iddept, sum(qty) qty from tbl_stonestocks group by idstone, iddept) dsl
            left join (select idstone ids, reqby, sum(rqty) rqty from tbl_matreq where idstatusm='.ComSpry::getDefReqStatusm().' group by ids) mr on mr.reqby=dsl.iddept and mr.ids=dsl.idstone,
            tbl_stone s, tbl_stonem sm, tbl_shape sh, tbl_stonesize ss
            where dsl.idstone=s.idstone and s.idshape=sh.idshape and s.idstonem=sm.idstonem and s.idstonesize=ss.idstonesize and dsl.iddept='.$dept.' group by dsl.idstone) a')->queryScalar();

            $metsql='select dsl.idstone, sm.name stone, sh.name shape, s.quality, ss.size, dsl.stonewt as stonewt, dsl.qty, mr.rqty rqty from
            (select idstone, iddept,(SUM(CASE WHEN qty > 0 THEN stonewt WHEN qty = 0 THEN stonewt ELSE 0 END) - ABS(SUM(CASE WHEN qty < 0 THEN stonewt ELSE 0 END))) AS stonewt, sum(qty) qty from tbl_stonestocks group by idstone, iddept) dsl
            left join (select idstone ids, reqby, sum(rqty) rqty from tbl_matreq where idstatusm='.ComSpry::getDefReqStatusm().' group by ids) mr on mr.reqby=dsl.iddept and mr.ids=dsl.idstone,
            tbl_stone s, tbl_stonem sm, tbl_shape sh, tbl_stonesize ss
            where dsl.idstone=s.idstone and s.idshape=sh.idshape and s.idstonem=sm.idstonem and s.idstonesize=ss.idstonesize and dsl.iddept='.$dept.' group by dsl.idstone';

            $dataProvider = new CSqlDataProvider($metsql, array(
                'totalItemCount'=>$count,
                 'keyField'=>'idsku',
                 'pagination'=>array(
                        'pageSize'=>50,
                    ),
            ));
            }
            Yii::app()->session['iddeptstonereport'] = $dept;
          
                       $this->render('stoneReport',array(
                    'type'=>$type,'model'=>$model,'data'=>$dataProvider
            ));
            
    }

        /**
     * Finding Report
     */
    public function actionFindingReport()
    {
            $type='finding';
            $model=new Deptfindinglog('search');$model->unsetAttributes();
            if(isset($_POST['Deptfindlog']))
                $model->iddept=$_POST['Deptfindlog']['iddept'];
            else
                $model->iddept=ComSpry::getDefProcDept();


            $this->render('findingReport',array(
                    'type'=>$type,'model'=>$model,
            ));
    }
        
        /**
     * Sku Report
     */
    public function actionSkuReport()
    {
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(28, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            
            $type='sku';
            $model=new Deptskulog('search');
            $model->unsetAttributes();
            
            if(isset($_POST['Deptskulog']))
                $model->iddept=$_POST['Deptskulog']['iddept'];
            
            $dept = Yii::app()->session['iddeptskustocks'] ? Yii::app()->session['iddeptskustocks'] : 1;
            $dept = isset($model->iddept) ? $model->iddept: $dept;
            
            
        if($dept){             
                $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM (select dps.idsku as idsku,s.skucode as skucode, dps.po_num as idpo, dps.mdate as mdate, dps.refrcvd refrcvd, dps.refsent as refsent, sum(dps.qty) as qty, s.totstowei as totstowei,s.totmetalwei as totmetalwei, s.grosswt as grosswt  from tbl_deptskulog dps, (select * from tbl_sku )  s where iddept = '.$dept.'  and s.idsku=dps.idsku group by idsku) as total')->queryScalar();
                $metsql='select dps.idsku as idsku,s.skucode as skucode, dps.po_num as idpo, dps.mdate as mdate, dps.refrcvd refrcvd, dps.refsent as refsent, sum(dps.qty) as qty, s.totstowei as totstowei,s.totmetalwei as totmetalwei, s.grosswt as grosswt  from tbl_deptskulog dps, (select * from tbl_sku )  s where iddept = '.$dept.'  and s.idsku=dps.idsku group by idsku';
                
                $dataProvider = new CSqlDataProvider($metsql, array(
                'totalItemCount'=>$count,
                 'keyField'=>'idsku',
                 'pagination'=>array(
                        'pageSize'=>50,
                    ),
                ));

                Yii::app()->session['iddeptskustocks'] = $dept;
            }
                
            $this->render('skuReport',array(
                    'type'=>$type,'model'=>$model,'dataProvider' => $dataProvider
            ));
               
    }
        public function actionDeptSkuExport(){
            
            $ids = $_POST['ids'];
            $total =array();
            foreach($ids as $iddept){
                $deptmodel = Deptskulog::model()->findByPk($iddept);
                $total[] = array(
                            'Skucode'=>$deptmodel->idsku0->skucode,
                            'Qty'=>$deptmodel->qty,
                            'Stone Pricepp'=>$deptmodel->idsku0->stones[0]->curcost,
                            'Pricepp'=>ComSpry::calcSkuCost($deptmodel->idsku),
                            'Total Weight'=>number_format(($deptmodel->idsku0->grosswt *$data->qty), 2, ".", ""),
                            'Total Stone'=>number_format(($deptmodel->idsku0->totstowei *$data->qty), 2, ".", ""),
                            'Total Metal'=>number_format(($deptmodel->idsku0->totmetalwei * $data->qty), 2, ".", ""),
                            'Modified Date'=>$deptmodel->mdate,
                            'Reference Recieved'=>$deptmodel->refrcvd,
                            'Reference Sent'=>$deptmodel->refsent,
                            
                        );
                
            }
            
            //echo "<pre>";print_r($total);die;
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
             spl_autoload_unregister(array('YiiBase','autoload'));

             
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
            ->setCellValue('A1', 'SKU#')
            ->setCellValue('B1', 'Qty')
            ->setCellValue('C1', 'Stone Pricepp')
            ->setCellValue('D1', "Pricepp")
            ->setCellValue('E1', 'Total Weight')
            ->setCellValue('F1', 'Total Stone')
            ->setCellValue('G1', 'Total Metal')
            ->setCellValue('H1', 'Modified Date')
            ->setCellValue('I1', 'Reference Recieved')
            ->setCellValue('J1', 'Reference Sent');
            
            $i = 0; 
            foreach($total as $values){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 2), $values['Skucode']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 2), $values['Qty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 2), $values['Stone Pricepp']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 2), $values['Pricepp']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 2), $values['Total Weight']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 2), $values['Total Stone']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i + 2), $values['Total Metal']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i + 2), $values['Modified Date']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i + 2), $values['Reference Recieved']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i + 2), $values['Reference Sent']);
                        $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

          // Redirect output to a client's web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Sku-Report.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));    
            
        }
        /**
         * locations stocks
         */
       public function actionLocationStocks(){
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(55, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $type='sku';
            if(isset(Yii::app()->session['iddept_stocks'])){

            $dept = Yii::app()->session['iddept_stocks'];}else{

                $dept='';

            }

            if(isset($_POST['data'])){

                foreach($_POST['data'] as $key=>$value){

                    $modelsku = Locationstocks::model()->findByPk($key);

                    $modelsku->locref = $value['locref'];
                    $modelsku->currency = $value['currency'];
                    $modelsku->pricepp = $value['pricepp'];
                    $modelsku->save();

                    Yii::app()->user->setFlash("message",'Updated Successfully');
                }
                $dept = $modelsku->iddept;
            }
             $dataProvider =array();
            
            if(isset($_POST['Locationstocks']['iddept']) || $dept !== ''){
                $dept = isset($_POST['Locationstocks']['iddept'])?$_POST['Locationstocks']['iddept']:$dept;
                    
                    $dataProvider=new CActiveDataProvider('Locationstocks', array(

                        'criteria'=>array(
                        'condition'=>'iddept='.$dept,
                        'order'=>'lupdated ASC',
                        ),
                        'pagination'=>array(
                                'pageSize'=>100,
                            ),
                    ));
                    Yii::app()->session['iddept_stocks'] = $dept;
            }
              
            $model=new Locationstocks('search');$model->unsetAttributes();
            
            $this->render('locationstocks',array(
                   'dataProvider'=>$dataProvider,
                   'model'=>$model, 'dept'=>$dept
            ));
             
        }
               
        public function actionstoneStockReport(){
             $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(29, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
                    
                        $type = 'stonestock';
                        $model = new Stonestocks('search');
                        $cdate='1970-12-12';
                      
                        $model->unsetAttributes();
                        if (isset($_REQUEST['Stonestocks'])){
                            $model->iddept = $_REQUEST['Stonestocks']['iddept'];
                            $model->cdate=$_REQUEST['Stonestocks']['cdate'];
                            $model->mdate=$_REQUEST['Stonestocks']['mdate'];
                        }
                        if(isset(Yii::app()->session['iddeptstockreport'])){
                         $dept = Yii::app()->session['iddeptstockreport'];}else{
                         $dept='';
                          }
                          
                          if(isset(Yii::app()->session['cdatestockreport'])){
                         $cdate = Yii::app()->session['cdatestockreport'];}else{
                         $cdate='';
                          }
                          
                          if(isset(Yii::app()->session['mdatestockreport'])){
                         $mdate = Yii::app()->session['mdatestockreport'];}else{
                         $mdate='';
                          }
            
                        $dept = isset($model->iddept)?$model->iddept:$dept;
                        $cdate = isset($model->cdate)?$model->cdate:$cdate;
                        $mdate = isset($model->mdate)?$model->mdate:$mdate;
                            $dept = isset($model->iddept)?$model->iddept:$dept;
                           if($dept){
                            $count=Yii::app()->db->createCommand('select count(*) as count from (SELECT dept.iddept,dept.idstone,SUM(dept.qty) as qty, stm.name as name,stm.idstonem as stoneid,SUM(st.weight) as weight,st.idstonem from tbl_stonestocks dept, tbl_stonem stm,tbl_stone st where stm.idstonem=st.idstonem AND st.idstone=dept.idstone AND dept.iddept='.$dept.' AND dept.mdate >= "'.$cdate.'" AND dept.mdate <= "'.$mdate.'" group by st.idstone) as t1')->queryScalar();
       //echo $count;echo 'select count(*) as count from (SELECT dept.iddept,dept.idstone,SUM(dept.qty) as qty, stm.name as name,stm.idstonem as stoneid,SUM(st.weight) as weight,st.idstonem from tbl_deptstonelog dept, tbl_stonem stm,tbl_stone st where stm.idstonem=st.idstonem AND st.idstone=dept.idstone AND dept.iddept='.$model->iddept.' AND dept.mdate >= "'.$model->cdate.'" AND dept.mdate <= "'.$model->mdate.'" group by st.idstone) as t1';die();
                            /* Manish Changes on Oct-11 add shape and size field ----start--- */ 
                 
                            $sql = "SELECT s.idstone as stoneid,dsl.idstonestocks,dsl.mdate,sm.name as stonename,sh.name AS shape,ss.size AS size,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END))) AS quantity,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.stonewt WHEN dsl.qty = 0 THEN dsl.stonewt ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.stonewt ELSE 0 END))) AS weight FROM tbl_stone AS s JOIN tbl_stonestocks AS dsl ON s.idstone = dsl.idstone JOIN tbl_stonem AS sm ON s.idstonem = sm.idstonem JOIN tbl_shape AS sh ON sh.idshape = s.idshape JOIN tbl_stonesize AS ss ON s.idstonesize = ss.idstonesize WHERE dsl.mdate >= '$cdate' AND dsl.mdate <= '$mdate' AND dsl.iddept = '$dept' GROUP BY s.idstone";
                  /* Manish Changes add shape and size field ----end--- */  

                        $dataProvider=new CSqlDataProvider($sql, array(
                            'totalItemCount'=>$count,
                            'sort'=>array(
                                'attributes'=>array(
                                    'stonename','shape','size','weight',
                                ),
                            ),
                            'pagination'=>array(
                                'pageSize'=>50,
                            )
                        ));
                           }
                        Yii::app()->session['iddeptstockreport'] = $dept;
                        Yii::app()->session['cdatestockreport'] = $cdate;
                        Yii::app()->session['mdatestockreport'] = $mdate;
                           
                 $this->render('stoneStockReport', array(
                    'type' => $type, 'model' => $model,'dataProvider'=>$dataProvider,
                ));
                 
            }
            
            public function actionstoneSummary(){
               $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(30, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            } 
                $model = new Stonestocks('search');
                //$model=  Stone::model()->findAllByPk($id);
                $model->unsetAttributes();
                        if (isset($_POST['Stonestocks'])){
                            $model->iddept = $_POST['Stonestocks']['iddept'];
                        }
                        
                    if(isset(Yii::app()->session['iddeptsummary'])){
                         $dept = Yii::app()->session['iddeptsummary'];}else{
                         $dept='';
                          } 
              $dept = isset($model->iddept)?$model->iddept:$dept;
              if($dept){
            /* Manish Changes on Oct-11 add shape and size field ----start--- */
                            $sql = "SELECT s.idstone AS stoneid,dsl.idstonestocks,dsl.mdate,sm.name AS stonename,sh.name AS shape,ss.size AS size,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END))) AS quantity,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.stonewt WHEN dsl.qty = 0 THEN dsl.stonewt ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.stonewt ELSE 0 END))) AS weight FROM tbl_stone AS s JOIN tbl_stonestocks AS dsl ON s.idstone = dsl.idstone JOIN tbl_stonem AS sm ON s.idstonem = sm.idstonem JOIN tbl_shape AS sh ON sh.idshape = s.idshape JOIN tbl_stonesize AS ss ON s.idstonesize = ss.idstonesize WHERE dsl.iddept = $dept GROUP BY s.idstone ";
               /* Manish Changes add shape and size field ----end--- */  
                           
                            $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM (SELECT s.idstone AS stoneid,dsl.idstonestocks,dsl.mdate,sm.name AS stonename,sh.name AS shape,ss.size AS size,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END))) AS quantity,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.stonewt WHEN dsl.qty = 0 THEN dsl.stonewt ELSE 0 END) - ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.stonewt ELSE 0 END))) AS weight FROM tbl_stone AS s JOIN tbl_stonestocks AS dsl ON s.idstone = dsl.idstone JOIN tbl_stonem AS sm ON s.idstonem = sm.idstonem JOIN tbl_shape AS sh ON sh.idshape = s.idshape JOIN tbl_stonesize AS ss ON s.idstonesize = ss.idstonesize WHERE dsl.iddept = '.$dept.' GROUP BY s.idstone) a')->queryScalar();
             
                            
                            
                //print_r($sql);  
                $dataProvider=new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                'sort'=>array(
                    'attributes'=>array(
                         'stonename','shape','size',
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>40,
                ),
            ));
             }
            Yii::app()->session['iddeptsummary'] = $dept;
             
            $this->render('summaryreport',array(
            'type' => $type, 'model' => $model,'dataProvider'=>$dataProvider,
        ));
         
            
        }

        public function actionstoneStockDetail(){
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(31, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
               $model = new Stonestocks('search');
                //$model=  Stone::model()->findAllByPk($id);
                $model->unsetAttributes();
                        if (isset($_POST['Stonestocks'])){
                            $model->iddept = $_POST['Stonestocks']['iddept'];
                        }
                        
                        if(isset(Yii::app()->session['iddeptdetails'])){
                         $dept = Yii::app()->session['iddeptdetails'];}else{
                         $dept='';
                          }
                     $dept = isset($model->iddept)?$model->iddept:$dept;      
       
         /* Manish Changes on Oct-11 add shape and size field ----start--- */
                        if($dept){   
                            $sql='SELECT dsl.idstone as idstone, dsl.iddept as iddept,s.idstonem AS id,s.quality AS grade,SUM(CASE WHEN dsl.stonewt > 0 THEN dsl.stonewt WHEN dsl.stonewt = 0 THEN dsl.stonewt ELSE 0 END) AS rweight,SUM(CASE WHEN dsl.stonewt < 0 THEN dsl.stonewt ELSE 0 END) AS iweight,(SUM(stonewt)) AS balweight,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END)-ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END))) AS balqty,SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) AS receiptquantity,SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END) AS issuequantity,s.idstonem,s.idstonesize,sh.name AS shape, ss.size AS size,sm.name AS stonename FROM tbl_stone AS s JOIN tbl_shape AS sh ON s.idshape = sh.idshape JOIN tbl_stonesize AS ss ON s.idstonesize = ss.idstonesize JOIN tbl_stonem AS sm ON s.idstonem = sm.idstonem JOIN tbl_stonestocks AS dsl ON s.idstone = dsl.idstone WHERE dsl.iddept = '.$dept.' GROUP BY dsl.idstone';
          
            /* Manish Changes add shape and size field ----end--- */  
                $count=Yii::app()->db->createCommand('SELECT count(*) from (SELECT dsl.idstone as idstone, dsl.iddept as iddept, s.idstonem AS id,s.quality AS grade,SUM(CASE WHEN dsl.stonewt > 0 THEN dsl.stonewt WHEN dsl.stonewt = 0 THEN dsl.stonewt ELSE 0 END) AS rweight,SUM(stonewt) AS balweight,(SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END)-ABS(SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END))) AS balqty,SUM(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) AS receiptquantity,SUM(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END) AS issuequantity,s.idstonem,s.idstonesize,sh.name AS shape, ss.size AS size,sm.name AS stonename FROM tbl_stone AS s JOIN tbl_shape AS sh ON s.idshape = sh.idshape JOIN tbl_stonesize AS ss ON s.idstonesize = ss.idstonesize JOIN tbl_stonem AS sm ON s.idstonem = sm.idstonem JOIN tbl_stonestocks AS dsl ON s.idstone = dsl.idstone WHERE dsl.iddept = '.$dept.' GROUP BY dsl.idstone) a')->queryScalar(); 
              //  print_r($sql);  
                $dataProvider=new CSqlDataProvider($sql, array(
                'totalItemCount'=>$count,
                'sort'=>array( 
                    'attributes'=>array(
                         'grade','shape','size','stonename',
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>50,
                ),
            ));
                        }
             Yii::app()->session['iddeptdetails'] = $dept;
            $this->render('stonestockdetail',array(
            'type' => $type, 'model' => $model,'dataProvider'=>$dataProvider,
        ));
           
           
        }  
        public function actionstoneStockLedger(){ 
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(32, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
           
             if(isset($_POST['idshape']) && isset($_POST['idstonem']) && isset($_POST['idstonesize']) && isset($_POST['iddept']))
             {
                        $idshape = $_POST['idshape'];
                        $idstonem = $_POST['idstonem']; 
                        $idstonesize = $_POST['idstonesize'];                       
                        $iddept = $_POST['iddept'];
                      $idstone = Stone::model()->findByAttributes(array('idshape'=>$idshape, 'idstonem'=>$idstonem))->idstone;
              }else{
                            $idshape = '0';
                            $idstonem = '0';
                            $idstonesize = '0';                            
                            $iddept = '0';
                            $idstone = 0;
                            } 
                             /* Manish Changes on Oct-11 add shape and size field ----start--- */
              
                          
                 //$sql='SELECT d.name as department,date(from_unixtime(UNIX_TIMESTAMP(dsl.cdate))) AS issuedate,date(from_unixtime(UNIX_TIMESTAMP(dsl.mdate))) AS receivedate,s.idshape,s.idstonem,s.idstonesize,(CASE WHEN dsl.qty > 0 THEN dsl.qty ELSE 0 END) AS rqty,(CASE WHEN dsl.qty > 0 THEN dsl.stonewt WHEN dsl.qty = 0 THEN dsl.stonewt ELSE 0 END) AS rweight,(CASE WHEN dsl.qty < 0 THEN dsl.stonewt ELSE 0 END) AS iweight,(CASE WHEN dsl.qty < 0 THEN dsl.qty ELSE 0 END) AS iqty,dsl.stonewt,dsl.iddept,dsl.qty FROM tbl_deptstonelog AS dsl JOIN tbl_stone AS s ON s.idstone = dsl.idstone JOIN tbl_dept AS d ON d.iddept = dsl.iddept WHERE s.idshape = '.$idshape.' AND s.idstonem = '.$idstonem.' AND s.idstonesize = '.$idstonesize;
                  $sql = 'SELECT * FROM `tbl_stonestocks`  where iddept = '.$iddept.' and idstone = "'.$idstone.'" order by mdate asc ';
                /* Manish Changes add shape and size field ----end--- */  
                   $count=Yii::app()->db->createCommand('SELECT COUNT(a.idstonestocks) FROM (SELECT * FROM `tbl_stonestocks`  where iddept = 4 and idstone = 1809 order by mdate asc  ) a')->queryScalar();
                  //  print_r($sql);  
                    $dataProvider=new CSqlDataProvider($sql, array(
                    'totalItemCount'=>$count,
                    'pagination'=>array(
                        'pageSize'=>100,
                    ),
                ));
                    
                $this->render('stonestockledger',array(
            'type' => $type,'idshape'=>$idshape,'idstonesize'=>$idstonesize,'idstonem'=>$idstonem, 'dataProvider'=>$dataProvider
        ));
                  
        }
        /**
         * Export the Grid in a prticular Excel file Sudhanshu
         */
        public function actionExcel() {
            $export=$_POST['ids'];
            $skucontent = array();
            $i = 0;
            foreach ($export as $exp)
            {    
                $loc = Deptskulog::model()->findBypk($exp);
                $skucontent[$i]['skucode'] = $loc->idsku0->skucode;
                $skucontent[$i]['idpo'] = $loc->po_num;
                $skucontent[$i]['totqty'] = Deptskulog::getTotalsku($loc->po_num, $loc->idsku0->skucode, $loc->iddept)[0]["qty"];
                $skucontent[$i]['qtyship'] = Deptskulog::getShippedsku($loc->po_num, $loc->idsku0->skucode, $loc->iddept)[0]["qty"];;
                $skucontent[$i]['totwt'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->grosswt, 2, ".", "");
                $skucontent[$i]['totstone'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->totstowei, 2, ".", "");
                $skucontent[$i]['totmetwt'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->totmetalwei, 2, ".", "");
                $skucontent[$i]['balqty'] = $skucontent[$i]['totqty'] + $skucontent[$i]['qtyship'];
                $skucontent[$i]['locref'] = $loc->locref;
                $skucontent[$i]['currency'] = ComSpry::currencyName($loc->currency);
                $skucontent[$i]['pricepp'] = $loc->pricepp;
                $skucontent[$i]['lupdated'] = $loc->mdate; 
                $i++;
            }
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

            // Turn off our amazing library autoload
            spl_autoload_unregister(array('YiiBase','autoload'));


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
            ->setCellValue('A1', 'SKU#')
            ->setCellValue('B1', 'PO# ')
            ->setCellValue('C1', "Total Qty")
            ->setCellValue('D1', 'Total weight ')
            ->setCellValue('E1', 'Total Stone Wt')
            ->setCellValue('F1', 'Total Metal wt')
            ->setCellValue('G1', 'Shipped Qty')
            ->setCellValue('H1', 'Balance Qty')
            ->setCellValue('I1', 'Location Ref')        
            ->setCellValue('J1', 'Currency')
            ->setCellValue('K1', 'Price PP')
            ->setCellValue('L1', 'Last Updated')        
                    ;
            $i = 0; 
            foreach($skucontent as $values){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 2), $values['skucode']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 2), $values['idpo']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 2), $values['totqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 2), $values['totwt']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 2), $values['totstone']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 2), $values['totmetwt']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i + 2), $values['qtyship']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i + 2), $values['balqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i + 2), $values['locref']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i + 2), $values['currency']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i + 2), $values['pricepp']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i + 2), $values['lupdated']); 
                $i++;
            }
            
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1'); 

            // Redirect output to a client's web browser (Excel2007)
            header('Content-Type: application/xlsx');
            header('Content-Disposition: attachment;filename="Sku-Report.xlsx"');
            header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            Yii::app()->end();

            // Once we have finished using the library, give back the
            // power to Yii...
            spl_autoload_register(array('YiiBase','autoload'));           
        }   
           
        /**
         * Export the full Data in a prticular Excel file for UK Dept. Sudhanshu 
         */
             public function actionexcelAll($iddept) {
                $skucontent = array();
                 $i = 0;
                 $sql='select * from tbl_deptskulog t where t.iddept='. $iddept;
                 $count=Yii::app()->db->createCommand($sql)->queryScalar();
                $dataProvider=new CSqlDataProvider($sql, array(
                     'totalItemCount'=>$count,
                     'pagination'=>array(
                     'pageSize'=>1000,
                ),
                ));
                $data = $dataProvider->getData();
                foreach ($data as $results)
                    {   
                        $loc = Deptskulog::model()->findBypk($results['iddeptskulog']);
                        $skucontent[$i]['skucode'] = $loc->idsku0->skucode;
                        $skucontent[$i]['idpo'] = $loc->po_num;
                        $skucontent[$i]['totqty'] = Deptskulog::getTotalsku($loc->po_num, $loc->idsku0->skucode, $loc->iddept)[0]["qty"];
                        $skucontent[$i]['qtyship'] = Deptskulog::getShippedsku($loc->po_num, $loc->idsku0->skucode, $loc->iddept)[0]["qty"];;
                        $skucontent[$i]['totwt'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->grosswt, 2, ".", "");
                        $skucontent[$i]['totstone'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->totstowei, 2, ".", "");
                        $skucontent[$i]['totmetwt'] = number_format(($skucontent[$i]['totqty'] + $skucontent[$i]['qtyship']) * $loc->idsku0->totmetalwei, 2, ".", "");
                        $skucontent[$i]['balqty'] = $skucontent[$i]['totqty'] + $skucontent[$i]['qtyship'];
                        $skucontent[$i]['locref'] = $loc->locref;
                        $skucontent[$i]['currency'] = ComSpry::currencyName($loc->currency);
                        $skucontent[$i]['pricepp'] = $loc->pricepp;
                        $skucontent[$i]['lupdated'] = $loc->mdate; 
                        $i++;
                    }
                       
                
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
             spl_autoload_unregister(array('YiiBase','autoload'));

             
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
            ->setCellValue('A1', 'SKU#')
            ->setCellValue('B1', 'PO# ')
            ->setCellValue('C1', "Total Qty")
            ->setCellValue('D1', 'Total weight ')
            ->setCellValue('E1', 'Total Stone Wt')
            ->setCellValue('F1', 'Total Metal wt')
            ->setCellValue('G1', 'Shipped Qty')
            ->setCellValue('H1', 'Balance Qty')
            ->setCellValue('I1', 'Location Ref')        
            ->setCellValue('J1', 'Currency')
            ->setCellValue('K1', 'Price PP')
            ->setCellValue('L1', 'Last Updated')        
                    ;
            $i = 0; 
            foreach($skucontent as $values){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 2), $values['skucode']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 2), $values['idpo']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 2), $values['totqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 2), $values['totwt']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($i + 2), $values['totstone']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 2), $values['totmetwt']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i + 2), $values['qtyship']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($i + 2), $values['balqty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($i + 2), $values['locref']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($i + 2), $values['currency']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($i + 2), $values['pricepp']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($i + 2), $values['lupdated']);
                 $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

          // Redirect output to a client's web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Sku-Report.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));           
           }  
           

           /**
            * get balance weight of a stone on that particular day
            */
           public function balanceWt($data, $row){ 
               $sql = 'SELECT (SUM(CASE WHEN stonewt > 0 THEN stonewt WHEN stonewt = 0 THEN stonewt ELSE 0 END) - ABS(SUM(CASE WHEN stonewt < 0 THEN stonewt ELSE 0 END))) AS wt FROM `tbl_stonestocks` where iddept = "'.$data['iddept'].'" and idstone = "'.$data['idstone'].'" and mdate <= "'.$data['mdate'].'"';
               $rows = Yii::app()->db->createCommand($sql)->queryRow();
               return (abs($rows['wt']));
               
           }
           
           /**
            * get balance quantity of a stone on that particular day
            */
           public function balanceQty($data, $row){
               $sql = 'SELECT sum(qty) as stonewt FROM `tbl_stonestocks` where iddept = "'.$data['iddept'].'" and idstone = "'.$data['idstone'].'" and mdate <= "'.$data['mdate'].'"';
               $rows = Yii::app()->db->createCommand($sql)->queryRow();
               return (abs($rows['qty']));
           }
           
           public function balanceWtDetails($data, $row){  
               $sql = 'SELECT (SUM(CASE WHEN stonewt > 0 THEN stonewt WHEN stonewt = 0 THEN stonewt ELSE 0 END) - ABS(SUM(CASE WHEN stonewt < 0 THEN stonewt ELSE 0 END))) AS wt FROM `tbl_stonestocks` where iddept = "'.$data['iddept'].'" and idstone = "'.$data['idstone'].'"';
               $rows = Yii::app()->db->createCommand($sql)->queryRow();
               return (abs($rows['wt']));
               
           }
           
           
}
