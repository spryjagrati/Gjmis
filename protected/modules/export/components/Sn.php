<?php

class Sn extends CController {

    public function export($skuids, $client) {

        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $value = Yii::app()->cache->get('set-term');
        $srate = $value['srate'];
        $grate = $value['grate'];
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
            $skureviews = $sku->skureviews;
            $stones = array();

            $stonum = 0;
            foreach ($skustones as $skustone) {
                $stonum++;
                $stones[] = array('pieces' => $skustone->pieces, 'setting' => $skustone->idsetting0->name, 'setcost' => $skustone->idsetting0->setcost,'color' => $skustone->idstone0->color,
                   // 'clarity' => $skustone->idstone0->idclarity0->name, 
                    'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    'month' => $skustone->idstone0->month,'tmeth' => $skustone->idstone0->idstonem0->treatmeth, 'pps' => $skustone->idstone0->curcost, 'ppc' => (($skustone->idstone0->curcost) / ($skustone->idstone0->weight)), 'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 'scountry' => $skustone->idstone0->scountry, 'cut' => $skustone->idstone0->cut);
            }

            $skuimages = $sku->skuimages(array('type' => 'Gall'));
            //$skuimages=$sku->skuimages(array('condition'=>$client,'type'=>'Gall'));
            //$skuimages=$sku->skuimages(array('condition'=>$client));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }

            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalm0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            $findwt = Sku::model()->getDbConnection()->createCommand('select sum(fg.weight*sf.qty) wt from {{skufindings}} sf, {{finding}} fg where sf.idsku=' . $id . ' and sf.idfinding=fg.idfinding')->queryScalar();

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
                    if ($fcost['name'] == "Rhodium") {
                        $rhodium = $fcost['val'];
                    } else {
                        $cpf += $fcost['val'];
                    }
                }
            }
            $reviews = array();
            foreach($skureviews as $skureview){
                $reviews[] = $skureview->reviews;
            }
            $finds = array();
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    'weight' => $finding->idfinding0->weight,
                    'size'=>$finding->idfinding0->size,
                    'cost'=>$finding->idfinding0->cost,
                );
            }

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $findwt, $cpf, $rhodium,$reviews,$finds);
        }
        //echo "<pre>";print_r($totalsku);die;
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        
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
        $lfcr = chr(10);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Cost Breakdown Sheet')
                ->setCellValue('A3', 'Company Name:  Quintessence Jewelry Corporation ')
                ->setCellValue('A4', 'Date: ' . date('M d,Y'))
                ->setCellValue('A5', "Today's Silver Price: $".$srate."/Onz ")
                ->setCellValue('A7', 'PRODUCT INFORMATION')
                ->setCellValue('F7', 'METAL')
                ->setCellValue('L7', 'LABOR CHARGES')
                ->setCellValue('Q7', 'TOTAL')
                ->setCellValue('R7', 'STONE INFORMATION')
                ->setCellValue('AC7', 'TOTALS')
                ->setCellValue('A8', 'JTV Item'.$lfcr.'Number')
                ->setCellValue('B8', 'Order Qty')
                ->setCellValue('C8', 'Image')
                ->setCellValue('D8', 'Vendor Style #')
                ->setCellValue('E8', 'Product'.$lfcr.'Type')
                ->setCellValue('F8', 'Country'.$lfcr.'of Origin')
                ->setCellValue('G8', 'Metal'.$lfcr.'Type')
                ->setCellValue('H8', 'Metal'.$lfcr.'Color')
                ->setCellValue('I8', 'Metal'.$lfcr.'Wt (GM)')
                ->setCellValue('J8', '$/GM')
                ->setCellValue('K8', 'Metal Amount')
                ->setCellValue('L8', 'C/P')
                ->setCellValue('M8', 'Setting')
                ->setCellValue('N8', 'Rhd/Plat'.$lfcr.'/Gold'.$lfcr.'Plating')
                ->setCellValue('O8', 'Finding')
                ->setCellValue('P8', 'Labor'.$lfcr.'Total')
                ->setCellValue('Q8', 'Mount'.$lfcr.'Total')
                ->setCellValue('R8', 'Stone'.$lfcr.'Name')
                ->setCellValue('S8', 'Stone'.$lfcr.'Origin')
                ->setCellValue('T8', 'Stone'.$lfcr.'Shape')
                ->setCellValue('U8', 'Stone'.$lfcr.'Cut')
                ->setCellValue('V8', 'Stone'.$lfcr.'Size (MM)')
                ->setCellValue('W8', 'Stone'.$lfcr.'Count')
                ->setCellValue('X8', 'Stone'.$lfcr.'Weight')
                ->setCellValue('Y8', 'Stone $/Ct')
                ->setCellValue('Z8', 'Stone $/Pc')
                ->setCellValue('AA8', 'Stone'.$lfcr.'Total')
                ->setCellValue('AB8', 'TTL GEM'.$lfcr.'WT. (CT.)')
                ->setCellValue('AC8', 'Factory'.$lfcr.'Cost')
                ->setCellValue('AD8', 'Total'.$lfcr.'Unit'.$lfcr.'Price')
                ->setCellValue('AE8', 'Ext Cost')
                ->setCellValue('AF8', 'GMW'.$lfcr.'Ctw.')
                ->setCellValue('AG8', 'Total'.$lfcr.'GMW'.$lfcr.'Ctw.')
                ->setCellValue('AH8', 'Chain'.$lfcr.'Weight')
                ->setCellValue('AI8', 'Minimum '.$lfcr.'Metal'.$lfcr.'Gram'.$lfcr.'Weight');

       $styleDefaultArray = array(
            'font' => array(
                'bold' => false,
                'size'=>8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleDefaultArray);


        $styleArray2 = array(
            'font' => array(
                'bold' => true,
                'size'=>8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleThickBorderRight = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $styleThickBlackBorderBottom = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $styleThinBlackBorderBottom = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font' => array(
                'bold' => true,
                'size'  => 8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $styleArrayHeader = array(
            'font' => array(
                'bold' => true,
                'size' => 20,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleContentCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $styleHeaderColor = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
            ),
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A1:AE1');
        $objPHPExcel->getActiveSheet()->mergeCells('A7:E7');
        $objPHPExcel->getActiveSheet()->mergeCells('F7:K7');
        $objPHPExcel->getActiveSheet()->mergeCells('L7:P7');
        $objPHPExcel->getActiveSheet()->mergeCells('R7:AA7');
        $objPHPExcel->getActiveSheet()->mergeCells('AC7:AE7');

        $objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->applyFromArray($styleArrayHeader);
        $objPHPExcel->getActiveSheet()->getStyle('A7:F7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('Q7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('F7:K7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('L7:P7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('R7:AA7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('AC7:AE7')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AF8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('AB8:AE8')->applyFromArray($styleHeaderColor);


        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(30);

        for($k=3 ;$k<=5 ;$k++){
             $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':D'.$k)->applyFromArray($styleThinBlackBorderBottom);
        }
       
        $objPHPExcel->getActiveSheet()->freezePane('F10');
       

        for ($k = 'A'; $k !== 'AJ'; $k++){
            $objPHPExcel->getActiveSheet()->mergeCells($k.'8:'.$k."9");
        }
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:AI8')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E0FFFF')
                    ),
                    'font' => array(
                        'bold' => true,
                        'size'  => 8,
                    ),
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
                )

            );
       
        for ($i = 9; $i < ($repeat) * 10; $i = ($i + 10)) {

            for($j=$i+1 ; $j <= ($repeat*10 )+9; $j++){
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$j ,'0.00');
            }

            $chain_wt = 0;
            // if($totalsku[($i - 9) / 10][1]['type'] == 'Pendant' || $totalsku[($i - 9) / 10][1]['type'] == 'Set' || $totalsku[($i - 9) / 10][1]['type'] == 'Necklace'){
            //     foreach ($totalsku[($i - 9) / 10][14] as $finds) {
            //         if (strpos($finds['name'], 'Chain') !== false){
            //             $chain_wt = $finds['weight'];
            //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.($i + 1),$chain_wt);
            //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i + 2),$finds['size'].' Chain');
            //             $objPHPExcel->getActiveSheet()->getStyle('O'.($i + 2))->applyFromArray($styleHeaderColor);
            //             $objPHPExcel->getActiveSheet()->getStyle('O'.($i + 2))->applyFromArray($styleArray2);
            //         }
            //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($i + 1),$finds['cost']);

            //     }
            // }

            //echo "<pre>";print_r($totalsku[($i - 9) / 10][8]);die();

           
            //$totalsku[($i - 9) / 10][14]['find']
            $k = $i+1;
            if($totalsku[($i - 9) / 10][1]['type'] == 'Pendant' || $totalsku[($i - 9) / 10][1]['type'] == 'Set' || $totalsku[($i - 9) / 10][1]['type'] == 'Necklace'){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$k, $totalsku[($i - 9) / 10][8]['find']);
                    $k++;
            }else{
                if($totalsku[($i - 9) / 10][1]['size'] != 'N/A' || $totalsku[($i - 9) / 10][1]['size'] != ' ' || $totalsku[($i - 9) / 10][1]['size'] != 'NULL'){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$k,$totalsku[($i - 9) / 10][1]['size']);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('O'.$k, $totalsku[($i - 9) / 10][8]['find']);
                }
                $k++;
            }


            foreach ($totalsku[($i - 9) / 10][14] as $finds) {
                if(strpos($finds['name'], 'Chain') !== false){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$k,$finds['size'].' Chain');
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$k,$finds['name']);
                }
            }
            
            if($totalsku[($i - 9) / 10][1]['type'] == 'Pendant'){
                if(isset($totalsku[($i - 9) / 10][14][0])){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.($i + 1),$totalsku[($i - 9) / 10][14][0]['weight'] );
                }
            }
           
            $metalname = ''; $metaltype=$totalsku[($i - 9) / 10][6];
            if(isset($totalsku[($i - 9) / 10][6])){
                if(stripos($totalsku[($i - 9) / 10][6] , 'Silver') != false){
                    $metaltype = '925';
                    $metalname = 'Silver';
                }elseif(stripos($totalsku[($i - 9) / 10][6] , 'Gold') != false){
                    $metalname = 'Gold';
                }elseif($totalsku[($i - 9) / 10][6] == 'Brass'){
                    $metalname = 'Brass';
                }
            }

            if(stripos($totalsku[($i - 9) / 10][6] , 'Gold' ) != false){
                if(stripos($totalsku[($i - 9) / 10][4], 'White') != false){
                    $metal_color = 'W';
                }elseif(stripos($totalsku[($i - 9) / 10][4], 'Rose') != false){
                    $metal_color = 'R';
                }else{
                    $metal_color = 'Y';
                }
            }else{
                $metal_color = 'W';
            }


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . ($i + 1), $totalsku[($i - 9) / 10][0]['skucode'])
                    ->setCellValue('E' . ($i + 1), $totalsku[($i - 9) / 10][1]['type'])
                    ->setCellValue('F' . ($i + 1), 'India')
                    ->setCellValue('G' . ($i + 1), $metaltype)
                    ->setCellValue('H' . ($i + 1), $metal_color)
                    ->setCellValue('I' . ($i + 1), number_format($totalsku[($i - 9) / 10][0]['totmetalwei']+$chain_wt,2))
                    ->setCellValue('J' . ($i + 1), $totalsku[($i - 9) / 10][7])
                    ->setCellValue('K' . ($i + 1), '=(I' . ($i + 1) . '*J' . ($i + 1) . ')')
                    ->setCellValue('L' . ($i + 1), '='.Sn::getCpf($metalname , $totalsku[(($i - 9) / 10)][1]['type'] , $i+1)) 
                    ->setCellValue('N' . ($i + 1), '=I'.($i + 1).'*0.25')
                    //->setCellValue('O' . ($i + 1), $totalsku[($i - 9) / 10][8]['find'])
                    ->setCellValue('P' . ($i + 1), '=SUM(L' . ($i + 1) . ':O' . ($i + 1) . ')')
                    ->setCellValue('Q' . ($i + 1), '=(K' . ($i + 1) . '+P' . ($i + 1) . ')');
           
            $k = 0;
            $j = $i + 1; 
            $setting_arr =array();
            foreach ($totalsku[($i - 9) / 10][2] as $totsku) {
                $set_name = $totsku['setcost'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . ($i + 1 + $k), $totsku['name'])
                        ->setCellValue('S' . ($i + 1 + $k), strtoupper($totsku['scountry']))
                        ->setCellValue('T' . ($i + 1 + $k), $totsku['shape'])
                        ->setCellValue('U' . ($i + 1 + $k), $totsku['cut'])
                        ->setCellValue('V' . ($i + 1 + $k), $totsku['size'])
                        ->setCellValue('W' . ($i + 1 + $k), $totsku['pieces'])
                        ->setCellValue('X' . ($i + 1 + $k), '='.$totsku['weight'].'*W'.($i + 1 + $k))
                        ->setCellValue('Y' . ($i + 1 + $k), $totsku['ppc'])
                        ->setCellValue('AA' . ($i + 1 + $k), '=(X' . ($i + 1 + $k) . '*Y' . ($i + 1 + $k) . ')')
                        ->setCellValue('AF' . ($i + 1 + $k), '=X'.($i + 1 + $k).'-(X'.($i + 1 + $k).'*5/100)');

                $setting_arr[$set_name][] = array($totsku['pieces'] , $totsku['name'],$totsku['setcost'] );
        
                $k++; 
            }
           
            $new =array();
            foreach($setting_arr as $key => $value){
                $add = 0;
                foreach($value as $key2 => $value2){
                    $add = $add + $value2[0];
                }
                $new[] = $add * $key;
            }
            $setting = array_sum($new);
            

            $i = $j - 1;
            $reviews='';
            foreach($totalsku[(($i - 9) / 10)][13] as $key => $value){
                $reviews = $value;
                break;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('AC' . ($i + 1), '=(Q'.($i + 1).'+AA'.($i + 1).'+AA'.($i + 2).'+AA'.($i + 3).'+AA'.($i + 4).'+AA'.($i + 5).'+AA'.($i + 6).'+AA'.($i + 7).'+AA'.($i + 8).'+AA'.($i + 9).'+AA'.($i + 10).')')
                    ->setCellValue('AB' . ($i + 1), '=SUM(X' . ($i + 1) . ':X' . ($i + 10) . ')')
                    ->setCellValue('AD' . ($i + 1), '=AC' . ($i + 1) . '*1.15')
                    ->setCellValue('AE' . ($i + 1), '=(AD' . ($i + 1) . '*B' . ($i + 1) . ')')
                    ->setCellValue('AG' . ($i + 1), '=SUM(AF'.($i + 1).':AF'.($i + 10).')')
                    ->setCellValue('M' . ($i + 1), $setting)
                    ->setCellValue('AI' . ($i + 1), '=I'.($i + 1).'-(I'.($i + 1).'*2/100)')
                    ->setCellValue('AJ' . ($i + 1), '=AC'.($i + 1).'+(AC'.($i + 1).'*10/100)');
              
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($i + 1) . ':C' . ($i + 10));
        }
        
       
        $objPHPExcel->getActiveSheet()->getStyle('J10:Q'.$i)->getNumberFormat()->setFormatCode('"$"#,##0.#0');
        $objPHPExcel->getActiveSheet()->getStyle('AF10:AG'.$i)->getNumberFormat()->setFormatCode('#,##0.#0');
        $objPHPExcel->getActiveSheet()->getStyle('AB10:AB'.$i)->getNumberFormat()->setFormatCode('#,##0.##0');
        $objPHPExcel->getActiveSheet()->getStyle('Y10:AA'.$i)->getNumberFormat()->setFormatCode('"$"#,##0.#0');
        $objPHPExcel->getActiveSheet()->getStyle('AC10:AE'.$i)->getNumberFormat()->setFormatCode('"$"#,##0.#0');
        $objPHPExcel->getActiveSheet()->getStyle('AI10:AI'.$i)->getNumberFormat()->setFormatCode('#,##0.#0');
        $objPHPExcel->getActiveSheet()->getStyle('AJ10:AJ'.$i)->getNumberFormat()->setFormatCode('"$"#,##0.#"0"');
        $objPHPExcel->getActiveSheet()->getStyle('X10:X'.$i)->getNumberFormat()->setFormatCode('#,##0.#0');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('AD10:AD'.$i)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFCE75')
                    ),
                )
        );

        
        $objPHPExcel->getActiveSheet()->getStyle('A6:AG6')->applyFromArray($styleThickBlackBorderBottom);
        $objPHPExcel->getActiveSheet()->getStyle('A7:AI7')->applyFromArray($styleThickBlackBorderBottom);
        $objPHPExcel->getActiveSheet()->getStyle('A8:AF8')->applyFromArray($styleThickBlackBorderBottom);
        $objPHPExcel->getActiveSheet()->getStyle('A8:AI' . ($i))->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('E7:E' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AF7:AF' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AG7:AG' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('K7:K' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('P7:P' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('Q7:Q' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AA7:AA' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AB7:AB' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AC7:AC' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AD7:AD' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AE7:AE' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AE8:AE' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AG8:AG' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AH8:AH' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getStyle('AI8:AI' . ($i))->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(14);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A8:AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       


        for ($l = 0; $l < $repeat; $l++) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . (19 + ($l * 10)) . ':AI' . (19 + ($l * 10)))->applyFromArray($styleThickBlackBorderBottom);

        }
        

        for ($i = 10; $i <= ($repeat) * 10; $i = ($i + 10)) {
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $imagename = $totalsku[($i - 10) / 10][3][0];
            //live
            //$basepath = Yii::app()->basePath . '/..' .$imagename ;
            $basepath = dirname(dirname(Yii::app()->basePath)).$imagename;
            if(file_exists($basepath)){ 
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('image');
                $objDrawing->setDescription('image');
                $objDrawing->setPath($basepath);
                $objDrawing->setCoordinates('C' . ($i + 0));
                $objDrawing->setOffsetX(5); 
                $objDrawing->setOffsetY(10);
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
        header('Content-Disposition: attachment;filename="SN_Spec.xlsx"');
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas();
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
    }
    private function getCpf($metal, $type, $count){
        if($metal == 'Silver'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((I'.$count .'*0.44)>2.5,(I'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((I'.$count .'*0.44)>4.5,(I'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((I'.$count .'*0.44)>2,(I'. $count . '*0.44),2)+0.42';
            }
        }else if($metal == 'Gold'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((I'.$count .'*2)>4,(I'. $count . '*2),4)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((I'.$count .'*2)>6,(I'. $count . '*2),6)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((I'.$count .'*2)>3,(I'. $count . '*2),3)+0.42';
            }
        }else if($metal == 'Brass'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((I'.$count .'*0.44)>2.5,(I'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((I'.$count .'*0.44)>4.5,(I'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((I'.$count .'*0.44)>2,(I'. $count . '*0.44),2)+0.42';
            }
        }
    }

}
