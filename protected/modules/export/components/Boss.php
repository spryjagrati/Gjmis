<?php

class Boss extends CController{

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
            $number[] = count($skustones);
            $stones = array();
            foreach ($skustones as $skustone) {
                $stones[] = array('pieces' => $skustone->pieces, 'color' => $skustone->idstone0->color,
                    'clarity' => $skustone->idstone0->idclarity0->name, 'shape' => trim($skustone->idstone0->idshape0->name),
                    'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight,'month' => $skustone->idstone0->month);
            }
            $newstones = Newstone::unqiuestones($stones);
            $skuimages = $sku->skuimages(array('condition' => 'idclient=1', 'type' => 'Gall'));
            $skuimages + $sku->skuimages(array('condition' => 'idclient=1'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageUrl;
            }
            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $newstones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost);
        }
        //echo('<pre>');print_r($totalsku);die();
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


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Item SKU')
                ->setCellValue('B1', 'Qty')
                ->setCellValue('C1', 'Size')
                ->setCellValue('D1', 'Metal')
                ->setCellValue('E1', 'Gem1')
                ->setCellValue('F1', 'Qty/Ctw1')
                ->setCellValue('G1', 'Color/Clarity1')
                ->setCellValue('H1', 'Shape1')
                ->setCellValue('I1', 'Gem2')
                ->setCellValue('J1', 'Qty/Ctw2')
                ->setCellValue('K1', 'Color/Clarity2')
                ->setCellValue('L1', 'Shape2')
                ->setCellValue('M1', 'Gem3')
                ->setCellValue('N1', 'Qty/Ctw3')
                ->setCellValue('O1', 'Color/Clarity3')
                ->setCellValue('P1', 'Shape3')
                ->setCellValue('Q1', 'Gem4')
                ->setCellValue('R1', 'Qty/Ctw4')
                ->setCellValue('S1', 'Color/Clarity4')
                ->setCellValue('T1', 'Shape4')
                ->setCellValue('U1', 'Gem5')
                ->setCellValue('V1', 'Qty/Ctw5')
                ->setCellValue('W1', 'Color/Clarity5')
                ->setCellValue('X1', 'Shape5')
                ->setCellValue('Y1', 'Gem6')
                ->setCellValue('Z1', 'Qty/Ctw6')
                ->setCellValue('AA1', 'Color/Clarity6')
                ->setCellValue('AB1', 'Shape6')
                ->setCellValue('AC1', 'Gem7')
                ->setCellValue('AD1', 'Qty/Ctw7')
                ->setCellValue('AE1', 'Color/Clarity7')
                ->setCellValue('AF1', 'Shape7')
                ->setCellValue('AG1', 'Gem8')
                ->setCellValue('AH1', 'Qty/Ctw8')
                ->setCellValue('AI1', 'Color/Clarity8')
                ->setCellValue('AJ1', 'Shape8')
                ->setCellValue('AK1', 'Gem9')
                ->setCellValue('AL1', 'Qty/Ctw9')
                ->setCellValue('AM1', 'Color/Clarity9')
                ->setCellValue('AN1', 'Shape9')
                ->setCellValue('AO1', 'Gem10')
                ->setCellValue('AP1', 'Qty/Ctw10')
                ->setCellValue('AQ1', 'Color/Clarity10')
                ->setCellValue('AR1', 'Shape10')
                ->setCellValue('AS1', 'Gem11')
                ->setCellValue('AT1', 'Qty/Ctw11')
                ->setCellValue('AU1', 'Color/Clarity11')
                ->setCellValue('AV1', 'Shape11')
                ->setCellValue('AW1', 'Gem12')
                ->setCellValue('AX1', 'Qty/Ctw12')
                ->setCellValue('AY1', 'Color/Clarity12')
                ->setCellValue('AZ1', 'Shape12')
                ->setCellValue('BA1', 'Gem13')
                ->setCellValue('BB1', 'Qty/Ctw13')
                ->setCellValue('BC1', 'Color/Clarity13')
                ->setCellValue('BD1', 'Shape13')
                ->setCellValue('BE1', 'Gem14')
                ->setCellValue('BF1', 'Qty/Ctw14')
                ->setCellValue('BG1', 'Color/Clarity14')
                ->setCellValue('BH1', 'Shape14')
                ->setCellValue('BI1', 'Gem15')
                ->setCellValue('BJ1', 'Qty/Ctw15')
                ->setCellValue('BK1', 'Color/Clarity15')
                ->setCellValue('BL1', 'Shape15');

        $objPHPExcel->getActiveSheet()->getStyle('A1:BL1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->freezePane('A2');

        for ($i = 2; $i <= $repeat + 1; $i++) {
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, '')
                    ->setCellValue('C' . $i, $totalsku[$i - 2][1]['size'])
                    ->setCellValue('D' . $i, $totalsku[$i - 2][4]);

            if ($totalsku[$i - 2][2][0]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('E' . $i, $totalsku[$i - 2][2][0]['name'])
                        ->setCellValue('F' . $i, $totalsku[$i - 2][2][0]['pieces'] . '/' . $totalsku[$i - 2][2][0]['weight']);
                if (stristr($totalsku[$i - 2][2][0]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $i, $totalsku[$i - 2][2][0]['color'] . '/' . $totalsku[$i - 2][2][0]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $i, $totalsku[$i - 2][2][0]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $i, $totalsku[$i - 2][2][0]['shape']);
            }

            if ($totalsku[$i - 2][2][1]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('I' . $i, $totalsku[$i - 2][2][1]['name'])
                        ->setCellValue('J' . $i, $totalsku[$i - 2][2][1]['pieces'] . '/' . $totalsku[$i - 2][2][1]['weight']);
                if (stristr($totalsku[$i - 2][2][1]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, $totalsku[$i - 2][2][1]['color'] . '/' . $totalsku[$i - 2][2][1]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, $totalsku[$i - 2][2][1]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, $totalsku[$i - 2][2][1]['shape']);
            }

            if ($totalsku[$i - 2][2][2]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('M' . $i, $totalsku[$i - 2][2][2]['name'])
                        ->setCellValue('N' . $i, $totalsku[$i - 2][2][2]['pieces'] . '/' . $totalsku[$i - 2][2][2]['weight']);
                if (stristr($totalsku[$i - 2][2][2]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, $totalsku[$i - 2][2][2]['color'] . '/' . $totalsku[$i - 2][2][2]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, $totalsku[$i - 2][2][2]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $i, $totalsku[$i - 2][2][2]['shape']);
            }
            if ($totalsku[$i - 2][2][3]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('Q' . $i, $totalsku[$i - 2][2][3]['name'])
                        ->setCellValue('R' . $i, $totalsku[$i - 2][2][3]['pieces'] . '/' . $totalsku[$i - 2][2][3]['weight']);
                if (stristr($totalsku[$i - 2][2][2]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $totalsku[$i - 2][2][3]['color'] . '/' . $totalsku[$i - 2][2][3]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $totalsku[$i - 2][2][3]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $i, $totalsku[$i - 2][2][3]['shape']);
            }
            if ($totalsku[$i - 2][2][4]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('U' . $i, $totalsku[$i - 2][2][4]['name'])
                        ->setCellValue('V' . $i, $totalsku[$i - 2][2][4]['pieces'] . '/' . $totalsku[$i - 2][2][4]['weight']);
                if (stristr($totalsku[$i - 2][2][4]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('W' . $i, $totalsku[$i - 2][2][4]['color'] . '/' . $totalsku[$i - 2][2][4]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('W' . $i, $totalsku[$i - 2][2][4]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, $totalsku[$i - 2][2][4]['shape']);
            }
            if ($totalsku[$i - 2][2][5]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('Y' . $i, $totalsku[$i - 2][2][5]['name'])
                        ->setCellValue('Z' . $i, $totalsku[$i - 2][2][5]['pieces'] . '/' . $totalsku[$i - 2][2][5]['weight']);
                if (stristr($totalsku[$i - 2][2][5]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, $totalsku[$i - 2][2][5]['color'] . '/' . $totalsku[$i - 2][2][5]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, $totalsku[$i - 2][2][5]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AB' . $i, $totalsku[$i - 2][2][5]['shape']);
            }
            if ($totalsku[$i - 2][2][6]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AC' . $i, $totalsku[$i - 2][2][6]['name'])
                        ->setCellValue('AD' . $i, $totalsku[$i - 2][2][6]['pieces'] . '/' . $totalsku[$i - 2][2][6]['weight']);
                if (stristr($totalsku[$i - 2][2][2]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . $i, $totalsku[$i - 2][2][6]['color'] . '/' . $totalsku[$i - 2][2][6]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . $i, $totalsku[$i - 2][2][6]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AF' . $i, $totalsku[$i - 2][2][6]['shape']);
            }
            if ($totalsku[$i - 2][2][7]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AG' . $i, $totalsku[$i - 2][2][7]['name'])
                        ->setCellValue('AH' . $i, $totalsku[$i - 2][2][7]['pieces'] . '/' . $totalsku[$i - 2][2][7]['weight']);
                if (stristr($totalsku[$i - 2][2][7]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AI' . $i, $totalsku[$i - 2][2][7]['color'] . '/' . $totalsku[$i - 2][2][7]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AI' . $i, $totalsku[$i - 2][2][7]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ' . $i, $totalsku[$i - 2][2][7]['shape']);
            }

            if ($totalsku[$i - 2][2][8]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AK' . $i, $totalsku[$i - 2][2][8]['name'])
                        ->setCellValue('AL' . $i, $totalsku[$i - 2][2][8]['pieces'] . '/' . $totalsku[$i - 2][2][8]['weight']);
                if (stristr($totalsku[$i - 2][2][8]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AM' . $i, $totalsku[$i - 2][2][8]['color'] . '/' . $totalsku[$i - 2][2][8]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AM' . $i, $totalsku[$i - 2][2][8]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AN' . $i, $totalsku[$i - 2][2][8]['shape']);
            }

            if ($totalsku[$i - 2][2][9]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AO' . $i, $totalsku[$i - 2][2][9]['name'])
                        ->setCellValue('AP' . $i, $totalsku[$i - 2][2][9]['pieces'] . '/' . $totalsku[$i - 2][2][9]['weight']);
                if (stristr($totalsku[$i - 2][2][9]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, $totalsku[$i - 2][2][9]['color'] . '/' . $totalsku[$i - 2][2][9]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, $totalsku[$i - 2][2][9]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AR' . $i, $totalsku[$i - 2][2][9]['shape']);
            }

            if ($totalsku[$i - 2][2][10]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AS' . $i, $totalsku[$i - 2][2][10]['name'])
                        ->setCellValue('AT' . $i, $totalsku[$i - 2][2][10]['pieces'] . '/' . $totalsku[$i - 2][2][10]['weight']);
                if (stristr($totalsku[$i - 2][2][10]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, $totalsku[$i - 2][2][10]['color'] . '/' . $totalsku[$i - 2][2][10]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, $totalsku[$i - 2][2][10]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, $totalsku[$i - 2][2][10]['shape']);
            }

            if ($totalsku[$i - 2][2][11]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AW' . $i, $totalsku[$i - 2][2][11]['name'])
                        ->setCellValue('AX' . $i, $totalsku[$i - 2][2][11]['pieces'] . '/' . $totalsku[$i - 2][2][11]['weight']);
                if (stristr($totalsku[$i - 2][2][11]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AY' . $i, $totalsku[$i - 2][2][11]['color'] . '/' . $totalsku[$i - 2][2][11]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AY' . $i, $totalsku[$i - 2][2][11]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AZ' . $i, $totalsku[$i - 2][2][11]['shape']);
            }

            if ($totalsku[$i - 2][2][12]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('BA' . $i, $totalsku[$i - 2][2][12]['name'])
                        ->setCellValue('BB' . $i, $totalsku[$i - 2][2][12]['pieces'] . '/' . $totalsku[$i - 2][2][12]['weight']);
                if (stristr($totalsku[$i - 2][2][12]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BC' . $i, $totalsku[$i - 2][2][12]['color'] . '/' . $totalsku[$i - 2][2][12]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BC' . $i, $totalsku[$i - 2][2][12]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BD' . $i, $totalsku[$i - 2][2][12]['shape']);
            }


            if ($totalsku[$i - 2][2][13]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('BE' . $i, $totalsku[$i - 2][2][13]['name'])
                        ->setCellValue('BF' . $i, $totalsku[$i - 2][2][13]['pieces'] . '/' . $totalsku[$i - 2][2][13]['weight']);
                if (stristr($totalsku[$i - 2][2][13]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BG' . $i, $totalsku[$i - 2][2][13]['color'] . '/' . $totalsku[$i - 2][2][13]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BG' . $i, $totalsku[$i - 2][2][13]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BH' . $i, $totalsku[$i - 2][2][13]['shape']);
            }

            if ($totalsku[$i - 2][2][14]) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('BI' . $i, $totalsku[$i - 2][2][14]['name'])
                        ->setCellValue('BJ' . $i, $totalsku[$i - 2][2][14]['pieces'] . '/' . $totalsku[$i - 2][2][14]['weight']);
                if (stristr($totalsku[$i - 2][2][14]['name'], 'diamond')) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BK' . $i, $totalsku[$i - 2][2][14]['color'] . '/' . $totalsku[$i - 2][2][14]['clarity']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('BK' . $i, $totalsku[$i - 2][2][14]['color']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BL' . $i, $totalsku[$i - 2][2][14]['shape']);
            }
        }
        $styleThinBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:BL' . ($i - 1))->applyFromArray($styleThinBorderOutline);


        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client's web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Boss.xlsx"');
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        //
        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
    }

   
	
}

