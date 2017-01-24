<?php

class Qov extends CController {

    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        // print_r($repeat);die;
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        //include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel'. DIRECTORY_SEPARATOR . 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        //$filepath = Yii::app()->getBasePath() . '/components/exports/QOV Format.xls';
        $filepath = Yii::app()->getBasePath() . '/components/QOV Format.xls';
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        //echo $filepath;die();
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);

        $objPHPExcel->getProperties()->setCreator("GJMIS")
            ->setLastModifiedBy("GJMIS")
            ->setTitle("Excel Export Document")
            ->setSubject("Excel Export Document")
            ->setDescription("Exporting documents to Excel using php classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Excel export file");
        for ($i = 3; $i < (($repeat) + 3); $i++) {
            $costname = '';
            $finish_type = '';
            foreach ($totalsku[($i - 3)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                    $finish_type = "\nFinish Type:".preg_replace('/\W\w+\s*(\W*)$/', '$1', $formula['name']);
                }elseif(strpos($formula['name'], 'Rhodium') !== false){
                     $finish_type = "\nFinish Type: Rhodium Finish";
                }
            }
            $metal_name = '';
            $metal_nm = '';
            $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 3)][13][0]['name']));
            $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 3)][13][0]['name'];
        
            if(strrpos($totalsku[($i -3)][4],'Gold') !== false){
             $metal_name = $totalsku[($i -3)][4].', '.$stone_alias_name;
             $metal_nm = $totalsku[($i -3)][4];
            } elseif(strrpos($totalsku[($i -3)][4],'Silver') !== false){
                $metal_name = '.925 Sterling Silver, '.$stone_alias_name;
                $metal_nm = ".925 Sterling Silver";
            }else {
                $metal_name = $totalsku[($i -3)][4].', '.$stone_alias_name;
                $metal_nm = $totalsku[($i -3)][4];
            }
      
            $styleThickBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    ),
                ),
            );

        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':AN' . $i)->applyFromArray($styleThickBlackBorderOutline);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, ($i-2))
            ->setCellValue('B' . $i, 'M')
            ->setCellValue('C' . $i, '1')
            ->setCellValue('D' . $i, $totalsku[($i - 3)][0]['skucode'])
            ->setCellValue('F' . $i,$totalsku[($i - 3)][0]['refpo']);

        $sizestone = sizeof($totalsku[($i - 3)][13]);
        $diamond = 0;
        $gems = 0;
        $we = 0;
        $stone_wt = 0;
        $diamond_wt = 0;
        $t_metal = (strpos($totalsku[($i - 3)][4], 'Brass') !== false) ? "Brass" : $totalsku[($i - 3)][4];
            $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }
            
        $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 3)][13][0]['name']));
        $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 3)][13][0]['name'];


    {
                for ($k = 0; $k < $sizestone; $k++) {
                    $we+= $totalsku[($i - 3)][13][$k]['weight'];
                    if ($totalsku[($i - 3)][13][$k]['type'] == 'diamond') {
                        $diamond_wt+= $totalsku[($i - 3)][13][$k]['weight'];
                        $diamond++;
                    } else {
                        $stone_wt+= $totalsku[($i - 3)][13][$k]['weight'];
                        $gems++;
                    }
                    
                    // $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 3)][13][$k]['name']));
                    // $totalsku[($i - 3)][13][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 3)][13][$k]['name'];
            
                }
            }


            $gemstone = "\nGemstone(s): Genuine ";
            $treatment = "\n\nTreatment Code: ";
            for($j = 0; $j < $sizestone; $j++){
                
                $stone_alias_treatcode = Aliases::model()->findbyattributes(array('aTarget' => '13', 'aField' => 'Treatment Method', 'initial' => $totalsku[($i - 3)][13][$j]['name']));
                $treatmentcode = isset($stone_alias_treatcode) ? $stone_alias_treatcode->alias : '('.substr($totalsku[($i -3)][13][$j]['tmeth'],0,1).')';

                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i -3)][13][$j]['name']));
                $totalsku[($i -3)][13][$j]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i -3)][13][$j]['name'];
               
                if($sizestone == 1){
                    $gemstone = $gemstone.$totalsku[($i -3)][13][$j]['name'];
                    $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode;
                }elseif($sizestone == 2){
                    if($j+1 == $sizestone){
                        $gemstone = ' '.$gemstone.$totalsku[($i -3)][13][$j]['name'];
                        $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode;
                    }else{
                        $gemstone = $gemstone.$totalsku[($i -3)][13][$j]['name'].' & ';
                        $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode.', ';
                    }
                }elseif($sizestone >= 3){
                    if($j+1 == $sizestone){
                        $gemstone = $gemstone.' & '.$totalsku[($i -3)][13][$j]['name'];
                        $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode;
                    }elseif($j+2 == $sizestone){
                        $gemstone = $gemstone.$totalsku[($i -3)][13][$j]['name'];
                        $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode.', ';
                    }else{
                        $gemstone = $gemstone.$totalsku[($i -3)][13][$j]['name'].', ';
                        $treatment = $treatment.$totalsku[($i -3)][13][$j]['name'].' '.$treatmentcode.', ';
                    }
                }
                  
            }
            
            
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 3)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 3)][13][1]['name'], 1) . ' ' . $totalsku[($i - 3)][1]['type'] . ' in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 3)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 3)][13][1]['name'], 1) . ' ' . $totalsku[($i - 3)][1]['type'] . ' in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)));
                        
            } elseif ($diamond == 1 && $gems == 1 || ($diamond >= 2 && $gems == 1)) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 3)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 3)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']));
                       
            } elseif ($diamond == 0 && $gems > 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($totalsku[($i - 3)][17][0]['weight'], 2, '.', '') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 3)][13][0]['name'], 1) . ' ' . $totalsku[($i - 3)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 3)][17][0]['weight']), 2, '.', '') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($totalsku[($i - 3)][17][0]['weight'], 2, '.', '') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 3)][13][0]['name'], 1) . ' ' . $totalsku[($i - 3)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 3)][17][0]['weight']), 2, '.', '') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)));
                        
            } elseif ($gems >= 2 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']));
                        
            } elseif ($diamond == 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 3)][13][0]['name'] . ' and ' . $totalsku[($i - 3)][13][1]['name'] . ' ' . $totalsku[($i - 3)][1]['type'] . ' in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 3)][13][0]['name'] . ' and ' . $totalsku[($i - 3)][13][1]['name'] . ' ' . $totalsku[($i - 3)][1]['type'] . ' in ' . ComSpry::findalias($totalsku[($i - 3)][4], 1)));
                       
            }elseif ($diamond > 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Diamond '.ComSpry::findalias($totalsku[($i - 3)][4], 1).' '.$totalsku[($i - 3)][1]['type']))
                         ->setCellValue('K' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Diamond '.ComSpry::findalias($totalsku[($i - 3)][4], 1).' '.$totalsku[($i - 3)][1]['type']));
                          
            }else{
           $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('I' . $i, $prepend.$costname . (number_format($totalsku[($i - 3)][0]['totstowei'], 2, '.', '') .
                                ' Carat Genuine ' . $totalsku[($i - 3)][13][0]['name'] . ' ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']))
                        ->setCellValue('K' . $i, $prepend.$costname . (number_format($totalsku[($i - 3)][0]['totstowei'], 2, '.', '') .
                                ' Carat Genuine ' . $totalsku[($i - 3)][13][0]['name'] . ' ' . ComSpry::findalias($totalsku[($i - 3)][4], 1) . ' ' . $totalsku[($i - 3)][1]['type']));
                        
            }
            
            $size = '';
            $item_desc = '';
            if($totalsku[($i - 3)][1]['type'] == 'Ring'){
            $size = ' Size '.preg_replace('/#/', '', $totalsku[($i - 3)][1]['size']);
            $item_desc =  "\n\nRing Size: ".preg_replace('/#/', '', $totalsku[($i - 3)][1]['size'])." (not re-sizable)";
            }elseif($totalsku[($i - 3)][1]['type'] == 'Bracelet'){
              $item_desc = "\n\nBracelet Length: ".$totalsku[($i - 3)][1]['size'];
            }elseif($totalsku[($i - 3)][1]['type'] == 'Pendant'){
        if(isset($totalsku[($i -3)][12][0])){
                    if(strpos($totalsku[($i -3)][12][0]['chain_metal'],"Gold")){
                        $item_desc = "\n\n".'18" Gold chain included.';
                    }else{
                        $item_desc = "\n\n".'18" Silver chain included.';
                    }
                }
            }          
            
          
              
            $stone_num = sizeof($totalsku[($i - 3)][2]);
            $shape_size = '';

            for($k = 0; $k < $stone_num; $k++){
                 if(stristr($totalsku[($i -3)][2][$k]['name'], 'Diamond')){
                       $totalsku[($i -3)][2][$k]['shape'] = str_replace('S/C', '', $totalsku[($i -3)][2][$k]['shape']);
                       $totalsku[($i -3)][2][$k]['shape'] = str_replace('F/C', '', $totalsku[($i -3)][2][$k]['shape']);
                 }else{
                    $totalsku[($i -3)][2][$k]['shape'] = ' '.$totalsku[($i -3)][2][$k]['shape'];
                  }
                 
               if($sizestone == 1){
                  $shape_size = $shape_size."\n ".$totalsku[($i -3)][2][$k]['shape']." ".$totalsku[($i -3)][2][$k]['size']." (".$totalsku[($i -3)][2][$k]['pieces'].")";
                }else{
                  $shape_size = $shape_size."\n ".$totalsku[($i -3)][2][$k]['name'].$totalsku[($i -3)][2][$k]['shape']." ".$totalsku[($i -3)][2][$k]['size']." (".$totalsku[($i -3)][2][$k]['pieces'].")";
               }

            }
            $clasp = $this->getclasp($totalsku[($i -3)][12]);
            $details = '';
        if($totalsku[($i -3)][1]['type'] == 'Pendant'){
        if(isset($totalsku[($i -3)][12][0])){
                    $chainwt= $totalsku[($i -3)][12][0]['chain_wt'];
                }else{
                    $chainwt = 0;
                }
                $item_wt = $totalsku[($i -3)][0]['grosswt'] + $chainwt;
                $clasp = "\nClasp Type: Spring Ring Clasp";
                
            }else{
                $item_wt =$totalsku[($i -3)][0]['grosswt'];
            }
            $details = $details."Item Specifications:\n\nMetal Type: ".$metal_nm.$finish_type
            .$gemstone."\n\nShapes & Sizes:".($shape_size)."\n\nTotal CTW: ".number_format($totalsku[($i -3)][0]['totstowei'],2,'.','')."ctw\nItem weight: ".
            number_format($item_wt,2,'.','')." grams".$clasp.$item_desc.$treatment;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, $details);
            
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('N' . $i, '0')
                ->setCellValue('O' . $i, '1')
                ->setCellValue('Q' . $i, '2')
                ->setCellValue('R' . $i, '6')
                ->setCellValue('S' . $i, '8')
                ->setCellValue('U' . $i, 'IN')
                ->setCellValue('V' . $i, 'N') 
                ->setCellValue('AB' . $i, 'target')
                ->setCellValue('AG' . $i, '0')
                ->setCellValue('AH' . $i, 'JEWELRYAUCTIONSTV')
                ->setCellValue('AK' . $i, 'N')
                ->setCellValue('AN' . $i, '11021');


            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $i, $size);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF' . $i, $metal_name);
            
            if($totalsku[($i - 3)][1]['type'] == 'Bracelet'){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $i, (number_format($totalsku[($i -3)][18]['dimwid'], 2, '.', '').'mm Wide : '.number_format($totalsku[($i -3)][18]['dimlen'], 2, '.', '').'in Long : '.number_format($totalsku[($i -3)][18]['dimhei'], 2, '.', '').'mm High'));
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $i, (number_format($totalsku[($i -3)][18]['dimwid'], 2, '.', '').'mm Wide : '.number_format($totalsku[($i -3)][18]['dimlen'], 2, '.', '').'mm Long : '.number_format($totalsku[($i -3)][18]['dimhei'], 2, '.', '').'mm High'));
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="QOV.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        //power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
    }

    public function masterarray($ids){
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            $aliases = Aliases::model()->findAll();
            $depends = DependentAlias::model()->findAll();
            $category = Category::model()->findAll();

            /* if($sku==NULL)
              {throw new CHttpException('Please check the entered values again.');} */
            $skucontent = $sku->skucontent;
            if($skucontent->type && (($skucontent->type == 'Bracelet'))){
                if($sku->dimunit == 'IN'){
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei * 25.4;
                    $dimensions['dimwid'] = $sku->dimwid * 25.4;
                    $dimensions['dimlen'] = $sku->dimlen;
                    $dimensions['dimunit'] = 'MM';
                }else{
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei ;
                    $dimensions['dimwid'] = $sku->dimwid ;
                    $dimensions['dimlen'] = $sku->dimlen / 25.4;
                    $dimensions['dimunit'] = 'MM';
                }
            }else{
                if($sku->dimunit == 'MM'){
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei ;
                    $dimensions['dimwid'] = $sku->dimwid ;
                    $dimensions['dimlen'] = $sku->dimlen ;
                    $dimensions['dimunit'] = 'MM';
                }else{
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei * 25.4;
                    $dimensions['dimwid'] = $sku->dimwid * 25.4;
                    $dimensions['dimlen'] = $sku->dimlen * 25.4;
                    $dimensions['dimunit'] = 'IN';
                }
            }
            
            $skustones = $sku->skustones;
            $stones = array();

            foreach ($skustones as $skustone) {
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' => $sku->totstowei,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => $skustone->idsetting0->name,
                    'color' => $skustone->idstone0->color,
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
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month
                );
            }
            $newstones = Newstone::unqiuestones($stones);
            $new_stone = $this->uniquestones($stones);
            
            $skuimages = $sku->skuimages(array('type' => 'Gall'));
            //$skuimages=$sku->skuimages(array('condition'=>$client));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }
            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metal_name = $skumetal->idmetal0->idmetalm0->name;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            $finds = array();
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
            'chain_wt' => $finding->idfinding0->weight,
            'chain_metal'=> $finding->idfinding0->idmetal0->namevar,
                );
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

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category, $new_stone, $dimensions);
        }
        
        return $totalsku;
    }
    
    public function uniquestones($stones) {
        $allstones = array();
        $newstones = array();
        $returnarray = array();
        foreach ($stones as $stone) {
            $stone_string = $stone['name'].'_'.$stone['shape'];
            if (in_array($stone_string, $allstones)) {
                $newstones[$stone_string]['cmeth'] = $stone['cmeth'];
                $newstones[$stone_string]['size'] = $stone['size'];
                $newstones[$stone_string]['tmeth'] = $stone['tmeth'];
                $newstones[$stone_string]['type'] = $stone['type'];
                $newstones[$stone_string]['name'] = $stone['name'];
                $newstones[$stone_string]['pieces'] = $newstones[$stone_string]['pieces'] + $stone['pieces'];
                $newstones[$stone_string]['color'] = trim($newstones[$stone_string]['color']) . ',' . trim($stone['color']);
                $newstones[$stone_string]['clarity'] = $newstones[$stone_string]['clarity'] . ',' . $stone['clarity'];
                if ($newstones[$stone_string]['shape'] == $stone['shape']) {
                    $newstones[$stone_string]['shape'] = $stone['shape'];
                } else {
                    //$newstones[$stone['name']]['shape'] = "Mix";
                }
                $newstones[$stone_string]['weight'] = $newstones[$stone_string]['weight'] + ($stone['pieces'] * $stone['weight']);
            } else {
                $allstones[] = $stone_string;
                $newstones[$stone_string]['type'] = $stone['type'];
                $newstones[$stone_string]['size'] = $stone['size'];
                $newstones[$stone_string]['cmeth'] = $stone['cmeth'];
                $newstones[$stone_string]['tmeth'] = $stone['tmeth'];
                $newstones[$stone_string]['name'] = $stone['name'];
                $newstones[$stone_string]['pieces'] = $stone['pieces'];
                $newstones[$stone_string]['color'] = $stone['color'];
                $newstones[$stone_string]['clarity'] = $stone['clarity'];
                $newstones[$stone_string]['shape'] = $stone['shape'];
                $newstones[$stone_string]['weight'] = ($stone['pieces'] * $stone['weight']);
            }
        }
        $i = 0;
        foreach ($newstones as $newstone) {
            $returnarray[$i]['type'] = $newstone['type'];
            $returnarray[$i]['cmeth'] = $newstone['cmeth'];
            $returnarray[$i]['size'] = $newstone['size'];
            $returnarray[$i]['tmeth'] = $newstone['tmeth'];
            $returnarray[$i]['name'] = $newstone['name'];
            $returnarray[$i]['pieces'] = $newstone['pieces'];
            $returnarray[$i]['color'] = implode(",", array_unique(explode(",", $newstone['color'])));
            $returnarray[$i]['clarity'] = implode(",", array_unique(explode(",", $newstone['clarity'])));
            $returnarray[$i]['shape'] = $newstone['shape'];
            $returnarray[$i]['weight'] = $newstone['weight'];
            $i++;
        }
        return $returnarray;
    }

    public function getclasp($data){
        $clasp = '';
        $claspsize = sizeof($data);
        for($j = 0; $j< $claspsize; $j++){
            if (ComSpry::findaliases($data[$j]['name'], 1)['deptAlias']) {
                $deptAliases = ComSpry::findaliases($data[$j]['name'], 1)['deptAlias'];
                foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                }
            }

            if(empty($clasp)){
                if(!empty($deptAlias['clasp_type']))
                    $clasp = "\nClasp Type: ".ucwords(str_replace('-', ' ', $deptAlias['clasp_type']));
                elseif(!empty($deptAlias['back_finding']))
                    $clasp = "\nClasp Type: ".ucwords (str_replace('-', ' ', $deptAlias['back_finding']));
            }
        }
        return $clasp;
    }


}
