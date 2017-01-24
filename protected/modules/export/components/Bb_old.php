<?php

class Bb extends CController{

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
                $stones[] = array('pieces' => $skustone->pieces, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    //'clarity' => $skustone->idstone0->idclarity0->name,'cmeth' => $skustone->idstone0->creatmeth,
                    'clarity' => '',
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,
                    'pps' => $skustone->idstone0->curcost, 
                    'ppc' => round((($skustone->idstone0->curcost) / ($skustone->idstone0->weight)),2),
                    'name' => $skustone->idstone0->namevar,
                    'shape' => trim($skustone->idstone0->idshape0->name), 
                    'size' => $skustone->idstone0->idstonesize0->size, 
                    'weight' => $skustone->idstone0->weight, 
                    'country' => $skustone->idstone0->idstonem0->scountry, 'cost' => $skustone->idstone0->curcost, 'month' => $skustone->idstone0->month);
            }

            $skuimages = $sku->skuimages(array('type' => 'MISG'));
                // $skuimages=$sku->skuimages(array('condition'=>$client,'type'=>'Gall'));
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
            $lossfactor = $skumetal->lossfactor;

            if (!is_null($id) && $id !== '' && $id !== 0) {
                $cost = ComSpry::calcSkuCostArray($id);
                $totcost = ComSpry::calcSkuCost($id);
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


            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $lossfactor, $cost, $totcost, $reviews,$finds);
        }
       
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

      //echo "<pre>";print_r($totalsku); die();
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
                ->setCellValue('A1', 'Supplier Name:')
                ->setCellValue('C1', 'GALLANT JEWELRY,'. $lfcr .'F-25, SPECIAL ECONOMIC ZONE-II (SEZ-II),'.$lfcr .$lfcr.'SITAPURA, TONK ROAD, JAIPUR - 302022')
                ->setCellValue('A2', 'Silver Loss : ')
                ->setCellValue('C2', '10%')
                ->setCellValue('A3', 'Silver Fix :')
                ->setCellValue('C3', '$'.$srate.' fix')
                ->setCellValue('F2', 'Gold Loss : ')
                ->setCellValue('H2', '9%')
                ->setCellValue('C4', '')
                ->setCellValue('F3', 'Gold Fix : ')
                ->setCellValue('H3', '$'.$grate.' fix')
                ->setCellValue('C5', '')
                ->setCellValue('P3', 'Date: ' . date('M d,Y'));

        
        //$objPHPExcel->getActiveSheet()->getStyle('A4:C4')->getFont()->setBold(true);
       // $objPHPExcel->getActiveSheet()->getStyle('A5:A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(9, 1);

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


        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );



        $styleThickBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $styleAlignmentCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleAlignmentHeaderTop = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleTextColor= array(
            'font' => array(
                'color' => array('rgb'=>'FF0000'),
            ), 
        );

        $BStyle = array(
                'borders' => array(
                    'outline' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN,
                      'color' => array('rgb' => '000000')
                    ),
                    'bottom' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THICK,
                      'color' => array('rgb' => '000000')
                    )
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array('rgb' => 'FFFFFF')
                ),
            );

        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($styleAlignmentCenter);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(80);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
        $objPHPExcel->getActiveSheet()->mergeCells('C1:T1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('F2:G2');
        $objPHPExcel->getActiveSheet()->mergeCells('H2:I2');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:G3');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getFont()->setBold(true)->setSize(8);
        $objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getFont()->getColor()->setRGB('FF0000');
        $objPHPExcel->getActiveSheet()->getStyle('F2:F3')->getFont()->getColor()->setRGB('FF0000');
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setRGB('0000FF');
        $objPHPExcel->getActiveSheet()->freezePane('A4');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);


    
        //echo $repeat ; die();

        for ($i = 8; $i <= ($repeat) * 16; $i = ($i + 16)) {
           
            for($k='C';$k <= 'Q' ;$k++){
                $objPHPExcel->getActiveSheet()->getStyle($k.($i + 1))->applyFromArray($styleAlignmentHeaderTop);
            }

            $objPHPExcel->getActiveSheet()->getStyle('T'.($i + 1))->applyFromArray($styleAlignmentCenter);

             $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.($i + 0), 'Image')
                ->setCellValue('G'.($i + 0), 'Stone')
                ->setCellValue('R'.($i + 0), 'Labour')
                ->setCellValue('T'.($i + 0), 'Description');

                $metalname='';

            if(stripos($totalsku[($i - 8) / 16][6] , 'Gold')!== false){

                $metalt = explode(' ',$totalsku[($i - 8) / 16][4]);
                $metaltype = $metalt[0]; 

                if($metalt[1] == 'Yellow'){
                    $color = 'YG';
                }elseif($metalt[1] == 'White'){
                    $color = 'WG';
                }elseif($metalt[1] == 'Rose'){
                    $color = 'RG';
                }else{
                    $color ='';
                }

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . ($i + 0), 'Gold')
                    ->setCellValue('C' . ($i + 3),$metaltype.' '.$color)
                    ->setCellValue('F' . ($i + 3), '$9%')
                    ->setCellValue('T' . ($i + 1), $metaltype.' '.$color. $lfcr .$totalsku[(($i - 8) / 16)][1]['type']);

                $objPHPExcel->getActiveSheet()->getStyle('C'.($i + 0))->applyFromArray($styleTextColor);
                $objPHPExcel->getActiveSheet()->getStyle('C'.($i + 3))->applyFromArray($styleTextColor);
                $objPHPExcel->getActiveSheet()->getStyle('F'.($i + 3))->applyFromArray($styleTextColor);
                $objPHPExcel->getActiveSheet()->getStyle('T'.($i + 1))->applyFromArray($styleTextColor);
                $metalname = 'Gold';

            }elseif(stripos($totalsku[($i - 8) / 16][6] , 'Silver')!== false){
                 $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C'.($i + 0), 'Silver')
                    ->setCellValue('C' . ($i + 3),'925')
                    ->setCellValue('F' . ($i + 3), '$10%')
                    ->setCellValue('T' . ($i + 1), '925 '.$totalsku[(($i - 8) / 16)][1]['type']);
                $metalname = 'Silver';
            }
            
            if(stripos($totalsku[($i - 8) / 16][6] , 'Brass')!== false){
                $metalname = 'Brass';
            }

          // echo $metalname ;die();
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('C' . ($i + 1), 'Type')
                    ->setCellValue('D' . ($i + 1), 'Net'. $lfcr .'Weight'. $lfcr .'(metal)')
                    ->setCellValue('E' . ($i + 1), 'Gross'. $lfcr .'Weight'. $lfcr .'(piece)')
                    ->setCellValue('F' . ($i + 1), 'Loss'. $lfcr .'Rate')
                    ->setCellValue('G' . ($i + 1), 'Stone Type')
                    ->setCellValue('H' . ($i + 1), 'QTY.')
                    ->setCellValue('I' . ($i + 1), 'Qual.')
                    ->setCellValue('J' . ($i + 1), 'Shape/Cut')
                    ->setCellValue('K' . ($i + 1), 'Size(MM)')
                    ->setCellValue('L' . ($i + 1), 'Gem'. $lfcr .'Treatment')
                    ->setCellValue('M' . ($i + 1), 'Country of'. $lfcr .'Origin')
                    ->setCellValue('N' . ($i + 1), 'Gem'. $lfcr .'Weight'. $lfcr .'(CT)')
                    ->setCellValue('O' . ($i + 1), 'Guarenteed'. $lfcr .'Gem'. $lfcr .'Weight')
                    ->setCellValue('P' . ($i + 1), 'PPC $')
                    ->setCellValue('Q' . ($i + 1), 'Total')
                    ->setCellValue('R' . ($i + 2), 'Finish')
                   ->setCellValue('S' . ($i + 2), '='.Bb::getCpf($metalname , $totalsku[(($i - 8) / 16)][1]['type'] , $i+3))
                    ->setCellValue('D' . ($i + 3), ($totalsku[(($i - 8) / 16)][0]['totmetalwei']))
                    ->setCellValue('E' . ($i + 3), '=(D'.($i + 3).'+N'.($i + 14).'/5)')
                    ->setCellValue('R' . ($i + 3), 'Settings')
                    //->setCellValue('S' . ($i + 3), $totalsku[(($i - 8) / 16)][9]['stoset'])
                    ->setCellValue('S' . ($i + 3), '=H'.($i + 15).'*0.1')
                    
                    ->setCellValue('T' . ($i + 3), 'Unit Price');

            $z = 4;
            if( $totalsku[(($i - 8) / 16)][9]['find'] > 0){
                 $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('R' . ($i + $z), 'Findings')
                ->setCellValue('S' . ($i + $z), $totalsku[(($i - 8) / 16)][9]['find']);
                $z++;
            }

            if($totalsku[(($i - 8) / 16)][1]['size'] !== NULL && $totalsku[(($i - 8) / 16)][1]['size'] !== 'N/A' && $totalsku[(($i - 8) / 16)][1]['size'] !== ' '){
                $size= $totalsku[(($i - 8) / 16)][1]['size'];
                $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('R' . ($i + $z), 'Size')
                    ->setCellValue('S' . ($i + $z), $size);
                $z++;
            }

            $formulas = $totalsku[(($i - 8) / 16)][9]['formula']; 
            foreach($formulas as $formula){
                if($formula['name'] == 'Rhodium'){
                    $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('R' . ($i + $z), 'Rhodium')
                        ->setCellValue('S' . ($i + $z), '=D'.($i + 3).'*0.25');
                        $z++;
                } 
            }

            $fixcosts = $totalsku[(($i - 8) / 16)][9]['fixcost']; $pan ='';
            foreach($fixcosts as $fixcost){
                if(stripos($fixcost['name'], 'Pan')){
                    $pan = $fixcost['val'];
                      $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('R' . ($i + $z), 'PAN')
                            ->setCellValue('S' . ($i + $z), $pan);
                            $z++;
                }
            }

           if(stripos($totalsku[(($i - 8) / 16)][0]['skucode'] , 'GP')){
             $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('R' . ($i + $z), 'GP')
                        ->setCellValue('S' . ($i + $z), '=D'.($i + 3).'*0.45');
           } 


            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('T' . ($i + 15), '=(D' . ($i + 15) . '+Q' . ($i + 15) . '+S' . ($i + 15) . ')')
                    ->setCellValue('U' . ($i + 14), 'GRK')
                    ->setCellValue('U' . ($i + 15), '=(T'.($i + 15).'+(T'.($i + 15).'*10/100))')
                    ->setCellValue('V' . ($i + 14), 'BB')
                    ->setCellValue('V' . ($i + 15), '=(U'.($i + 15).'*1.25)');

             $reviews='';
            foreach($totalsku[(($i - 8) / 16)][11] as $key => $value){
                $reviews = $value;
                break;
            }


            $p = 3;
            foreach($totalsku[(($i - 8) / 16)][2] as $stone => $value){
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('G' . ($i + $p), $value['name'])
                        ->setCellValue('H' . ($i + $p), $value['pieces'])
                        ->setCellValue('I' . ($i + $p), 'AA')
                        ->setCellValue('J' . ($i + $p), $value['shape'])
                        ->setCellValue('K' . ($i + $p), $value['size'])
                        ->setCellValue('L' . ($i + $p), $value['tmeth'])
                        ->setCellValue('M' . ($i + $p), $value['country'])
                         ->setCellValue('N' . ($i + $p), '=(' . $value['weight'] . '*H'.($i + $p). ')')
                        ->setCellValue('O' . ($i + $p), '=N'.($i + $p).'-(N'.($i + $p).'*10/100)')
                        ->setCellValue('P' . ($i + $p), $value['ppc'])
                        ->setCellValue('Q' . ($i + $p), '=Product((N' . ($i + $p) . '),(P' . ($i + $p) . '))')
                        ->setCellValue('L' . ($i + $p), $value['tmeth']);
                    $p++;
            }

            $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('G' . ($i + $p), $reviews);

            
            $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('N' . ($i + 14), '=SUM(N'.($i + 3).':N'.($i + 13).')')
                        ->setCellValue('O' . ($i + 14), '=SUM(O'.($i + 3).':O'.($i + 13).')');

            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . ($i + 14), 'BJB Code No: ')
                    ->setCellValue('B' . ($i + 14), '');


            $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . ($i + 14), '(USD)')
                    ->setCellValue('A' . ($i + 15), 'Supplier No: ')
                    ->setCellValue('B' . ($i + 15), $totalsku[(($i - 8) / 16)][0]['skucode'])
                    ->setCellValue('C' . ($i + 15), 'Price: ')
                    ->setCellValue('D' . ($i + 15), '='.$totalsku[(($i - 8) / 16)][7].'*D'.($i + 3))
                    ->setCellValue('G' . ($i + 15), 'Sub-Total:')
                    ->setCellValue('H' . ($i + 15), '=SUM(H' . ($i + 3) . ':H' . ($i + 14) . ')')
                    ->setCellValue('Q' . ($i + 15), '=SUM(Q' . ($i + 3) . ':Q' . ($i + 14) . ')')
                    ->setCellValue('R' . ($i + 15), 'Sub-Total:')
                    ->setCellValue('S' . ($i + 15), '=SUM(S' . ($i + 2) . ':S' . ($i + 14) . ')');


            $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 0).':T'.($i + 0))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->mergeCells('C'.($i + 0).':F'.($i + 0));
            $objPHPExcel->getActiveSheet()->mergeCells('G'.($i + 0).':Q'.($i + 0));
            $objPHPExcel->getActiveSheet()->mergeCells('R'.($i + 0).':S'.($i + 0));
            $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 0).':T'.($i + 0))->applyFromArray($styleAlignmentCenter);


            $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + $p))->applyFromArray($styleTextColor);
            $objPHPExcel->getActiveSheet()->getStyle('G'.($i + 15).':Q'.($i + 15))->applyFromArray($BStyle);
            $objPHPExcel->getActiveSheet()->getStyle('C'.($i + 15).':F'.($i + 15))->applyFromArray($BStyle);
            $objPHPExcel->getActiveSheet()->getStyle('R'.($i + 15).':S'.($i + 15))->applyFromArray($BStyle);
            $objPHPExcel->getActiveSheet()->getStyle('T'.($i + 3).':T'.($i + 15))->applyFromArray($BStyle);
            $objPHPExcel->getActiveSheet()->mergeCells('D' . ($i + 15) . ':F' . ($i + 15) . '');
            $objPHPExcel->getActiveSheet()->mergeCells('R' . ($i + 1) . ':S' . ($i + 1) . '');
            $objPHPExcel->getActiveSheet()->mergeCells('T' . ($i + 1) . ':T' . ($i + 2) . '');
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':S' . ($i + 1))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 2) . ':S' . ($i + 2))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':S' . ($i + 3))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 4) . ':S' . ($i + 4))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 5) . ':S' . ($i + 5))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 6))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 7))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 8))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 9))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 10))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 11))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 12))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 13))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':S' . ($i + 14))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 6) . ':B' . ($i + 15))->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('F' . ($i + 1) . ':F' . ($i + 3));
            $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 3) . ':G' . ($i + 14));
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 2))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . ($i + 6))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . ($i + 6))->getFont()->setBold(true);
           // $objPHPExcel->getActiveSheet()->getStyle('S' . ($i + 6))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . ($i + 15))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($i + 15))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('Q' . ($i + 15))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('S' . ($i + 15))->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('T' . ($i + 15))->getFont()->setBold(true);



            $objPHPExcel->getActiveSheet()->getStyle('T' . ($i + 1) . ':T' . ($i + 4));
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 1) . ':B' . ($i + 15))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('G' . ($i + 1) . ':Q' . ($i + 15))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($i + 1) . ':F' . ($i + 15))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('R' . ($i + 1) . ':S' . ($i + 15))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('T' . ($i + 1) . ':T' . ($i + 15))->applyFromArray($styleThickBorderOutline);


            $objPHPExcel->getActiveSheet()->getStyle('U' . ($i + 1) . ':U' . ($i + 15))->applyFromArray($styleAlignmentCenter);
            $objPHPExcel->getActiveSheet()->getStyle('V' . ($i + 1) . ':V' . ($i + 15))->applyFromArray($styleAlignmentCenter);
            $objPHPExcel->getActiveSheet()->getRowDimension($i + 1)->setRowHeight(70);
            $objPHPExcel->getActiveSheet()->mergeCells('A' . ($i + 1) . ':B' . ($i + 13));


            $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 3).':D'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('Q'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('N'.($i + 3).':N'.($i + 14))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('O'.($i + 3).':O'.($i + 14))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('P'.($i + 3).':P'.($i + 14))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('Q'.($i + 3).':Q'.($i + 14))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('S'.($i + 2).':S'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('T'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->getActiveSheet()->getStyle('U'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#');
            $objPHPExcel->getActiveSheet()->getStyle('V'.($i + 15))->getNumberFormat()->setFormatCode('#,##0.#0');

        }

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('P3')->applyFromArray(
                array(
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
                )
            );
  
        $BStyleLast = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => 'FFFFFF')
            ),
        );
       //$objPHPExcel->getActiveSheet()->getStyle('U11:W'.($i - 1))->applyFromArray($BStyleLast);
       //$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':W'.($i + 1))->applyFromArray($BStyleLast);

       
        for ($i = 8; $i <= ($repeat) * 16; $i = ($i + 16)) {
            if(isset($totalsku[(($i - 9) / 15)][3][0])){
                $imagename = $totalsku[(($i - 9) / 15)][3][0];
                //$basepath = Yii::app()->basePath . '/..' .$imagename ; live
                $basepath = dirname(dirname(Yii::app()->basePath)).$imagename;
                if(file_exists($basepath)){
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('image');
                    $objDrawing->setDescription('image');
                    $objDrawing->setPath($basepath);
                    $objDrawing->setOffsetX(10);
                    $objDrawing->setOffsetY(25);
                    $objDrawing->setCoordinates('A' . ($i + 0));
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                } 
            }
        }

        spl_autoload_register(array('YiiBase', 'autoload'));
        //$obj = ComSpry::checkaliases($objPHPExcel, $client);
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        //$objPHPExcel = $obj;

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="BB.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas();
        $objWriter->save('php://output');


        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));


        Yii::app()->end();
    }

    private function getCpf($metal, $type, $count){
        if($metal == 'Silver'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((D'.$count .'*0.44)>2.5,(D'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((D'.$count .'*0.44)>4.5,(D'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((D'.$count .'*0.44)>2,(D'. $count . '*0.44),2)+0.42';
            }
        }else if($metal == 'Gold'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((D'.$count .'*2)>4,(D'. $count . '*2),4)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((D'.$count .'*2)>6,(D'. $count . '*2),6)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((D'.$count .'*2)>3,(D'. $count . '*2),3)+0.42';
            }
        }else if($metal == 'Brass'){
            if(in_array($type, array('Ring', 'Pendant', 'Earrings', 'Set', 'Brooch', 'Key Holder'))){
                return 'IF((D'.$count .'*0.44)>2.5,(D'. $count . '*0.44),2.5)+0.42';
            }else if(in_array($type, array('Bracelet', 'Necklace', 'Bangle', 'Rakhi'))){
                return 'IF((D'.$count .'*0.44)>4.5,(D'. $count . '*0.44),4.5)+0.42';
            }else if(in_array($type, array('Charms'))){
                return 'IF((D'.$count .'*0.44)>2,(D'. $count . '*0.44),2)+0.42';
            }
        }
    }


}