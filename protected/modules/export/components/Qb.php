<?php

class Qb extends CController{

public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);

        $totalsku = array();
        $totalsku = $this->masterarray($ids);
       // echo "<pre>";print_r($totalsku);die();
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        //include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel'. DIRECTORY_SEPARATOR . 'IOFactory.php');
        $objPHPExcel = new PHPExcel();

        $filepath = Yii::app()->getBasePath() . '/components/QB_datasheettemplate.xls';
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
        for ($i = 4; $i < (($repeat) + 4); $i++){

            $costname = '';
            $metal_name = '';
            $material = '';
            foreach ($totalsku[($i - 4)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                    $material = $formula['name'];
                    break;
                }elseif(strpos($formula['name'], 'Rhodium') !== false){
                     $material = 'Rhodium Plating';
                     break;
                }
            }

            if(strrpos($totalsku[($i -4)][4],'Gold') !== false)
             $metal_name = $totalsku[($i -4)][4];
            elseif(strrpos($totalsku[($i -4)][4],'Silver') !== false)
                $metal_name = '925 Sterling Silver with '.$material;
            else
                $metal_name = $totalsku[($i -4)][4];

            $size = '';
            if($totalsku[($i - 4)][1]['type'] == 'Ring'){
            $size = ' Size '.$totalsku[($i-4)][1]['size'];
            }

            $styleThickBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_HAIR,
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':AH' . $i)->applyFromArray($styleThickBlackBorderOutline);
         
        $stonum = sizeof($totalsku[($i - 4)][2]);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $totalsku[($i - 4)][0]['skucode'])
            ->setCellValue('B' . $i, $totalsku[($i - 4)][0]['skucode'])
            ->setCellValue('G' . $i, '6')
            ->setCellValue('H' . $i, 'Ounces')
            ->setCellValue('I' . $i, '10')
            ->setCellValue('J' . $i, '2')
            ->setCellValue('K' . $i, '0.5')
            ->setCellValue('L' . $i, 'inch')
            ->setCellValue('O' . $i, 'USPS')
            ->setCellValue('W' . $i,  'Metal: '.$metal_name);

            $stone_check= array();
            foreach ($totalsku[($i -4)][2] as $stone){
                $stone_check[]=$stone['type'];
            }
            $unique=array_unique($stone_check);
            if(count($unique) == 1){
                if($unique[0] == 'diamond'){
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('X' .$i, 'Genuine Diamond');
                }else{
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, 'Genuine Gemstone');
                }
            }else{
                $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, 'Genuine Gemstone');
            }

        $sizestone = sizeof($totalsku[($i - 4)][13]);
        $diamond = 0;
        $gems = 0;
        $we = 0;
        $stone_wt = 0;
        $t_metal = (strpos($totalsku[($i - 4)][4], 'Brass') !== false) ? "Brass" : $totalsku[($i - 4)][4];
        $diamond_wt = 0;
        $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }
         $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 4)][13][0]['name']));
            $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 4)][13][0]['name'];
            
                
            
        {
            for ($k = 0; $k < $sizestone; $k++) {
                $we+= $totalsku[($i - 4)][13][$k]['weight'];
                if ($totalsku[($i - 4)][13][$k]['type'] == 'diamond') {
                    $diamond_wt+= $totalsku[($i - 4)][13][$k]['weight'];
                    $diamond++;
                } else {
                    $stone_wt+= $totalsku[($i - 4)][13][$k]['weight'];
                    $gems++;
                }
                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 4)][13][$k]['name']));
                $totalsku[($i - 4)][13][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 4)][13][$k]['name'];

            }
        }
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 4)][13][1]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 4)][13][1]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size));
                        
            } elseif ($diamond == 1 && $gems == 1 || ($diamond >= 2 && $gems == 1)) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size));
                        
            } elseif ($diamond == 0 && $gems > 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][17][0]['weight'], 2,'.','') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 4)][17][0]['weight']), 2,'.','') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($t_metal, 1).$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][17][0]['weight'], 2,'.','') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 4)][17][0]['weight']), 2,'.','') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($t_metal, 1).$size));
                        
            } elseif ($gems >= 2 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size));
                       
            } elseif ($diamond == 2 && $gems == 0) {	
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' ct. t.w. ' . str_replace('Diamond', '', $totalsku[($i - 4)][13][0]['name']) . 'and ' . $totalsku[($i - 4)][13][1]['name'] . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . $totalsku[($i - 4)][13][1]['name'] . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size));
                       
            }elseif ($diamond > 2 && $gems == 0) {	
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine Multi-Diamond ' .$totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size))
                    ->setCellValue('S' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine Multi-Diamond '. $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1).$size));
                       
            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . $i, $prepend.$costname .number_format($totalsku[($i - 4)][0]['totstowei'], 2, '.', '').
                    ' Carat Genuine ' . $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size)
                ->setCellValue('S' . $i, $prepend.$costname . number_format($totalsku[($i - 4)][0]['totstowei'], 2, '.', '').
                    ' Carat Genuine ' . $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type'].$size);

           }

            $chain_wt = 0;
            foreach ($totalsku[($i - 4)][12] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }


            if ($totalsku[($i - 4)][1]['type'] === 'Pendant' || $totalsku[($i - 4)][1]['type'] === 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, 'Gross Wt: '.number_format(($totalsku[($i - 4)][0]['grosswt'] + $chain_wt),2,'.',' ').' Grams');
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, 'Gross Wt: '.number_format($totalsku[($i - 4)][0]['grosswt'], 2, '.', ' ').' Grams');
            }
            if($gems == 0 && $diamond > 0){
                $gem_details = 'Diamond';
            }else{
                $gem_details = 'Gem';
            }
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('Y' . $i, 'Perfect for Christmas, Birthday, Anniversary, Gifts')
                ->setCellValue('AA' . $i, $gem_details.' Carat Wt: '.number_format($totalsku[($i - 4)][0]['totstowei'], 2, '.', ' ').' cts');
            $details = "";
           
            $reviews = '';
            if(isset($totalsku[($i-4)][18][0])){
                $reviews = $totalsku[($i-4)][18][0];
            }
           
            
            for($k = 0; $k<$stonum ; $k++){
                     $mark = "";
                 if($totalsku[($i-4)][2][$k]['pieces'] == 1){
                      $mark = 'Pc';
                 }else{
                     $mark = 'Pcs';
                     }
                if($k+1 == $stonum){
                    $details = $details .($totalsku[($i - 4)][2][$k]['name'] . ' ' . $totalsku[($i - 4)][2][$k]['shape'] . ' ' . $totalsku[($i - 4)][2][$k]['size']. ' - '. $totalsku[($i-4)][2][$k]['pieces'].$mark.' '.$reviews);    
                }else{
                    $details = $details .($totalsku[($i - 4)][2][$k]['name'] . ' ' . $totalsku[($i - 4)][2][$k]['shape'] . ' ' . $totalsku[($i - 4)][2][$k]['size']. ' - '. $totalsku[($i-4)][2][$k]['pieces'].$mark).' + ' ;
                }
            } 
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('AB' . $i, $gem_details.' Detail: '.trim($details));   
           
    }
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="QB.xlsx"');
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
            $aliases=Aliases::model()->findAll();
            $depends=DependentAlias::model()->findAll();
            $category=  Category::model()->findAll();
            
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
            $finds=array();
            $findings=$sku->skufindings;
            foreach($findings as $finding){
                $finds[]=array(
                    'name'=>$finding->idfinding0->name,
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

            $reviews=array();
            foreach($skureviews as $skureview){
                $reviews[] = $skureview->reviews;
            }

           
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name,$finds,$newstones,$aliases,$depends,$category, $new_stone, $reviews);
        
        }
       //    echo "<pre>";print_r($totalsku);die;
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
