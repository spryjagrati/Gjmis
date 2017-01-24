<?php

class Ht extends CController {

    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        // print_r($repeat);die;
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

        $filepath = Yii::app()->getBasePath() . '/components/HT.xls';
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
        for ($i = 7; $i < (($repeat) + 7); $i++) {

            $costname = '';
            foreach ($totalsku[($i - 7)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                }
            }

            $chainname = '';
            if ($totalsku[($i - 7)][1]['type'] === 'Pendant' || $totalsku[($i - 7)][1]['type'] === 'Set') {
                  $chainname = ' With 18" Chain';
            }

            $metal_name = '';
            if(strrpos($totalsku[($i -7)][4],'Gold') !== false)
             $metal_name = $totalsku[($i -7)][4].', '.$totalsku[($i - 7)][13][0]['name'];
            elseif(strrpos($totalsku[($i -7)][4],'Silver') !== false)
                $metal_name = '925 Sterling Silver, '.$totalsku[($i - 7)][13][0]['name'];
            else
                $metal_name = $totalsku[($i -7)][4].', '.$totalsku[($i - 7)][13][0]['name'];



            $styleThickBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    ),
                ),
            );

            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':AM' . $i)->applyFromArray($styleThickBlackBorderOutline);
            $stonum = sizeof($totalsku[($i - 7)][2]);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $totalsku[($i - 7)][0]['skucode'])
                    ->setCellValue('B' . $i, $totalsku[($i - 7)][0]['refpo']);

            $sizestone = sizeof($totalsku[($i - 7)][13]);
            $diamond = 0;
            $gems = 0;
            $we = 0;
            $stone_wt = 0;
            $t_metal = (strpos($totalsku[($i - 7)][4], 'Brass') !== false) ? "Brass" : $totalsku[($i - 7)][4];
            $diamond_wt = 0;
            $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }
            $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 7)][13][0]['name']));
            $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 7)][13][0]['name'];
            
            
            
            for ($k = 0; $k < $sizestone; $k++) {
                $we+= $totalsku[($i - 7)][13][$k]['weight'];
                if ($totalsku[($i - 7)][13][$k]['type'] == 'diamond') {
                    $diamond_wt+= $totalsku[($i - 7)][13][$k]['weight'];
                    $diamond++;
                } else {
                    $stone_wt+= $totalsku[($i - 7)][13][$k]['weight'];
                    $gems++;
                }
                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 7)][13][$k]['name']));
                $totalsku[($i - 7)][13][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 7)][13][$k]['name'];
            }
                
            
           
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] .' ' .ComSpry::findmetal($t_metal).' '. $totalsku[($i - 7)][1]['type'].$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] .' ' .ComSpry::findmetal($t_metal).' '. $totalsku[($i - 7)][1]['type'].$chainname));
                    
            } elseif ($diamond == 1 && $gems == 1 || ($diamond >= 2 && $gems == 1)) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][0]['totstowei'], 2,'.','') .
                        ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 7)][13][0]['name'], 1) .' & ' .$totalsku[($i - 7)][13][1]['name'].' '. ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type'].$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][0]['totstowei'], 2,'.','') .
                        ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 7)][13][0]['name'], 1) .' & ' .$totalsku[($i - 7)][13][1]['name'].' '. ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type'].$chainname));
            } elseif ($diamond == 0 && $gems > 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][17][0]['weight'], 2,'.','') .
                        ' Carat ' . ComSpry::findalias($totalsku[($i - 7)][13][0]['name'], 1) . ' ' . $totalsku[($i - 7)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 7)][17][0]['weight']), 2,'.','') . ' ct. t.w. Multi-Gems in ' . ComSpry::findmetal($t_metal).$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][17][0]['weight'], 2,'.','') .
                        ' Carat ' . ComSpry::findalias($totalsku[($i - 7)][13][0]['name'], 1) . ' ' . $totalsku[($i - 7)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 7)][17][0]['weight']), 2,'.','') . ' ct. t.w. Multi-Gems in ' . ComSpry::findmetal($t_metal).$chainname));
            } elseif ($gems >= 2 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type'].$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($stone_wt, 2,'.','') .
                        ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2,'.','') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type'].$chainname));
            } elseif ($diamond == 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] . ' & ' . $totalsku[($i - 7)][13][1]['name'] . ' '.ComSpry::findmetal($t_metal) .' '. $totalsku[($i - 7)][1]['type'].$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] . ' & ' . $totalsku[($i - 7)][13][1]['name'] . ' '.ComSpry::findmetal($t_metal) .' '. $totalsku[($i - 7)][1]['type'].$chainname));
            }elseif ($diamond > 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine Multi-Diamond '.ComSpry::findmetal($t_metal) .' '. $totalsku[($i - 7)][1]['type'].$chainname))
                    ->setCellValue('N' . $i, $prepend.$costname . (number_format($diamond_wt, 2,'.','') .
                        ' Carat Genuine Multi-Diamond '.ComSpry::findmetal($t_metal) .' '. $totalsku[($i - 7)][1]['type'].$chainname));
            }else{ 
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][0]['totstowei'], 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] . ' ' . ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type']. $chainname))
                   ->setCellValue('N' . $i, $prepend.$costname . (number_format($totalsku[($i - 7)][0]['totstowei'], 2,'.','') .
                        ' Carat Genuine ' . $totalsku[($i - 7)][13][0]['name'] . ' ' . ComSpry::findmetal($t_metal) . ' ' . $totalsku[($i - 7)][1]['type']. $chainname));  

            }

            //$stonealias = Stonealias::model()->findbyattributes(array('export' => 2, 'idproperty' => 1, 'idstonem' => $totalsku[($i - 7)][2][0]['idstonem']));
            $stonealias='';
            
            if(isset($stonealias) && $stonealias){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('J' . $i, $stonealias->alias)
                    ->setCellValue('I' . $i, $stonealias->alias);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('J' . $i, $totalsku[($i - 7)][2][0]['color'])
                    ->setCellValue('I' . $i, $totalsku[($i - 7)][2][0]['color']);
            }
            


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . $i, $totalsku[($i - 7)][1]['type'])
                    ->setCellValue('E' . $i, 'SP ACC/COS');

            
            $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('F' . $i, $totalsku[($i - 7)][16]->dept)    
                        ->setCellValue('G' . $i, $totalsku[($i - 7)][16]->class)
                        ->setCellValue('H' . $i, $totalsku[($i - 7)][16]->subclass);

            $details = "";$reviews='';
            foreach($totalsku[($i - 7)][18] as $key => $value){
                $reviews = $value;
                break;
            }

            for ($k = 0; $k < $stonum; $k++) {
                $mark = "";
                if ($totalsku[($i - 7)][2][$k]['pieces'] == 1) {
                    $mark = 'Pc';
                } else {
                    $mark = 'Pcs';
                }
                if ($k + 1 == $stonum) {
                    $details = $details . ($totalsku[($i - 7)][2][$k]['name'] . ' ' . $totalsku[($i - 7)][2][$k]['shape'] . ' ' . $totalsku[($i - 7)][2][$k]['size'] . ' - ' . $totalsku[($i - 7)][2][$k]['pieces'] . $mark . ' ' . $reviews);
                } else {
                    $details = $details . ($totalsku[($i - 7)][2][$k]['name'] . ' ' . $totalsku[($i - 7)][2][$k]['shape'] . ' ' . $totalsku[($i - 7)][2][$k]['size'] . ' - ' . $totalsku[($i - 7)][2][$k]['pieces'] . $mark) . ' + ';
                }
            }
          
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $i, trim($details));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $i, $this->getclasp($totalsku[($i -7)][12],$totalsku[($i -7)][1]));
           
            $dimwid = '';
            $dimlen = '';
            if($totalsku[($i -7)][0]['dimunit'] == 'MM'){
                $dimwid = number_format(($totalsku[($i - 7)][0]['dimwid']*0.039370),2,'.','');
                $dimlen = number_format(($totalsku[($i - 7)][0]['dimlen']*0.039370),2,'.','');
            }else{
                $dimwid = ($totalsku[($i - 7)][0]['dimwid']);
                $dimlen = ($totalsku[($i - 7)][0]['dimlen']);
            }
            
            
            if ($totalsku[($i - 7)][1]['type'] === "Earrings" || $totalsku[($i - 7)][1]['type'] === "Necklace") {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, ($dimwid . ' Inches W x ' . $dimlen . ' Inches L'));
            }elseif($totalsku[($i - 7)][1]['type'] === "Bracelet"){
             $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, ($dimlen . ' Inches L'));

            }else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $i, ($dimwid . ' Inches W x ' . $dimlen . ' Inches L'));
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('Q' . $i, 'India');
            if (ComSpry::findaliases($totalsku[($i - 7)][4], 1)['deptAlias']) {
                $deptAliases = ComSpry::findaliases($totalsku[($i - 7)][4], 1)['deptAlias'];
                foreach ($deptAliases as $value) {
                    $deptAlias[$value->column] = $value->alias;
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $deptAlias['bullet_point3']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $i, $deptAlias['bullet_point3']);
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $totalsku[($i - 7)][6]);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $i, $totalsku[($i - 7)][11]);
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('U' . $i, 'N');

            $we = array();

            for ($k = 0; $k < $stonum; $k++) {
                if ($totalsku[($i - 7)][2][$k]['type'] == "diamond") {
                    $we[] = $totalsku[($i - 7)][2][$k]['weight'] * $totalsku[($i - 7)][2][$k]['pieces'];
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, array_sum($we));
                }
            }
        $objPHPExcel->setActiveSheetIndex()->getStyle('L' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');  
        }
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="HT.xlsx"');
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

            /* if($sku==NULL)
              {throw new CHttpException('Please check the entered values again.');} */
            $skucontent = $sku->skucontent;
            
            $cat = (isset($sku->sub_category) && $sku->sub_category) ? $sku->sub_category : $skucontent->type;
            $category = Category::model()->findbyattributes(array('category' => $cat));
            $category = $category ? $category : new category();
            $skustones = $sku->skustones;
            $skureviews = $sku->skureviews;
            $stones = array();

            foreach ($skustones as $skustone) {
                //$stonealias = Stonealias::model()->findbyattributes(array('idproperty' => 1, 'export' => 2, 'idstonem' => $skustone->idstone0->idstonem));
                $stonealias='';
                if(isset($stonealias) && $stonealias){
                    $color = $stonealias->alias;
                }else{
                    $color = $skustone->idstone0->color;
                }
                
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' => $sku->totstowei,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => $skustone->idsetting0->name,
                    'color' => $color,
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
                    'month' => $skustone->idstone0->month,
                    'idstonem' => $skustone->idstone0->idstonem
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
            $reviews = array();
            foreach($skureviews as $skureview){
                $reviews[] = $skureview->reviews;
            }

        $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category, $new_stone,$reviews);
        
        
                }
        
        return $totalsku;
    }
    
    public function getclasp($data,$content) {
        $clasp = '';
        $claspsize = sizeof($data);
        for ($j = 0; $j < $claspsize; $j++) {
            if (ComSpry::findaliases($data[$j]['name'], 1)['deptAlias']) {
                $deptAliases = ComSpry::findaliases($data[$j]['name'], 1)['deptAlias'];
                foreach ($deptAliases as $value) {
                    $deptAlias[$value->column] = $value->alias;
                }
            }
            if (empty($clasp)) {
                if (!empty($deptAlias['clasp_type']))
                    $clasp = $deptAlias['clasp_type'];
                elseif (!empty($deptAlias['back_finding']))
                    $clasp = $deptAlias['back_finding'];
            }
        }
        if(empty($clasp) && $content['type'] == 'Pendant'){
            $clasp = $content['clasptype'];
        }
        return $clasp;
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
