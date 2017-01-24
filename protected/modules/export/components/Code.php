<?php

class Code extends CController{

    public function export($skuids) {
       $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $qty = 0;
        $wt = 0;
        $diaqty = 0;
        $diawt = 0;

        //Do all DB processing before loading PHPExcel
        foreach ($ids as $id) {
            $totstones = array();
            $totcost = 0;
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $number[] = count($skustones);
            $qty = array();
            $wt = array();
            $stones = array();
            foreach ($skustones as $skustone) {
                $stones[] = array('pieces' => $skustone->pieces, 'color' => $skustone->idstone0->color,
                    'clarity' => $skustone->idstone0->idclarity0->name, 'shape' => trim($skustone->idstone0->idshape0->name),
                    'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 'month' => $skustone->idstone0->month);
                $totstones[] = $skustone->idstone0->namevar;
                $totstones1[] = array_unique($totstones);
                if (stristr($skustone->idstone0->namevar, 'diamond')) {
                    $diaqty += $skustone->pieces;
                    $diawt += ($skustone->pieces * $skustone->idstone0->weight);
                } else {
                    $qty[] = $skustone->pieces;
                    $wt[] = ($skustone->pieces * $skustone->idstone0->weight);
                }
            }
            //$newstones = $this->unqiuestones($stones);
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

            if ($id) {
                $totcost = ComSpry::calcSkuCost($id);
            }

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $qty, $wt, $totcost, $diaqty, $diawt);
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
                ->setCellValue('A1', 'Code ME  Description File')
                ->setCellValue('A2', 'SKU#')
                ->setCellValue('B2', 'Shape')
                ->setCellValue('C2', 'Size')
                ->setCellValue('D2', 'Qty')
                ->setCellValue('E2', 'Gross Wt.')
                ->setCellValue('F2', 'Metal')
                ->setCellValue('G2', 'Gem1')
                ->setCellValue('H2', 'Gem2')
                ->setCellValue('I2', 'Gem3')
                ->setCellValue('J2', 'Gem4')
                ->setCellValue('K2', 'Gem5')
                ->setCellValue('L2', 'Gem6')
                ->setCellValue('M2', 'Gem7')
                ->setCellValue('N2', 'Gem8')
                ->setCellValue('O2', 'Gem9')
                ->setCellValue('P2', 'Gem10')
                ->setCellValue('Q2', 'Gem11')
                ->setCellValue('R2', 'Gem12')
                ->setCellValue('S2', 'Gem13')
                ->setCellValue('T2', 'Gem14')
                ->setCellValue('U2', 'Gem15')
                ->setCellValue('V2', 'Total Gem Qty/CWt')
                ->setCellValue('W2', 'Dia Qty/CWt')
                ->setCellValue('X2', 'Price')
                ->setCellValue('Y2', 'Cust Ref#');

        $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->freezePane('A2');

        for ($i = 3; $i <= $repeat + 2; $i++) {
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $totalsku[$i - 3][0]['skucode'])
                    ->setCellValue('B' . $i, '')
                    ->setCellValue('C' . $i, $totalsku[$i - 3][1]['size'])
                    ->setCellValue('D' . $i, '')
                    ->setCellValue('E' . $i, $totalsku[$i - 3][0]['grosswt'])
                    ->setCellValue('F' . $i, $totalsku[$i - 3][4]);

            //echo "<pre>";print_r($totalsku[$i-3][2][0]['name']);die;  
            if ($totalsku[$i - 3][2][0]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $i, $totalsku[$i - 3][2][0]['name']);
            }
            if ($totalsku[$i - 3][2][1]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $i, $totalsku[$i - 3][2][1]['name']);
            }
            if ($totalsku[$i - 3][2][2]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $i, $totalsku[$i - 3][2][2]['name']);
            }
            if ($totalsku[$i - 3][2][3]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $i, $totalsku[$i - 3][2][3]['name']);
            }
            if ($totalsku[$i - 3][2][4]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i, $totalsku[$i - 3][2][4]['name']);
            }
            if ($totalsku[$i - 3][2][5]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, $totalsku[$i - 3][2][5]['name']);
            }
            if ($totalsku[$i - 3][2][6]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, $totalsku[$i - 3][2][6]['name']);
            }
            if ($totalsku[$i - 3][2][7]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i, $totalsku[$i - 3][2][7]['name']);
            }
            if ($totalsku[$i - 3][2][8]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, $totalsku[$i - 3][2][8]['name']);
            }
            if ($totalsku[$i - 3][2][9]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $i, $totalsku[$i - 3][2][9]['name']);
            }
            if ($totalsku[$i - 3][2][10]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, $totalsku[$i - 3][2][10]['name']);
            }
            if ($totalsku[$i - 3][2][11]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $i, $totalsku[$i - 3][2][11]['name']);
            }
            if ($totalsku[$i - 3][2][12]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $i, $totalsku[$i - 3][2][12]['name']);
            }
            if ($totalsku[$i - 3][2][13]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $i, $totalsku[$i - 3][2][13]['name']);
            }
            if ($totalsku[$i - 3][2][14]) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . $i, $totalsku[$i - 3][2][14]['name']);
            }




            $objPHPExcel->setActiveSheetIndex()->setCellValue('V' . $i, array_sum($totalsku[$i - 3][8]) . '/' . number_format(array_sum($totalsku[$i - 3][9]), 2));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('W' . $i, $totalsku[$i - 3][11] . '/' . number_format($totalsku[$i - 3][12], 2));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, number_format($totalsku[$i - 3][10], 2));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Y' . $i, $totalsku[$i - 3][0]['refpo']);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        }
        //echo "<pre>";print_r($totalsku);die;
        $styleThinBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle('A2:Y2')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '191970')
                    ),
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => 'FFFFFF')
                    )
                )
        );


        $objPHPExcel->getActiveSheet()->getStyle('A1:Y' . ($i))->applyFromArray($styleThinBorderOutline);


        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client's web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="CodeME.xlsx"');
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