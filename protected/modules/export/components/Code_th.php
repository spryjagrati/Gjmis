<?php

class Code_th extends CController{
    
    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        
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

        $filepath = Yii::app()->getBasePath() . '/components/Code_TH.xls';
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
        for ($i = 2; $i < (($repeat) + 2); $i++) {
            $styleThickBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    ),
                ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':AG' . $i)->applyFromArray($styleThickBlackBorderOutline);

            $costname = '';
            foreach ($totalsku[($i - 2)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                }
            }

            $chain_wt = 0;
            foreach ($totalsku[($i - 2)][12] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }
            

            $metal_name = '';
            if(strrpos($totalsku[($i -2)][4],'Gold') !== false)
             $metal_name = $totalsku[($i -2)][4].', '.$totalsku[($i -2)][13][0]['name'];
            elseif(strrpos($totalsku[($i -2)][4],'Silver') !== false)
                $metal_name = '925 Sterling Silver, '.$totalsku[($i -2)][13][0]['name'];
            else
                $metal_name = $totalsku[($i -2)][4].', '.$totalsku[($i -2)][13][0]['name'];

            $size = '';
            if($totalsku[($i - 2)][1]['type'] == 'Ring'){
            $size = ' Size '.preg_replace('/#/', '', $totalsku[($i - 2)][1]['size']);
            }
          
            $description = ''; 
            $sizestone = sizeof($totalsku[($i -2)][13]);
            $diamond = 0;
            $gems = 0;
            $we = 0;
            $stone_wt = 0;
            $diamond_wt = 0;
            $t_metal = (strpos(ComSpry::findmetal($totalsku[($i -2)][4]), 'Brass') !== false) ? "Brass" : ComSpry::findmetal($totalsku[($i -2)][4]);
            $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }
            $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][13][0]['name']));
            $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 2)][13][0]['name'];
            $stone_alias_name2 = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][2][0]['name']));
            $stone_alias_name2 = isset($stone_alias_name2) ? $stone_alias_name2->alias : $totalsku[($i - 2)][2][0]['name'];
            
            $reviews = $totalsku[($i-2)][18];
            
            $diamond_name = '';
            for ($k = 0; $k < $sizestone; $k++) {
                $we+= $totalsku[($i -2)][13][$k]['weight'];
                if ($totalsku[($i -2)][13][$k]['type'] == 'diamond') {
                    $diamond_wt+= $totalsku[($i -2)][13][$k]['weight'];
                    $diamond_name2 = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i -2)][13][$k]['name']));
                    $diamond_name = isset($diamond_name2) ? $diamond_name2->alias : $totalsku[($i -2)][13][$k]['name'];
                    $diamond++;
                } else {
                    $stone_wt+= $totalsku[($i -2)][13][$k]['weight'];
                    $gems++;
                }

                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][13][$k]['name']));
                $totalsku[($i - 2)][13][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 2)][13][$k]['name'];
            }
           
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                    ' Carat Genuine ' . $totalsku[($i -2)][13][0]['name'] .' ' .$t_metal.' '. $totalsku[($i -2)][1]['type'].$size));
               
                $description = "Retail Price:\n ".($totalsku[($i - 2)][13][0]['name'] . ' ' . $totalsku[($i - 2)][13][0]['shape'] . ' ' . $totalsku[($i - 2)][13][0]['size']. ' -'. $totalsku[($i-2)][13][0]['pieces'].'Pcs').
                " + ".$totalsku[($i - 2)][13][1]['name'].' '.$totalsku[($i - 2)][13][1]['shape'].' '.$totalsku[($i - 2)][13][1]['size'].' -'.$totalsku[($i-2)][13][1]['pieces'].'Pcs'.(trim($reviews) ? $reviews : '').
                 "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+$chain_wt),2, '.', '')." Grams".
                 "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+$chain_wt),2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    
             
            } elseif ($diamond == 1 && $gems == 1) {
               
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $prepend.$costname . (number_format($diamond_wt + $stone_wt, 2, '.', '') .
                    ' Carat Genuine ' . ComSpry::findalias($totalsku[($i -2)][13][0]['name'], 1) .' & ' .$totalsku[($i -2)][13][1]['name'].' '. $t_metal . ' ' . $totalsku[($i -2)][1]['type'].$size));
            
                $description = "Retail Price:\n ".($totalsku[($i - 2)][13][0]['name'] . ' ' . $totalsku[($i - 2)][13][0]['shape'] . ' ' . $totalsku[($i - 2)][13][0]['size']. ' -'. $totalsku[($i-2)][13][0]['pieces'].'Pcs').
                " + ".$totalsku[($i - 2)][13][1]['name'].' '.$totalsku[($i - 2)][13][1]['shape'].' '.$totalsku[($i - 2)][13][1]['size'].' -'.$totalsku[($i-2)][13][1]['pieces'].'Pcs'.(trim($reviews) ? $reviews : '').
                 "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+$chain_wt),2, '.', '')." Grams".
                 "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+$chain_wt),2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    
             
            } elseif ($diamond == 0 && $gems > 2) {
                
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                    ' Carat ' . ComSpry::findalias($totalsku[($i -2)][13][0]['name'], 1) . ' ' . $t_metal.$size . ' ' . $totalsku[($i -2)][1]['type']));
            
                $description = "Retail Price:\n ".($totalsku[($i - 2)][13][0]['name'] . ' ' . $totalsku[($i - 2)][13][0]['shape'] . ' ' . $totalsku[($i - 2)][13][0]['size']. ' -'. $totalsku[($i-2)][13][0]['pieces'].'Pcs').
                " + ".$totalsku[($i - 2)][13][1]['name'].' '.$totalsku[($i - 2)][13][1]['shape'].' '.$totalsku[($i - 2)][13][1]['size'].' -'.$totalsku[($i-2)][13][1]['pieces'].'Pcs'.(trim($reviews) ? $reviews : '').
                 "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+$chain_wt),2, '.', '')." Grams".
                 "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+$chain_wt),2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    
             
            } elseif ($gems > 1 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $prepend.$costname . (number_format($stone_wt + $diamond_wt , 2, '.', '') .
                    ' Carat Genuine '.$totalsku[($i - 2)][13][0]['name'] . ' & ' . $diamond_name . ' ' . $t_metal . ' ' . $totalsku[($i -2)][1]['type'].$size));
            
                $description = "Retail Price:\n ".($totalsku[($i - 2)][13][0]['name'] . ' ' . $totalsku[($i - 2)][13][0]['shape'] . ' ' . $totalsku[($i - 2)][13][0]['size']. ' -'. $totalsku[($i-2)][13][0]['pieces'].'Pcs').
                " + ".$totalsku[($i - 2)][13][1]['name'].' '.$totalsku[($i - 2)][13][1]['shape'].' '.$totalsku[($i - 2)][13][1]['size'].' -'.$totalsku[($i-2)][13][1]['pieces'].'Pcs'.(trim($reviews) ? $reviews : '').
                 "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+$chain_wt),2, '.', '')." Grams".
                 "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+$chain_wt),2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    
             
            } elseif ($diamond == 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                    ' Carat Genuine ' . $totalsku[($i -2)][13][0]['name'] . ' & ' . $totalsku[($i -2)][13][1]['name'] . ' '.$t_metal .' '. $totalsku[($i -2)][1]['type'].$size));
            
                $description = "Retail Price:\n ".($totalsku[($i - 2)][13][0]['name'] . ' ' . $totalsku[($i - 2)][13][0]['shape'] . ' ' . $totalsku[($i - 2)][13][0]['size']. ' -'. $totalsku[($i-2)][13][0]['pieces'].'Pcs').
                " + ".$totalsku[($i - 2)][13][1]['name'].' '.$totalsku[($i - 2)][13][1]['shape'].' '.$totalsku[($i - 2)][13][1]['size'].' -'.$totalsku[($i-2)][13][1]['pieces'].'Pcs'.(trim($reviews) ? $reviews : '').
                 "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+$chain_wt),2, '.', '')." Grams".
                 "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+$chain_wt),2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    

            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                   ->setCellValue('A' . $i, $prepend.$costname . (number_format($totalsku[($i -2)][0]['totstowei'], 2, '.', '') .
                    ' Carat Genuine ' . $totalsku[($i - 2)][13][0]['name'] . ' ' . $t_metal . ' ' . $totalsku[($i -2)][1]['type'].$size));
            
                $description = "Retail Price:\n ".($stone_alias_name2 . ' ' . $totalsku[($i - 2)][2][0]['shape'] . ' ' . $totalsku[($i - 2)][2][0]['size']. ' -'. $totalsku[($i-2)][2][0]['pieces'].'Pcs').(trim($reviews) ? $reviews : '').
                "\nSize/Length: ".$totalsku[($i -2)][1]['size']."\nMetal: ".$totalsku[($i -2)][4]."\nGross weight: ".number_format(($totalsku[($i -2)][0]['grosswt']+ $chain_wt) ,2, '.', '')." Grams".
                "\nTotal Gem weight: ".number_format($totalsku[($i -2)][0]['totstowei'],2, '.', '')." Carat\nMetal weight: ".number_format(($totalsku[($i -2)][0]['totmetalwei']+ $chain_wt) ,2, '.', '')." Grams\nGem Treatment: ".$totalsku[($i -2)][2][0]['tmeth'];    

            }

             $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, 'Jewelry');
             if($totalsku[($i -2)][1]['type'] == 'Earrings'){
                  $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $totalsku[($i -2)][1]['type']);
             }else{
                 $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $totalsku[($i -2)][1]['type'].'s');
             }
             
             
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $totalsku[($i -2)][0]['skucode'])
                    ->setCellValue('G' . $i, $totalsku[($i -2)][0]['skucode'])
                    ->setCellValue('I' . $i, 'New')
                    ->setCellValue('Q' . $i, '0')
                    ->setCellValue('R' . $i, '10')
                    ->setCellValue('U' . $i, 'Y')
                    ->setCellValue('V' . $i, '4')
                    ->setCellValue('W' . $i, 'Y')
                    ->setCellValue('X' . $i, 'Y')
                    ->setCellValue('Y' . $i, 'N')
                    ->setCellValue('AA' . $i, 'United States');

            $stonum = sizeof($totalsku[($i -2)][2]);
            $color = '';
            for($k = 0; $k <$stonum; $k++){
               if($totalsku[($i-2)][2][$k]['type'] == 'diamond'){
                 $color = 'Gold';
                 break;
               }else{
                  $color = 'Silver';
                  break;
               }
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, $color);
            if($totalsku[($i-2)][1]['type'] == 'Ring'){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, preg_replace('/#/', '', $totalsku[($i - 2)][1]['size']));
            }      

            $chain_wt = 0;
            foreach ($totalsku[($i - 2)][12] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $i, ($totalsku[($i - 2)][0]['grosswt'] + $chain_wt));

         $objPHPExcel->setActiveSheetIndex()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('#,##0.#0');
         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $i, $description);
        }
        
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Code_TH.xlsx"');
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
            $skustones = $sku->skustones;
            $skureviews = $sku->skureviews;
            $stones = array();

            foreach ($skustones as $skustone) {
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' => $sku->totstowei,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
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
                    'weight' => $finding->idfinding0->weight,
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

            $rev=0;$reviews='';
            foreach($skureviews as $skureview){
                if($rev <1){
                    $reviews .= ' '.$skureview->reviews;
                }else{
                    $reviews .= $skureview->reviews;
                }
            }

        $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category, $new_stone ,$reviews);
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
}