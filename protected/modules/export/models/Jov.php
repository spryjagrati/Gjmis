<?php

class Jov extends CController {

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
                $stones[] = array('pieces' => $skustone->pieces, 
                    'setting' => $skustone->idsetting0->name, 
                    'color' => $skustone->idstone0->color,
                    'shape' => trim($skustone->idstone0->idshape0->name), 
                    'size' => $skustone->idstone0->idstonesize0->size, 
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'month' => $skustone->idstone0->month,
                    'tmeth' => $skustone->idstone0->treatmeth, 
                    'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight);
            }
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
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost);
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


        // Venue : JOV


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'line_number')
                ->setCellValue('B1', 'type')
                ->setCellValue('C1', 'option_setup')
                ->setCellValue('D1', 'vendor_sku')
                ->setCellValue('E1', 'category_id')
                ->setCellValue('F1', 'name')
                ->setCellValue('G1', 'description')
                ->setCellValue('H1', 'summary')
                ->setCellValue('I1', 'option_description')
                ->setCellValue('J1', 'upc')
                ->setCellValue('K1', 'quantity')
                ->setCellValue('L1', 'package_weight')
                ->setCellValue('M1', 'dimensions')
                ->setCellValue('N1', 'box_length')
                ->setCellValue('O1', 'box_width')
                ->setCellValue('P1', 'box_height')
                ->setCellValue('Q1', 'isbn')
                ->setCellValue('R1', 'origin')
                ->setCellValue('S1', 'condition')
                ->setCellValue('T1', 'cost')
                ->setCellValue('U1', 'sell_price')
                ->setCellValue('V1', 'street_price')
                ->setCellValue('W1', 'normal_wholesale_price')
                ->setCellValue('X1', 'compare_at')
                ->setCellValue('Y1', 'compare_at_sales_location')
                ->setCellValue('Z1', 'supplier_image_main')
                ->setCellValue('AA1', 'supplier_image_mouse1')
                ->setCellValue('AB1', 'supplier_image_mouse1')
                ->setCellValue('AC1', 'materials')
                ->setCellValue('AD1', 'brand_id')
                ->setCellValue('AE1', 'manufacturer_name')
                ->setCellValue('AF1', 'manufacturer_partno')
                ->setCellValue('AG1', 'manufacturer_model_number')
                ->setCellValue('AH1', 'warranty_provider')
                ->setCellValue('AI1', 'warranty_information')
                ->setCellValue('AJ1', 'warranty_contact_phone')
                ->setCellValue('AK1', 'warehouse_zip')
                ->setCellValue('AL1', 'size');


        $objPHPExcel->getActiveSheet()->getStyle('A1:AL1')->getFont()->setBold(true);



        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top

        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


        for ($i = 2; $i <= $repeat + 1; $i++) {


            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $i - 2)
                    ->setCellValue('B' . $i, '')
                    ->setCellValue('C' . $i, '')
                    ->setCellValue('D' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('F' . $i, $totalsku[$i - 2][1]['name'])
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['descr'])
                    ->setCellValue('H' . $i, $totalsku[$i - 2][1]['name'])
                    ->setCellValue('I' . $i, '')
                    ->setCellValue('K' . $i, '1')
                    ->setCellValue('L' . $i, '1')
                    ->setCellValue('M' . $i, '' . $totalsku[$i - 2][0]['dimwid'] . '' . $totalsku[$i - 2][0]['dimunit'] . 'W : ' . $totalsku[$i - 2][0]['dimlen'] . '' . $totalsku[$i - 2][0]['dimunit'] . 'L')
                    ->setCellValue('N' . $i, '2')
                    ->setCellValue('O' . $i, '6')
                    ->setCellValue('P' . $i, '8')
                    ->setCellValue('R' . $i, 'IN')
                    ->setCellValue('S' . $i, 'N')
                    ->setCellValue('Y' . $i, 'target');
            if (isset($totalsku[$i - 2][3][0])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][0]);
            }
            if (isset($totalsku[$i - 2][3][1])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AA' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][1]);
            }
            if (isset($totalsku[$i - 2][3][2])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AB' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][2]);
            } {
                if (count($number[$i - 2]) == 3) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name'] . ',' . $totalsku[$i - 2][2][1]['name'] . ',' . $totalsku[$i - 2][2][2]['name']);
                } elseif (count($number[$i - 2]) == 2) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name'] . ',' . $totalsku[$i - 2][2][1]['name']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name']);
                }
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AD' . $i, '0');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . $i, 'JEWELRYAUCTIONSTV')
                    ->setCellValue('AF' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('AG' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('AH' . $i, 'N')
                    ->setCellValue('AK' . $i, '11021')
                    ->setCellValue('AL' . $i, isset($totalsku[$i - 2][2]['size']) ? $totalsku[$i - 2][2]['size'] : '');
        }





        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
         header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="JOV.xlsx"');
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
?>


