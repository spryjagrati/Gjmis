<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JZ
 *
 * @author maverick
 */
class Snn {

    public function export($skuids) {

    $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        $pathname = dirname(dirname(Yii::app()->basePath));
        $folderto = '/gjmis/images/temp/'.date('ymdhis');

        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        //echo "<pre>";print_r($totalsku);die();
         //metal array for item description
        $silver_arr= array('.925 Silver W/Rhodium'=>'Silver','925 Silver W/Oxside'=>'Silver','.925 Silver'=>'Silver','.925 Silver W/Platinum Plating'=>'Silver','Brass W/Rhodium'=>'Silver','Brass W/Platinum Plating'=>'Silver');

        $gold_arr = array('9K Yellow Gold'=>'9K Yellow Gold','9K White Gold'=>'9K White Gold','9K Rose Gold'=>'9K Rose Gold','10K Yellow Gold'=>'10K Yellow Gold','10K White Gold'=>'10K White Gold','10K Rose Gold'=>'10K Rose Gold','14K Yellow Gold'=>'14K Yellow Gold','14K White Gold'=>'14K White Gold','14K Rose Gold'=>'14K Rose Gold','18K Yellow Gold'=>'18K Yellow Gold','18K White Gold'=>'18K White Gold','18K Rose Gold'=>'18K Rose Gold');
 
        $gold_plated = array('.925 Silver W/14KGP'=>'14K Yellow Gold Plated','.925 Silver W/18KGP'=>'18K Yellow Gold Plated','.925 Silver W/14K RGP'=>'14K Rose Gold Plated','.925 Silver W/18K RGP'=>'18K Rose Gold Plated','.925 Silver W/14KW GP'=>'14K White Gold Plated','Brass W/14KGP'=>'14K Yellow Gold Plated','Brass W/14K RGP'=>'14K Rose Gold Plated');

        $add_manually = array('9K 2Tone','.925 Silver W/3Tone','.925 Silver W/2Tone','.925 Silver W/1Mic GP','.925 Silver W/2Mic GP','.925 Silver W/3Mic GP','.925 Silver W/1Mic RGP','.925 Silver W/2Mic RGP','.925 Silver W/3Mic RGP');

        for ($i = 2; $i < (($repeat) + 2); $i++) {

            $objPHPExcel = new PHPExcel();

            //$filepath = Yii::app()->getBasePath() . '/components/exports/SNN.xls'; live
            $filepath = Yii::app()->getBasePath() . '/components/SNN.xls';
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objPHPExcel = PHPExcel_IOFactory::load($filepath);
            
            $objPHPExcel->getProperties()->setCreator("SNN")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
            
            $skucode =$totalsku[($i-2)][0]['skucode'];

            if($totalsku[($i-2)][15] == 'MM'){
                $dia_wid = $totalsku[($i-2)][0]['dimwid'] * 0.0393701;
                $dia_ht = $totalsku[($i-2)][0]['dimhei']  * 0.0393701;
            }else{
                $dia_wid = $totalsku[($i-2)][0]['dimwid'];
                $dia_ht= $totalsku[($i-2)][0]['dimhei'];
            }

           
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G2',date("m/d/Y"))
            ->setCellValue('G6', $totalsku[($i-2)][0]['skucode'])
            ->setCellValue('B19', $totalsku[($i-2)][2][0]['setting'])
            ->setCellValue('B21', round($dia_wid,2).'/'.round($dia_ht,2).' inches');
           

            if($totalsku[($i-2)][1]['type'] == 'Pendant'){
                $length = $totalsku[($i-2)][0]['dimlen'];
                if($totalsku[($i-2)][15] == 'MM'){
                    $length = $length * 0.0393701;
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B20', $length.' inches');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B23', $totalsku[($i-2)][1]['size']);
            }elseif($totalsku[($i-2)][1]['type'] == 'Ring'){
                $width = $totalsku[($i-2)][0]['dimwid'];
                if($totalsku[($i-2)][15] == 'MM'){
                    $width = $width * 0.0393701;
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G17', $width.' inches');
            }elseif($totalsku[($i-2)][1]['type'] == 'Earrings'){
                if(isset($totalsku[($i-2)][12][0])){
                    $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('B25', $totalsku[($i-2)][12][0]['name']);
                }
            }elseif($totalsku[($i-2)][1]['type'] == 'Bracelet'){
                if(isset($totalsku[($i-2)][12][0])){
                    $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('B24', $totalsku[($i-2)][12][0]['name']);
                }
            }

            if(isset($totalsku[($i-2)][17]) && $totalsku[($i-2)][17] > 0){
                $objPHPExcel->setActiveSheetIndex(0)
                 ->setCellValue('G19', $totalsku[($i-2)][0]['totmetalwei']+ $totalsku[($i-2)][17]);
                if($totalsku[($i-2)][1]['type'] == 'Pendant'){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H19', 'With Chain');
                }
            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G19', $totalsku[($i-2)][0]['totmetalwei']+ $totalsku[($i-2)][17]);
            }

            $finish = $totalsku[($i-2)][16];
            if(stripos($finish,'Rhodium') !== false){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G20', 'Yes');
            }
            
            $sizestone = sizeof($totalsku[($i-2)][2]);
            $diamond = 0;
            $gems = 0;
            $we = 0;
            $stone_wt = 0;
            $diamond_wt = 0;
            $diamond_name = '';

            for ($k = 0; $k < $sizestone; $k++) {
                $we+= $totalsku[($i-2)][2][$k]['weight'];
                if ($totalsku[($i-2)][2][$k]['type'] == 'diamond') {
                    $diamond_wt+= $totalsku[($i-2)][2][$k]['tot_weight'];
                    $diamond_name2 = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i-2)][2][$k]['name']));
                    $diamond_name = isset($diamond_name2) ? $diamond_name2->alias : $totalsku[($i-2)][2][$k]['name'];
                    $diamond++;
                } else {
                    $stone_wt+= $totalsku[($i-2)][2][$k]['tot_weight'];
                    $gems++;
                }

                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i-2)][2][$k]['name']));
                $totalsku[($i-2)][2][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i-2)][2][$k]['name']; 
            }

            $metaln= $totalsku[($i-2)][4]; $t_metal='Silver';$costname='';$metalname = '925 Sterling silver';
            if(array_key_exists($metaln, $silver_arr)){
                $color = 'White';
            }elseif(array_key_exists($metaln, $gold_arr)){
                //$costname = 
                $t_metal =$gold_arr[$metaln].' ';
                $color = $this->getColor($totalsku[($i-2)][4]);
                $metalname =$metaln ;
            }elseif(array_key_exists($metaln, $gold_plated)){
                $costname = $gold_plated[$metaln].' ';
                $get_c = explode(' ',$costname);
                $color=$get_c[1];
            }elseif(in_array($metaln, $add_manually)){
                if($metaln == '9K 2Tone'){
                    $t_metal = '9K Gold';
                    $metalname =$metaln ;
                    foreach($totalsku[($i - 2)][18] as $addon){
                        if(stripos($addon['name'],'RG') !== false){
                            $color='Rose';
                        }elseif(stripos($metaln, 'WG')!== false){
                            $color='White';
                        } 
                    }
                }elseif($metaln == '.925 Silver W/3Tone' || $metaln == '.925 Silver W/2Tone'){
                    foreach($totalsku[($i - 2)][18] as $addon){
                        if(stripos($addon['name'],'Gold Plating') !== false){
                            $costname = str_replace('ing', 'ed', $addon['name']) . ' ';
                            $get_c = explode(' ',$costname);
                            $color=$get_c[1];
                        }
                    }
                }else{
                    foreach($totalsku[($i - 2)][18] as $addon){
                        if(stripos($addon['name'],'Gold Plating') !== false){
                            $costname = str_replace('ing', 'ed', $addon['name']) . ' ';
                            if(stripos($metaln, 'GP')!== false){
                                $color='Yellow';
                            }elseif(stripos($metaln, 'RGP')!== false){
                                $color='Rose';
                            } 
                        }
                    }
                }
            }

            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8',$costname.(number_format($stone_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' and '.$totalsku[($i-2)][2][1]['name'].' '.$t_metal.' ' .$totalsku[($i-2)][1]['type']));
                
            } elseif ($diamond == 1 && $gems == 1) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8', $costname.(number_format($diamond_wt + $stone_wt, 2, '.', '').' Carat Genuine '.ComSpry::findalias($totalsku[($i-2)][2][0]['name'], 1).' and '.$totalsku[($i-2)][2][1]['name'].' '.$t_metal.' '.$totalsku[($i-2)][1]['type']));
    

            }elseif ($diamond == 0 && $gems > 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8', $costname.(number_format($stone_wt, 2, '.', '').' Carat Genuine Multi-GemStone '.$t_metal.' '.$totalsku[($i-2)][1]['type']));


            }elseif ($gems > 1 && $diamond != 0) {

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8', $costname. (number_format($stone_wt + $diamond_wt, 2, '.', '').' Carat Genuine Multi-GemStone'.' and '. $diamond_name. ' ' .$t_metal.' '.$totalsku[($i-2)][1]['type']));


            } elseif ($diamond == 2 && $gems == 0) {
                  $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8', $costname. (number_format($diamond_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' and '. $totalsku[($i -2)][2][1]['name']. ' ' .$t_metal.' '.$totalsku[($i-2)][1]['type']));

            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G8', $costname. (number_format($diamond_wt + $stone_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' '.$t_metal.' ' .$totalsku[($i-2)][1]['type']));

            } 

            $mainstone = $totalsku[($i-2)][2][0];

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A30', $mainstone['name'])
                ->setCellValue('B30', $mainstone['shape'])
                ->setCellValue('C30', $mainstone['cut'])
                ->setCellValue('C32', $mainstone['country'])
                ->setCellValue('D30', $mainstone['size'])
                ->setCellValue('E30', $mainstone['weight'])
                ->setCellValue('E32', $mainstone['color'])
                ->setCellValue('G30', $mainstone['pieces'])
                ->setCellValue('B17', $metalname)
                ->setCellValue('H30', '=E30*G30');

            for($k=36 ; $k<=51 ; $k++){
                 $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue('H' . $k, '0.00');
            }

            $stone = $totalsku[($i-2)][2]; $k = 36;$p =1;
            $stonesize = sizeof($totalsku[($i-2)][2]);
            foreach($stone as $key => $value){
                $stonename='';
                if($key != 0){
                    $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue('A' . $k, $value['name'] )
                      ->setCellValue('B' . $k, $value['shape'])
                      ->setCellValue('C' . $k, $value['cut'])
                      ->setCellValue('D' . $k, $value['size'])
                      ->setCellValue('E' . $k, $value['weight'])
                      ->setCellValue('G' . $k, $value['pieces'])
                      ->setCellValue('H' . $k, '= E'.($k).'*G'.($k));
                    $k++;$p++;
                }
            }

           
            $objPHPExcel->getActiveSheet()->getStyle('H36:H52')->getNumberFormat()->setFormatCode('#,##0.#0');
           

            $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('G52', '= SUM(G36:G51)')
                  ->setCellValue('H52' ,'= SUM(H36:H51)')
                  ->setCellValue('B18', $color )
                  ->setCellValue('A2', '' );

            //image drawing
            if(isset($totalsku[($i-2)][3][0])){
                $imagename = $totalsku[($i-2)][3][0];
                //$basepath = Yii::app()->basePath . '/..' .$imagename; live
                $basepath = dirname(dirname(Yii::app()->basePath)).$imagename;
                if(file_exists($basepath)){
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('image');
                    $objDrawing->setDescription('image');
                    $objDrawing->setPath($basepath);
                    $objDrawing->setCoordinates('A2');
                    $objDrawing->setOffsetX(40); 
                    $objDrawing->setOffsetY(5);
                    $objDrawing->setWidthAndHeight(2000,225);
                    $objDrawing->setResizeProportional(true);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }
                
            }

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('G36:G51')->applyFromArray(array(
                    'font'  => array(
                        'bold'  => true,
                        'size'  => 9,
                        'name'  => 'Calibri'
                    ),
                )
            );

            
            $styleLeftAlign = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                ),
            );
            $styleCenterAlign = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
            );

            $objPHPExcel->getActiveSheet()->getStyle('B17:B25')->applyFromArray($styleLeftAlign);
            $objPHPExcel->getActiveSheet()->getStyle('A36:H52')->applyFromArray($styleCenterAlign);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleCenterAlign);
           

            $new_skucode = str_replace('/', '_', $skucode);
            //$innerfolder = preg_replace("[^\w\s\d\.\-_~,;:\[\]\(\]]", '', $totalsku[($i-2)][0]['skucode']);
            $innerfolder = preg_replace("[^\w\s\d\.\-_~,;:\[\]\(\]]", '', $new_skucode);

            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->setPreCalculateFormulas();

            if (!file_exists($pathname.$folderto.'/'.$innerfolder)){
                if (!mkdir($pathname.$folderto.'/'.$innerfolder, 0777, true)) {
                    die('Failed to create folders...');
                }else{
                   // $objWriter->save($pathname.$folderto.'/'.$innerfolder.'/'.'SN'.'_'.$skucode.'.xlsx');
                    $objWriter->save($pathname.$folderto.'/'.$innerfolder.'/'.'SN'.'_'.$new_skucode.'.xlsx');
                }
            }
        }
        $this->zipdirectory($pathname, $folderto);
    }

    public function getColor($metal){
        $color = '';
        if(stripos($metal , 'Yellow') !== false){
            $color = 'Yellow';
        }elseif(stripos($metal , 'White') !== false){
            $color = 'White';
        }elseif(stripos($metal , 'Rose') !== false){
            $color = "Rose";
        }elseif(stripos($metal , 'Silver') !== false){
            $color = "White";
        }
        return $color;
    }


    /**
     * Create an array of all skus and their components
     */
    public function masterarray($ids){
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            $aliases = Aliases::model()->findAll();
            $depends = DependentAlias::model()->findAll();
            $skucontent = $sku->skucontent;
            $skuaddon =$sku->skuaddons;
              
            $category = stripos($skucontent->type, 'Earring') !== false ? $skucontent->type : $skucontent->type.'s';
            $skustones = $sku->skustones;
            $dimunit = $sku->dimunit == 'IN' ? 'inches' : $sku->dimunit;
            $stones = array();
            foreach ($skustones as $skustone) {
                $settingalias = Aliases::model()->findbyattributes(array('initial' => $skustone->idsetting0->name, 'aTarget' => 12, 'aField' => 'Setting'));
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' =>$skustone->idstone0->weight * $skustone->pieces,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => isset($settingalias) ? $settingalias->alias : $skustone->idsetting0->name,
                    'color' => $skustone->idstone0->color,
                    'country' => $skustone->idstone0->scountry,
                    'clarity' => $skustone->idstone0->idclarity0['name'],
                    'shape' => trim($skustone->idstone0->idshape0->name),
                    'size' => $skustone->idstone0->idstonesize0->size,
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,
                    'ppc' => $skustone->idstone0->curcost,
                    'pps' => (($skustone->idstone0->curcost) * ($skustone->idstone0->weight)),
                    'name' => $skustone->idstone0->namevar,
                    'weight' => $skustone->idstone0->weight,
                    'type' => $skustone->idstone0->idstonem0->type,
                    'mainstone' => $skustone->idstone0->idstonem0->name,
                    'treatm' => $skustone->idstone0->idstonem0->treatmeth,
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month,
                ); 
            }
            $stones[0]['flag'] = true;
            $newstones = Newstone::unqiuestones($stones);
            //$stonecode = $this->stoneDetails($stones);
            $skuimages = $sku->skuimages();
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                if($skuimage->type == 'MISG'){
                    $imageUrls[] = $skuimage->imageThumbUrl;
                } 
            }
            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metal_name = $skumetal->idmetal0->idmetalm0->name;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            
            $finisingalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->namevar, 'aTarget' => 11, 'aField' => 'Finish'));
            $finishing = isset($finisingalias) ? $finisingalias->alias : $skumetal->idmetal0->namevar;
            
            $finisingalias = Aliases::model()->findbyattributes(array('initial' => $finishing, 'aTarget' => 12, 'aField' => 'Finish/Plating'));
            $finishing = isset($finisingalias) ? $finisingalias->alias : $finishing;

           
            $finds = array();
            $findwt = 0;
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    //'find_metal' = $finding->idfinding0->idmetal0->namevar,
                );
                $findwt += $finding->idfinding0->weight;
            }

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

            foreach($skuaddon as $skuadd){
                $addon[] = array(
                    'id'=> $skuadd->idskuaddon,
                    'name'=> $skuadd->idcostaddon0->name,
                );
            }
            //$depends $alias
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $category, $dimunit,$finishing, $findwt,$addon);
           
        }
        return $totalsku;
    }

    public static function zipdirectory($path, $directory){
        $rootPath = $path . $directory;
        $zip = new ZipArchive;
        $zip->open($rootPath.'.zip', ZipArchive::CREATE); 
        $files = array_merge(glob($rootPath."/*/*.XLSX") , glob($rootPath."/*/*.xlsx"));
        $files = array_merge(glob($rootPath."/*/*.xlsx") , $files);
        $zip->addEmptyDir('.');
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        header('Content-disposition: attachment; filename=attachment.zip');
        header('Content-type: application/zip');
        readfile($rootPath.'.zip');
        header("Pragma: no-cache");
        header("Expires: 0");
    }

}