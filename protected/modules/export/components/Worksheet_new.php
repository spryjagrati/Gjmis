<?php

class Worksheet_new extends CController {

    public function export($skuids, $client) {

        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $value = Yii::app()->cache->get('set-term');
        $srate = $value['srate'];$grate = $value['grate'];
        $baseprice = '$'.$grate.'/$'.$srate;

        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

        $totalsku = array();
        $totalsku = $this->masterarray($ids);
       //echo "<pre>";print_r($totalsku);die();
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();
       
        
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");


     $objPHPExcel->getActiveSheet()->mergeCells('K1:M1');
        

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Lot')
                ->setCellValue('C1', 'Design')
                ->setCellValue('D1', 'Image')
                ->setCellValue('E1', 'Size')
                ->setCellValue('F1', 'Metal')
                ->setCellValue('G1', 'Gross')
                ->setCellValue('H1', 'Aprx')
                ->setCellValue('I1', '$/gm')
                ->setCellValue('J1', 'Silver')
                ->setCellValue('K1', 'Labor')
                ->setCellValue('N1', 'Bagging')
                ->setCellValue('O1', 'Others')
                ->setCellValue('Q1', 'Stone')
                ->setCellValue('R1', 'Stn')
                ->setCellValue('S1', 'Avg')
                ->setCellValue('T1', 'Stn')
                ->setCellValue('U1', 'Stn')
                ->setCellValue('V1', 'Stn')
                ->setCellValue('W1', 'Dia')
                ->setCellValue('X1', 'Avg')
                ->setCellValue('Y1', 'Dia')
                ->setCellValue('Z1', 'Dia')
                ->setCellValue('AA1', 'Total')
                ->setCellValue('AC1', 'Profit')
                ->setCellValue('AD1', 'Price')
                ->setCellValue('AE1', 'GMW')
                ->setCellValue('AF1', 'GMW')
                ->setCellValue('AG1', 'GMW')
                ->setCellValue('A2', '#')
                ->setCellValue('B2', 'Category')
                ->setCellValue('F2', 'Type')
                ->setCellValue('G2', 'Wt.')
                ->setCellValue('H2', 'Mtl. Wt.')
                ->setCellValue('J2', 'Amt.')
                ->setCellValue('K2', 'CPF')
                ->setCellValue('L2', 'Rhodium/GP')
                ->setCellValue('M2', 'Setting')
                ->setCellValue('N2', 'Cost')
                ->setCellValue('O2', 'Cost')
                ->setCellValue('P2', 'Total')
                ->setCellValue('Q2', 'Description')
                ->setCellValue('R2', 'Pcs')
                ->setCellValue('S2', 'Wt.')
                ->setCellValue('T2', '$/Ct.')
                ->setCellValue('U2', '$/Pc')
                ->setCellValue('V2', 'Amt.')
                ->setCellValue('W2', 'Pcs')
                ->setCellValue('X2', 'Wt.')
                ->setCellValue('Y2', '$/Ct.')
                ->setCellValue('Z2', 'Amt.')
                ->setCellValue('AA2', 'Cost')
                ->setCellValue('AB2', 'Finding')
                ->setCellValue('AC2', 'Margin')
                ->setCellValue('AD2', '$')
                ->setCellValue('AE2', 'Ct.')
                ->setCellValue('AF2', 'Ct.')
                ->setCellValue('AG2', 'Ct.')
                ->setCellValue('I2', $baseprice);

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
                 $c_array='D'.($i+$loop);
                 $c[]=$c_array; 
                 $lop[]=$i+$loop;         
            }
            if(!empty($count)) {

                $X=implode('+',$x); 
                $T=implode('+',$t); 
                $Q=implode('+',$q); 
                $V=implode('+',$v);
      
                /*row merge for image display*/
                if($count < 8 ){ 
                    if($count == 1){ $en=end($lop) + 7;}
                    if($count == 2){ $en=end($lop) + 6;}
                    if($count == 3){ $en=end($lop) + 5;}
                    if($count == 4){ $en=end($lop) + 4;}
                    if($count == 5){ $en=end($lop) + 3;}
                    if($count == 6){ $en=end($lop) + 2;}
                    if($count == 7){ $en=end($lop) + 1;}
                    if($count == 8){ $en=end($lop) + 0;} 
                    $objPHPExcel->getActiveSheet()->mergeCells(reset($c).':D'.$en); 
                }
                else{
                    $objPHPExcel->getActiveSheet()->mergeCells(reset($c).':'.(end($c)));
                }
            }

            $fixcosts = $totalsku[8]['fixcost']; $fix_cost=0; $rho_cost=0;
            $rho_array = array('Black Pan Rhodium (B)','Yellow Pan Rhodium (A)','Yellow Pan Rhodium (B)','Yellow Pan Rhodium (C)','Black Pan Rhodium (A)','Black Pan Rhodium (C)','White Pan Rhodium (A)','White Pan Rhodium (B)','White Pan Rhodium (C)','Rose Gold Pan Rhodium (A)','Rose Gold Pan Rhodium (B)','Rose Gold Pan Rhodium (C)','Blue Dip (A)','Blue Dip (B)','Blue Dip (C)','Oxside Pan Rhodium','Brown Pan Rhodium','Green Pan Rhodium');
            


            foreach($fixcosts as $fixcost){
                if($fixcost['name'] == 'Laser ( Logo ) Cost'){
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$i, $fixcost['val']);
                }elseif($fixcost['name'] == 'CPX_LWG'){
                    $fix_cost = round($fixcost['val'],2);
                }
                if (in_array($fixcost['name'], $rho_array)){
                     $rho_cost = $fixcost['val'];
                }
            }
            
            $formulacosts = $totalsku[8]['formula'];
            foreach($formulacosts as $formulacost){
                if($formulacost['name'] == 'J BACK'){
                    $fix_cost = round($formulacost['val'],2);
                }elseif($formulacost['name'] == 'J BACK_Gold'){
                    $fix_cost = round($formulacost['val'],2);
                }
            }

          
            // if(isset($totalsku[8]['stoset'])){
            //     $setting = $totalsku[8]['stoset'];
            // }else{
            //     $setting = 0;
            // }

            /*End row merge for image display*/
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $j);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $i, $totalsku[1]['type'])
                                               ->setCellValue('C' . $i, $totalsku[0]['skucode'])
                                               ->setCellValue('E' . $i, $totalsku[1]['size'])
                                               ->setCellValue('F' . $i, $totalsku[4])
                                               ->setCellValue('G' . $i, $totalsku[0]['grosswt']);     
              
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $i, '= G' . ($i + 0) .'-(' .'S'.($i + 0). '+'.'S'.($i + 1). '+'.'S'.($i + 2). '+'.'S'.($i + 3). '+'.'S'.($i + 4). '+'.'S'.($i + 5). '+'.'S'.($i + 6). '+'.'S'.($i + 7).'+'.'X'.($i + 0).'+'.'X'.($i + 1).'+'.'X'.($i + 2).'+'.'X'.($i + 3).'+'.'X'.($i + 4).'+'.'X'.($i + 5).'+'.'X'.($i + 6).'+'.'X'.($i + 7). ')/5' );
            $objPHPExcel->setActiveSheetIndex()->getStyle('G' . $i)->getNumberFormat()->setFormatCode('##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('H' . $i)->getNumberFormat()->setFormatCode('##0.#0');
        
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $i, $totalsku[7])  
                                                 ->setCellValue('J' . $i, '=(H' . ($i) . '*I' . ($i) . ')'); 
           
            if($fix_cost > 0){
               $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, '='.Worksheet_new::getCpf($totalsku[10], $totalsku[1]['type'], $i).'+'.$fix_cost); 
            }else{
               
                $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, '='.Worksheet_new::getCpf($totalsku[10], $totalsku[1]['type'], $i));
            }
            
            
            if($rho_cost > 0){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, '= H' . ($i + 0) . '*0.25+'.$rho_cost );
            }else{
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, '= H' . ($i + 0) . '*0.25');
            }

            


            
             // $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, '= (' .'R'.($i + 0). '+'.'R'.($i + 1). '+'.'R'.($i + 2). '+'.'R'.($i + 3). '+'.'R'.($i + 4). '+'.'R'.($i + 5). '+'.'R'.($i + 6). '+'.'R'.($i + 7).'+'.'W'.($i + 0).'+'.'W'.($i + 1).'+'.'W'.($i + 2).'+'.'W'.($i + 3).'+'.'W'.($i + 4).'+'.'W'.($i + 5).'+'.'W'.($i + 6).'+'.'W'.($i + 7). ')*0.08' );
            

            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i, '= (' .'R'.($i + 0). '+'.'R'.($i + 1). '+'.'R'.($i + 2). '+'.'R'.($i + 3). '+'.'R'.($i + 4). '+'.'R'.($i + 5). '+'.'R'.($i + 6). '+'.'R'.($i + 7).'+'.'W'.($i + 0).'+'.'W'.($i + 1).'+'.'W'.($i + 2).'+'.'W'.($i + 3).'+'.'W'.($i + 4).'+'.'W'.($i + 5).'+'.'W'.($i + 6).'+'.'W'.($i + 7). ')*.01' );
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $i, '=SUM(K' . ($i) . ':O' . ($i) . ')');
    
            

            $objPHPExcel->setActiveSheetIndex()->getStyle('H' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('I' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('J' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('K' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('L' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('M' . $i)->getNumberFormat()->setFormatCode('#,##0.#0'); 
        /* Row Merge */ 
            $objPHPExcel->getActiveSheet()->mergeCells('D' . ($i + 0) . ':D' . ($i + 7));   
            

            /*For images*/           
            
            // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            // //$base= dirname(dirname(Yii::app()->basePath));  
            // if(($totalsku[3][0])){
            //     $objDrawing = new PHPExcel_Worksheet_Drawing();
            //     $objDrawing->setName('image');
            //     $objDrawing->setDescription('image');                         
            //     $objDrawing->setPath(Yii::app()->basePath . '/..' .$totalsku[3][0]);                           
            //     $objDrawing->setCoordinates('D'.($i+0));                         
            //     $objDrawing->setOffsetX(10);
            //     $objDrawing->setOffsetY(10);
            //     $objDrawing->setWidthAndHeight(125,125);
            //     $objDrawing->setResizeProportional(true);
            //     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            // }


            /*If stone and diamond not available*/
            if(empty($totalsku[2])){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$i, '');
            }

            $setting_arr =array();
            for ($k = 0; $k < $count; $k++) { 
                $set_name = $totalsku[2][$k]['setcost'];
                if ($totalsku[2][$k]['type'] != "diamond") {           
                    $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('Q' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size'])
                        ->setCellValue('R' . ($i + $k), $totalsku[2][$k]['pieces'])
                        ->setCellValue('S' . ($i + $k), '= R' . ($i + $k) . '*' . $totalsku[2][$k]['weight']); 
                    $objPHPExcel->setActiveSheetIndex()->getStyle('S' . ($i + $k))->getNumberFormat()->setFormatCode('#,##0.#0');
                    if(isset($totalsku[2][$k]['weight'])){
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.($i+$k), ($totalsku[2][$k]['ppc']/$totalsku[2][$k]['weight']));}
                    else{
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.($i+$k), '');  
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . ($i + $k), ($totalsku[2][$k]['ppc'] / $totalsku[2][$k]['weight']));
                    $objPHPExcel->setActiveSheetIndex()->getStyle('T' . ($i + $k))->getNumberFormat()->setFormatCode('#,##0.#0');
                        
                } 
                else {
                    $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('Q' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size']);
                    $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('W' . ($i + $k), $totalsku[2][$k]['pieces'])
                        ->setCellValue('X' . ($i + $k), '= W' . ($i + $k) . ' * ' . $totalsku[2][$k]['weight'])
                        ->setCellValue('Y' . ($i + $k), $totalsku[2][$k]['ppc'] / $totalsku[2][$k]['weight']);

                    $objPHPExcel->setActiveSheetIndex()->getStyle('X' . ($i + $k))->getNumberFormat()->setFormatCode('##0.#00');
                } 
                $setting_arr[$set_name][] = array($totalsku[2][$k]['pieces'] , $totalsku[2][$k]['name'],$totalsku[2][$k]['setcost'] );
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

            if($count <= 7){
                $reviews = ''; 
                foreach($totalsku[11] as $key){
                    $reviews .= $key;
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . ($i + 7), $reviews);
               $objPHPExcel->getActiveSheet()->getStyle('Q' . ($i + 7))->getAlignment()->setWrapText(true); 
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$i, $setting);

  
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, '= (' .'V'.($i + 0). '+'.'V'.($i + 1). '+'.'V'.($i + 2). '+'.'V'.($i + 3). '+'.'V'.($i + 4). '+'.'V'.($i + 5). '+'.'V'.($i + 6). '+'.'V'.($i + 7).'+'.'Z'.($i + 0).'+'.'Z'.($i + 1).'+'.'Z'.($i + 2).'+'.'Z'.($i + 3).'+'.'Z'.($i + 4).'+'.'Z'.($i + 5).'+'.'Z'.($i + 6).'+'.'Z'.($i + 7). '+'.'J'.($i + 0).'+'.'P'.($i + 0).')' );
            
      
         
            if (isset($totalsku[8]['find'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AB' . $i, $totalsku[8]['find']);
            } 
           

            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, '=(AA'.($i).'+AB'.($i).')*0.1')
                        ->setCellValue('AD' . $i, '=ROUND(SUM(AA' . ($i) . ':AC' . ($i) . '),1)')
                        ->setCellValue('AG' . $i, '=(AF' . ($i + 0) . '+AF' . ($i + 1) . '+AF' . ($i + 2) . '+AF' . ($i + 3) . '+AF' . ($i + 4) . '+AF' . ($i + 5) . '+AF' . ($i + 6) . '+AF' . ($i + 7) . '+AE' . ($i + 0) . '+AE' . ($i + 1) . '+AE' . ($i + 2) . '+AE' . ($i + 3) . '+AE' . ($i + 4) . '+AE' . ($i + 5) . '+AE' . ($i + 6) . '+AE' . ($i + 7) . ')');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode('##0.#0');

            $objPHPExcel->setActiveSheetIndex()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
               
            $objPHPExcel->setActiveSheetIndex()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AD' . $i)->getNumberFormat()->setFormatCode('"$"#0.0"0"');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AG' . $i)->getNumberFormat()->setFormatCode('#,##0.#0'); 
            
            for($index = 0; $index < 8 ; $index++){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . ($i + $index), '=(S'. ($i + $index).'-(S' . ($i + $index) . '*5/100))');
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AF' . ($i + $index), '=(X'. ($i + $index).'-(X' . ($i + $index) . '*2/100))');
                $objPHPExcel->setActiveSheetIndex()->setCellValue('V' . ($i + $index), '=IF(T' . ($i + $index) . '>0,S' . ($i + $index) . '*T' . ($i + $index) . ',R' . ($i + $index) . '*U' . ($i + $index) . ')');
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . ($i + $index), '=Y' . ($i + $index) . '*X' . ($i + $index) . '');  
                $objPHPExcel->setActiveSheetIndex()->getStyle('V' . ($i + $index))->getNumberFormat()->setFormatCode('##0.#0');
                $objPHPExcel->setActiveSheetIndex()->getStyle('Z' . ($i + $index))->getNumberFormat()->setFormatCode('##0.#0');
                $objPHPExcel->setActiveSheetIndex()->getStyle('AE' . ($i + $index))->getNumberFormat()->setFormatCode('##0.#0');
                $objPHPExcel->setActiveSheetIndex()->getStyle('AF' . ($i + $index))->getNumberFormat()->setFormatCode('##0.#0');
            }
            
            
        
            
          
            if($count < 8){     
                $i = $i  + 8;
            }
            else{
                $i = $i + $count;
            }  
            $total_ids[]=$i-1;
            $j++; 
        }  

        $styleThickBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font'  => array(
                'bold'  => true,
                'size'  => 9,
                'name'  => 'Calibri'
            ),
        );
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AG2')->applyFromArray($styleThickBorderOutline);
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
            $objPHPExcel->getActiveSheet()->getStyle('A' . $l . ':AG' . $l)->applyFromArray($styleThinBlackBorderOutline);
     
        } 
        foreach($total_ids as $co){           
            $objPHPExcel->getActiveSheet()->getStyle('A' . $co. ':AG' . $co)->applyFromArray($styleThickBlackBorderOutline);
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
        $objWriter->setPreCalculateFormulas(); //only for local
        $objWriter->save('php://output');

        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
        Yii::app()->end();
    }
    
    private function masterarray($ids) {
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));

            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
        $skureviews = $sku->skureviews;
            $stones = array();
            
            foreach ($skustones as $skustone) {
                $stones[] = array('pieces' => $skustone->pieces,
                    'setting' => $skustone->idsetting0->name,
                    'setcost' => $skustone->idsetting0->setcost,
                    'month' => $skustone->idstone0->month,
                    'color' => $skustone->idstone0->color,
                    'shape' => trim($skustone->idstone0->idshape0->name),
                    'size' => $skustone->idstone0->idstonesize0->size,
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,
                    'ppc' => $skustone->idstone0->curcost,
                    'pps' => (($skustone->idstone0->curcost) * ($skustone->idstone0->weight)),
                    'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 
                    'type' => $skustone->idstone0->idstonem0->type);
            }
            $skuimages = $sku->skuimages(array('type' => 'MISG'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }

            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            $metalm = '';
            if (strpos($metal, 'Silver') != false) {
                $metalm = 'Silver';
            }else if(strpos($metal, 'Gold') != false){
                $metalm = 'Gold';
            }else if(strpos($metal, 'Brass') != false){
                $metalm = 'Brass';
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
    
        $reviews=[];
            foreach ($skureviews as $skureview) {
                $reviews[] = $skureview->reviews;
            }

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $metalm ,$reviews);
        }
        
        return $totalsku;
    }
    
    private function getCpf($metal, $type, $count){
        if($metal == 'Silver'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((H'.$count .'*0.44)>2.5,(H'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((H'.$count .'*0.44)>4.5,(H'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((H'.$count .'*0.44)>2,(H'. $count . '*0.44),2)+0.42';
            }
        }else if($metal == 'Gold'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((H'.$count .'*2)>4,(H'. $count . '*2),4)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((H'.$count .'*2)>6,(H'. $count . '*2),6)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((H'.$count .'*2)>3,(H'. $count . '*2),3)+0.42';
            }
        }else if($metal == 'Brass'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((H'.$count .'*0.44)>2.5,(H'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((H'.$count .'*0.44)>4.5,(H'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((H'.$count .'*0.44)>2,(H'. $count . '*0.44),2)+0.42';
            }
        }
    }

}