<?php

class Worksheet extends CController {

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
            
            foreach ($skustones as $skustone) {
                $stones[] = array('pieces' => $skustone->pieces,
                    'setting' => $skustone->idsetting0->name,
                    'month' => $skustone->idstone0->month,
                    'color' => $skustone->idstone0->color,
                    //isset($skustone->idstone0->idclarity0->name)?'clarity'=>$skustone->idstone0->idclarity0->name,:'';
                    'shape' => trim($skustone->idstone0->idshape0->name),
                    'size' => $skustone->idstone0->idstonesize0->size,
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,
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
            $reviews = array();
            foreach($skureviews as $skureview){
                $reviews[] = $skureview->reviews;
            }

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf ,$reviews);
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
                ->setCellValue('H2', $srate.'/'.$grate)
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


        $styleDefaultArray = array(
            'font' => array(
                'bold' => false,
                'size'=>8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $styleHeaderArray = array(
            'font' => array(
                'bold' => true,
                'size'=>8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleColor = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
            ),
        );

        $objPHPExcel->getDefaultStyle()->applyFromArray($styleDefaultArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC2')->applyFromArray($styleHeaderArray);
        $objPHPExcel->getActiveSheet()->freezePane('A3');
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(3, 1);
        $objPHPExcel->getActiveSheet()->mergeCells('J1:K1');
        $objPHPExcel->getActiveSheet()->mergeCells('L1:M1');
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($styleColor);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleColor);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);

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
            $objPHPExcel->getActiveSheet()->mergeCells('C' . ($i + 0) . ':C' . ($i + 14));       

           
            /*For images*/           
            
            // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            // //$base= dirname(dirname(Yii::app()->basePath));             
            // if(($totalsku[3][0])){
            //     $objDrawing = new PHPExcel_Worksheet_Drawing();
            //     $objDrawing->setName('image');
            //     $objDrawing->setDescription('image');                         
            //     $objDrawing->setPath(Yii::app()->basePath . '/..' .$totalsku[3][0]);                           
            //     $objDrawing->setCoordinates('C'.($i+0));                         
            //     $objDrawing->setOffsetX(10);
            //     $objDrawing->setOffsetY(10);
            //     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            // }



            /*If stone and diamond not available*/
            if(empty($totalsku[2])){
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$i, $totalsku[1]['review']);
            }

             $reviews='';
            for ($k = 0; $k < $count; $k++) { 

                if ($totalsku[2][$k]['type'] != "diamond") {           
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size'])
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
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . ($i + $k), $totalsku[2][$k]['name'] . ' ' . $totalsku[2][$k]['shape'] . ' ' . $totalsku[2][$k]['size']);
                                                        
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . ($i + $k), $totalsku[2][$k]['pieces'])
                        ->setCellValue('V' . ($i + $k), '= U' . ($i + $k) . ' * ' . $totalsku[2][$k]['weight'])
                        ->setCellValue('W' . ($i + $k), $totalsku[2][$k]['ppc'] / $totalsku[2][$k]['weight'])
                        ->setCellValue('X' . ($i + $k), '=V' . ($i + $k) . '*W' . ($i + $k) . '');

                    $objPHPExcel->setActiveSheetIndex()->getStyle('X' . ($i + $k))->getNumberFormat()->setFormatCode('##0.##0');
                    $objPHPExcel->setActiveSheetIndex()->getStyle('V' . ($i + $k))->getNumberFormat()->setFormatCode('##0.####0');
                }

                if(isset($totalsku[11][$k])){
                    $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('O' . ($i + $k), $totalsku[11][$k]);
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
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, '0.00');
            }
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, '=(Y' . ($i) . '+Z' . ($i) . ')*0.1')
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
        $objPHPExcel->getActiveSheet()->getStyle('D3:E'.$i)->applyFromArray($styleColor);
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AA'.$i)->applyFromArray($styleColor);
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
        $objWriter->setPreCalculateFormulas();
        $objWriter->save('php://output');

        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
        Yii::app()->end();
    }

}