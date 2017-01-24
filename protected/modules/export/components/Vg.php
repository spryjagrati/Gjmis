<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Vg extends CController {

    public function export($skuids) {

        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        
        //Do all DB processing before loading PHPExcel
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $stones = array();
            foreach ($skustones as $skustone) {
                $stones[] = array(
                    'pieces' => $skustone->pieces, 
                    'setting' => $skustone->idsetting0->name, 
                    'color' => $skustone->idstone0->color,
                    'clarity' => isset($skustone->idstone0->idclarity0) ? $skustone->idstone0->idclarity0->name : '', 
                    'shape' => trim($skustone->idstone0->idshape0->name), 
                    'size' => $skustone->idstone0->idstonesize0->size, 
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'month' => $skustone->idstone0->month,
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth, 
                    'name' => $skustone->idstone0->namevar, 
                    'weight' => $skustone->idstone0->weight,
                    'type' => $skustone->idstone0->idstonem0->type,
                );
            }
            
           
            $finds = array();
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    'weight' => $finding->idfinding0->weight,
                );
            }
            
            $all_stones = array();
            $newstones = Newstone::unqiuestones($stones);
            $new_stones = $this->uniquestones($stones);
            foreach($newstones as $newstone){
                $all_stones[$newstone['name']] = [];
            }
            
            
            foreach($new_stones as $new_stone){
                foreach($all_stones as $key => $value){
                    if($key == $new_stone['name']){
                        $all_stones[$key][] = $new_stone;
                    }
                }
            }
            //echo('<pre>'); print_r($new_stones);print_r($all_stones); die();
            $skuimages = $sku->skuimages(array('condition' => 'idclient=1', 'type' => 'Gall'));
            $skuimages + $sku->skuimages(array('condition' => 'idclient=1'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageUrl;
            }
            $skumetal = $sku->skumetals[0];
            
            
            $metalalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->namevar, 'aTarget' => 12, 'aField' => 'Metal'));
            $metal = isset($metalalias) ? $metalalias->alias : $skumetal->idmetal0->namevar;
            
           // $finishing = isset($metalalias->depaliases[0]) ? $metalalias->depaliases[0]->alias : ''; 
            $finishing = ''; //for local
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            $totcost = ComSpry::calcSkuCost($id);
            $totalsku[] = array(
                $sku->attributes, 
                $skucontent->attributes, 
                $newstones, 
                $imageUrls, 
                $metal, 
                $metalcost, 
                $metalstamp, 
                $currentcost, 
                $totcost, 
                $finds,
                $finishing, 
                $all_stones
            );
        }

        
        //
        // get a reference to the path of PHPExcel classes
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        //
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


        // Venue : VG
        $styleDefaultArray = array(
            'font' => array(
                'bold' => false,
                'size'=>10,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );

        $styleHeaderArray = array(
            'font' => array(
                'bold' => true,
                'size'=>10,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $styleHeaderAColor = array(
            'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '61B329')
                ),
        );  
        $styleHeaderIColor = array(
            'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '00CCFF')
            ),
        ); 
        $styleHeaderXColor = array(
            'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '9B30FF')
            ),
        ); 
        $styleThickBorderRight = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
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
        $styleDefaultCenterArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:CI1')->applyFromArray($styleHeaderArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeaderAColor);
        $objPHPExcel->getActiveSheet()->getStyle('I1:W1')->applyFromArray($styleHeaderIColor);
        $objPHPExcel->getActiveSheet()->getStyle('X1:AA1')->applyFromArray($styleHeaderXColor);
        $objPHPExcel->getActiveSheet()->getStyle('AB1:AE1')->applyFromArray($styleHeaderAColor);

        $counth= 0; $ct = 0;
        for($k = 'AF'; $k <= 'CI'; $k++){
            if($counth == 0){
                $objPHPExcel->getActiveSheet()->getStyle($k.'1')->applyFromArray($styleHeaderXColor);
                $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(15);
                $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
                $ct++;
                if($ct == 2){ $counth = 1; $ct = 0;}
            }else{
                $objPHPExcel->getActiveSheet()->getStyle($k.'1')->applyFromArray($styleHeaderAColor);
                $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(19);
                $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
                $ct++;
                if($ct == 2){ $counth = 0; $ct = 0;}  
            }
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray($styleThickBorderRight);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getStyle('H1:H1')->applyFromArray($styleThickBorderRight);
        for($k = 'B' ;$k <='G' ; $k++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(12);
            $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
        }
        for($k = 'I' ;$k <='N' ; $k++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
        }
        for($k = 'AB' ;$k <='AE' ; $k++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
        }
        for($k = 'O' ;$k <='W' ; $k++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(8);
            $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
        }
        for($k = 'X' ;$k <= 'AA' ; $k++){
            $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(22);
            $objPHPExcel->getActiveSheet()->getStyle($k.'1:'.$k.'1')->applyFromArray($styleThickBorderRight);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A1:CI1')->applyFromArray($styleThickBlackBorderBottom);
        

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Item Code')
                ->setCellValue('B1', 'Raw Cost')
                ->setCellValue('C1', 'Quantity')
                ->setCellValue('D1', 'Made of')
                ->setCellValue('E1', 'Plated with')
                ->setCellValue('F1', 'Net Weight')
                ->setCellValue('G1', 'Size/Length')
                ->setCellValue('H1', 'Overall Weight')
                ->setCellValue('I1', 'Gem1')
                ->setCellValue('J1', 'Gem2')
                ->setCellValue('K1', 'Gem3')
                ->setCellValue('L1', 'Gem4')
                ->setCellValue('M1', 'Gem5')
                ->setCellValue('N1', 'Gem6')
                ->setCellValue('O1', 'Gem7')
                ->setCellValue('P1', 'Gem8')
                ->setCellValue('Q1', 'Gem9')
                ->setCellValue('R1', 'Gem10')
                ->setCellValue('S1', 'Gem11')
                ->setCellValue('T1', 'Gem12')
                ->setCellValue('U1', 'Gem13')
                ->setCellValue('V1', 'Gem14')
                ->setCellValue('W1', 'Gem15')
                ->setCellValue('X1', 'Gem1 Shape1')
                ->setCellValue('Y1', 'Gem1 Shape2')
                ->setCellValue('Z1', 'Gem1 Shape3')
                ->setCellValue('AA1', 'Gem1 Shape4')
                ->setCellValue('AB1', 'Gem1 Shape1 ctw/qty')
                ->setCellValue('AC1', 'Gem1 Shape2 ctw/qty')
                ->setCellValue('AD1', 'Gem1 Shape3 ctw/qty')
                ->setCellValue('AE1', 'Gem1 Shape4 ctw/qty')
                ->setCellValue('AF1', 'Gem2 Shape1')
                ->setCellValue('AG1', 'Gem2 Shape2')
                ->setCellValue('AH1', 'Gem2 Shape1 ctw/qty')
                ->setCellValue('AI1', 'Gem2 Shape2 ctw/qty')
                ->setCellValue('AJ1', 'Gem3 Shape1')
                ->setCellValue('AK1', 'Gem3 Shape2')
                ->setCellValue('AL1', 'Gem3 Shape1 ctw/qty')
                ->setCellValue('AM1', 'Gem3 Shape2 ctw/qty')
                ->setCellValue('AN1', 'Gem4 Shape1')
                ->setCellValue('AO1', 'Gem4 Shape2')
                ->setCellValue('AP1', 'Gem4 Shape1 ctw/qty')
                ->setCellValue('AQ1', 'Gem4 Shape2 ctw/qty')
                ->setCellValue('AR1', 'Gem5 Shape1')
                ->setCellValue('AS1', 'Gem5 Shape2')
                ->setCellValue('AT1', 'Gem5 Shape1 ctw/qty')
                ->setCellValue('AU1', 'Gem5 Shape2 ctw/qty')
                ->setCellValue('AV1', 'Gem6 Shape1')
                ->setCellValue('AW1', 'Gem6 Shape2')
                ->setCellValue('AX1', 'Gem6 Shape1 ctw/qty')
                ->setCellValue('AY1', 'Gem6 Shape2 ctw/qty')
                ->setCellValue('AZ1', 'Gem7 Shape1')
                ->setCellValue('BA1', 'Gem7 Shape2')
                ->setCellValue('BB1', 'Gem7 Shape1 ctw/qty')
                ->setCellValue('BC1', 'Gem7 Shape2 ctw/qty')
                ->setCellValue('BD1', 'Gem8 Shape1')
                ->setCellValue('BE1', 'Gem8 Shape2')
                ->setCellValue('BF1', 'Gem8 Shape1 ctw/qty')
                ->setCellValue('BG1', 'Gem8 Shape2 ctw/qty')
                ->setCellValue('BH1', 'Gem9 Shape1')
                ->setCellValue('BI1', 'Gem9 Shape2')
                ->setCellValue('BJ1', 'Gem9 Shape1 ctw/qty')
                ->setCellValue('BK1', 'Gem9 Shape2 ctw/qty')
                ->setCellValue('BL1', 'Gem10 Shape1')
                ->setCellValue('BM1', 'Gem10 Shape2')
                ->setCellValue('BN1', 'Gem10 Shape1 ctw/qty')
                ->setCellValue('BO1', 'Gem10 Shape2 ctw/qty')
                ->setCellValue('BP1', 'Gem11 Shape1')
                ->setCellValue('BQ1', 'Gem11 Shape2')
                ->setCellValue('BR1', 'Gem11 Shape1 ctw/qty')
                ->setCellValue('BS1', 'Gem11 Shape2 ctw/qty')
                ->setCellValue('BT1', 'Gem12 Shape1')
                ->setCellValue('BU1', 'Gem12 Shape2')
                ->setCellValue('BV1', 'Gem12 Shape1 ctw/qty')
                ->setCellValue('BW1', 'Gem12 Shape2 ctw/qty')
                ->setCellValue('BX1', 'Gem13 Shape1')
                ->setCellValue('BY1', 'Gem13 Shape2')
                ->setCellValue('BZ1', 'Gem13 Shape1 ctw/qty')
                ->setCellValue('CA1', 'Gem13 Shape2 ctw/qty')
                ->setCellValue('CB1', 'Gem14 Shape1')
                ->setCellValue('CC1', 'Gem14 Shape2')
                ->setCellValue('CD1', 'Gem14 Shape1 ctw/qty')
                ->setCellValue('CE1', 'Gem14 Shape2 ctw/qty')
                ->setCellValue('CF1', 'Gem15 Shape1')
                ->setCellValue('CG1', 'Gem15 Shape2')
                ->setCellValue('CH1', 'Gem15 Shape1 ctw/qty')
                ->setCellValue('CI1', 'Gem15 Shape2 ctw/qty');




        //$objPHPExcel->getActiveSheet()->getStyle('A1:CI1')->getFont()->setBold(true);



        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        for ($i = 2; $i <= $repeat + 1; $i++) {
            
            $chain_wt = 0;
            foreach ($totalsku[($i - 2)][9] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }
        
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, '')
                    ->setCellValue('C' . $i, '')
                    ->setCellValue('D' . $i, $totalsku[$i - 2][4]);
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $i, $totalsku[($i - 2)][10]);
            
            if ($totalsku[($i - 2)][1]['type'] === 'Pendant' || $totalsku[($i - 2)][1]['type'] === 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $i, number_format(($totalsku[$i - 2][0]['totmetalwei'] + $chain_wt),"2",".",""));
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $i, number_format($totalsku[$i - 2][0]['totmetalwei'],"2",".",""));
            }
            
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['size'])
                    ->setCellValue('H' . $i, number_format($totalsku[$i - 2][0]['grosswt']+$chain_wt,"2",".",""));
            
            if (isset($totalsku[$i - 2][2][0]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $i, $totalsku[$i - 2][2][0]['name']);
            }
            if (isset($totalsku[$i - 2][2][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $i, $totalsku[$i - 2][2][1]['name']);
            }
            if (isset($totalsku[$i - 2][2][2]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, $totalsku[$i - 2][2][2]['name']);
            }
            if (isset($totalsku[$i - 2][2][3]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, $totalsku[$i - 2][2][3]['name']);
            }
            if (isset($totalsku[$i - 2][2][4]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, $totalsku[$i - 2][2][4]['name']);
            }
            if (isset($totalsku[$i - 2][2][5]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i, $totalsku[$i - 2][2][5]['name']);
            }
            if (isset($totalsku[$i - 2][2][6]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, $totalsku[$i - 2][2][6]['name']);
            }
            if (isset($totalsku[$i - 2][2][7]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $i, $totalsku[$i - 2][2][7]['name']);
            }
            if (isset($totalsku[$i - 2][2][8]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, $totalsku[$i - 2][2][8]['name']);
            }
            if (isset($totalsku[$i - 2][2][9]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $i, $totalsku[$i - 2][2][9]['name']);
            }
            if (isset($totalsku[$i - 2][2][10]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $totalsku[$i - 2][2][10]['name']);
            }
            if (isset($totalsku[$i - 2][2][11]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $i, $totalsku[$i - 2][2][11]['name']);
            }
            if (isset($totalsku[$i - 2][2][12]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . $i, $totalsku[$i - 2][2][12]['name']);
            }
            if (isset($totalsku[$i - 2][2][13]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('V' . $i, $totalsku[$i - 2][2][13]['name']);
            }
            if (isset($totalsku[$i - 2][2][14]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('W' . $i, $totalsku[$i - 2][2][14]['name']);
            }

            
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0]['shape'] == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Y' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2]['shape']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3]['shape']);
            }
            if (isset($totalsku[$i - 2][2][1]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AF' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][1]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AG' . $i,$totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][2]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][2]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AK' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][3]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AN' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][3]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AO' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][4]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AR' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][4]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AS' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1]['shape']  == 'Pears' ? 'Pear' : $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][5]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][5]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AW' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][6]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AZ' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][6]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BA' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][7]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BD' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][7]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BE' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][8]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BH' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][8]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BI' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][9]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BL' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][9]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BM' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][10]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BP' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][10]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BQ' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][11]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BT' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][11]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BU' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][12]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BX' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][12]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BY' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][13]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CB' . $i,$totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][13]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CC' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][14]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CF' . $i,$totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][14]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CG' . $i, $totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1]['shape']  == 'Pears' ? 'Pear' : $totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1]['shape']);
            }


            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AB' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AD' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][2]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][0]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][0]['name']][3]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][1]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AH' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][1]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AI' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][1]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][2]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AL' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][2]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AM' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][2]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][3]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AP' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][3]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][3]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][4]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AT' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][4]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][4]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][5]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AX' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][5]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AY' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][5]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][6]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BB' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][6]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BC' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][6]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][7]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BF' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][7]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BG' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1]['weight']),"2",".","") . '/' .$totalsku[$i - 2][11][$totalsku[$i - 2][2][7]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][8]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BJ' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][8]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BK' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][8]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][9]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BN' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][9]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BO' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][9]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][10]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BR' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][10]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BS' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][10]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][11]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BV' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][11]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BW' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][11]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][12]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BZ' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][12]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CA' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][12]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][13]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CD' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][13]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CE' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][13]['name']][1]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][14]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CH' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][0]['pieces']);
            }
            if (isset($totalsku[$i - 2][2][14]) && isset($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CI' . $i, number_format(($totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1]['weight']),"2",".","") . '/' . $totalsku[$i - 2][11][$totalsku[$i - 2][2][14]['name']][1]['pieces']);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':CI'.$i)->applyFromArray($styleDefaultArray);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':CI'.$i)->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':CI'.$i)->applyFromArray($styleThickBorderRight);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$i.':H'.$i)->applyFromArray($styleDefaultCenterArray);

        }

        
       
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="VG.xlsx"');
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        //
        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
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
