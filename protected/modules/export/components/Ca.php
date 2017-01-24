<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ca extends CController {

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
                $stones[] = array('pieces' => $skustone->pieces, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    //'clarity' => $skustone->idstone0->idclarity0->name, 
                    'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 'month' => $skustone->idstone0->month);
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


        // Add some data
        //Venue : CA

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Inventory Number')
                ->setCellValue('B1', 'Auction Title')
                ->setCellValue('C1', 'Quantity Update Type')
                ->setCellValue('D1', 'Quantity')
                ->setCellValue('E1', 'Starting Bid')
                ->setCellValue('F1', 'Short Description')
                ->setCellValue('G1', 'Description')
                ->setCellValue('H1', 'RAW COST')
                ->setCellValue('I1', 'Seller Cost')
                ->setCellValue('J1', 'Buy It Now Price')
                ->setCellValue('K1', 'Retail Price')
                ->setCellValue('L1', 'Second Chance Offer Price')
                ->setCellValue('M1', 'Picture URLs')
                ->setCellValue('N1', 'Ad Template Name')
                ->setCellValue('O1', 'Posting Template Name')
                ->setCellValue('P1', 'Schedule Name')
                ->setCellValue('Q1', 'eBay Category List')
                ->setCellValue('R1', 'eBay Store Category Name')
                ->setCellValue('S1', 'Classification')
                ->setCellValue('T1', 'Attribute1Name')
                ->setCellValue('U1', 'Attribute1Value')
                ->setCellValue('V1', 'Attribute2Name')
                ->setCellValue('W1', 'Attribute2Value')
                ->setCellValue('X1', 'Attribute3Name')
                ->setCellValue('Y1', 'Attribute3Value')
                ->setCellValue('Z1', 'Attribute4Name')
                ->setCellValue('AA1', 'Attribute4Value')
                ->setCellValue('AB1', 'Attribute5Name')
                ->setCellValue('AC1', 'Attribute5Value')
                ->setCellValue('AD1', 'Attribute6Name')
                ->setCellValue('AE1', 'Attribute6Value')
                ->setCellValue('AF1', 'Attribute7Name')
                ->setCellValue('AG1', 'Attribute7Value')
                ->setCellValue('AH1', 'Attribute8Name')
                ->setCellValue('AI1', 'Attribute8Value')
                ->setCellValue('AJ1', 'Attribute9Name')
                ->setCellValue('AK1', 'Attribute9Value')
                ->setCellValue('AL1', 'Attribute25Name')
                ->setCellValue('AM1', 'Attribute25Value')
                ->setCellValue('AN1', 'Attribute26Name')
                ->setCellValue('AO1', 'Attribute26Value')
                ->setCellValue('AP1', 'Attribute10Name')
                ->setCellValue('AQ1', 'Attribute10Value')
                ->setCellValue('AR1', 'Attribute11Name')
                ->setCellValue('AS1', 'Attribute11Value')
                ->setCellValue('AT1', 'Attribute12Name')
                ->setCellValue('AU1', 'Attribute12Value')
                ->setCellValue('AV1', 'Attribute13Name')
                ->setCellValue('AW1', 'Attribute13Value')
                ->setCellValue('AX1', 'Attribute14Name')
                ->setCellValue('AY1', 'Attribute14Value')
                ->setCellValue('AZ1', 'Attribute15Name')
                ->setCellValue('BA1', 'Attribute15Value')
                ->setCellValue('BB1', 'Attribute16Name')
                ->setCellValue('BC1', 'Attribute16Value')
                ->setCellValue('BD1', 'Attribute17Name')
                ->setCellValue('BE1', 'Attribute17Value')
                ->setCellValue('BF1', 'Attribute18Name')
                ->setCellValue('BG1', 'Attribute18Value')
                ->setCellValue('BH1', 'Attribute19Name')
                ->setCellValue('BI1', 'Attribute19Value')
                ->setCellValue('BJ1', 'Attribute20Name')
                ->setCellValue('BK1', 'Attribute20Value')
                ->setCellValue('BL1', 'Attribute21Name')
                ->setCellValue('BM1', 'Attribute21Value')
                ->setCellValue('BN1', 'Attribute22Name')
                ->setCellValue('BO1', 'Attribute22Value')
                ->setCellValue('BP1', 'Attribute23Name')
                ->setCellValue('BQ1', 'Attribute23Value')
                ->setCellValue('BR1', 'Attribute24Name')
                ->setCellValue('BS1', 'Attribute24Value')
                ->setCellValue('BT1', 'Size');




        $objPHPExcel->getActiveSheet()->getStyle('A1:BT1')->getFont()->setBold(true);


        $objPHPExcel->getActiveSheet()->freezePane('A2');

        //  Rows to repeat at top

        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


        for ($i = 2; $i <= $repeat + 1; $i++) {

            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, $totalsku[$i - 2][1]['name'])
                    ->setCellValue('C' . $i, 'ABSOLUTE')
                    ->setCellValue('D' . $i, '')
                    ->setCellValue('E' . $i, '0.99')
                    ->setCellValue('F' . $i, $totalsku[$i - 2][1]['name'])
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['descr'])
                    ->setCellValue('H' . $i, $totalsku[$i - 2][7])
                    ->setCellValue('N' . $i, 'eBay : BIN FreeShip - JewelryAuctionsTV');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $i, 'BIN' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '')
                    ->setCellValue('P' . $i, 'eBay Stores GTC');
            if ($totalsku[$i - 2][2][0]['name'] == 'Diamond') {
                if ('BIN' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '' == "BIN Silver Diamond Rings") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164342');
                }
                if ('BIN' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '' == "BIN Silver Diamond Earrings") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164320');
                }
                if ('BIN' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '' == "BIN Silver Diamond Bracelets") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164314');
                }
                if ('BIN' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '' == "BIN Diamond Bracelets") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164314');
                }
            } else {
                if ('BIN Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "BIN Gemstone Rings") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164343');
                }
                if ('BIN Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "BIN Gemstone Pendants") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164332');
                }
                if ('BIN Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "BIN Gemstone Necklaces") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164332');
                }
                if ('BIN Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "BIN Gemstone Earrings") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164321');
                }
                if ('BIN Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "BIN Gemstone Bracelets ") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164315');
                }
                if ('Auction Gemstone' . $totalsku[$i - 2][1]['type'] . '' == "Auction Gemstone Rings ") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, '164343');
                }
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $i, 'eBay Category List');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $i, '' . $totalsku[$i - 2][1]['type'] . ' > ' . $totalsku[$i - 2][4] . ' ' . $totalsku[$i - 2][2][0]['name'] . '' . $totalsku[$i - 2][1]['type'] . '')
                    ->setCellValue('S' . $i, $totalsku[$i - 2][1]['type'] . '-' . $totalsku[$i - 2][4])
                    ->setCellValue('T' . $i, 'Item')
                    ->setCellValue('U' . $i, $totalsku[$i - 2][1]['type'])
                    ->setCellValue('V' . $i, 'Metal Type')
                    ->setCellValue('W' . $i, $totalsku[$i - 2][4]);
            if ($totalsku[$i - 2][1]['type'] == 'Ring') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, 'Size');
                $objPHPExcel->setActiveSheetIndex()->setCellValue('Y' . $i, $totalsku[$i - 2][1]['sizelowrange']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Z' . $i, 'Gem1')
                    ->setCellValue('AA' . $i, $totalsku[$i - 2][2][0]['name'])
                    ->setCellValue('AB' . $i, 'Gem1Specs1');
            if (isset($totalsku[$i - 2][2][0]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AC' . $i, $totalsku[$i - 2][2][0]['shape']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AD' . $i, 'Gem2');
            if (isset($totalsku[$i - 2][2][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AE' . $i, $totalsku[$i - 2][2][1]['name']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AF' . $i, 'Gem2Specs1');
            if (isset($totalsku[$i - 2][2][1]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AG' . $i, $totalsku[$i - 2][2][1]['shape']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AH' . $i, 'Gem3');
            if (isset($totalsku[$i - 2][2][2]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AI' . $i, $totalsku[$i - 2][2][2]['name']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ' . $i, 'Gem3Specs1');
            if (isset($totalsku[$i - 2][2][2]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AK' . $i, $totalsku[$i - 2][2][2]['shape']);
            }
            if ($totalsku[$i - 2][2][0]['name'] == "Diamond") {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AL' . $i, 'Diamond1 Clarity')
                        ->setCellValue('AM' . $i, $totalsku[$i - 2][2][0]['clarity'])
                        ->setCellValue('AN' . $i, 'Diamond CTW')
                        ->setCellValue('AO' . $i, $totalsku[$i - 2][0]['totstowei']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AP' . $i, 'Gram Weight')
                    ->setCellValue('AQ' . $i, $totalsku[$i - 2][0]['grosswt'] . 'Grams')
                    ->setCellValue('AR' . $i, 'Plating')
                    ->setCellValue('AS' . $i, 'High Polish Finish');
            if ($totalsku[$i - 2][2][0]['name'] == "Diamond") {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, 'Diamond1 qty/ctw')
                        ->setCellValue('AW' . $i, $totalsku[$i - 2][2][0]['pieces'] . '/' . $totalsku[$i - 2][2][0]['name'])
                        ->setCellValue('AX' . $i, 'Diamond1 Shape')
                        ->setCellValue('AY' . $i, $totalsku[$i - 2][2][0]['shape'])
                        ->setCellValue('AZ' . $i, 'Diamond1 Treatment')
                        ->setCellValue('BA' . $i, $totalsku[$i - 2][2][0]['tmeth']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('BB' . $i, 'Main Stone')
                    ->setCellValue('BC' . $i, $totalsku[$i - 2][2][0]['name']);
            if (isset($totalsku[$i - 2][2][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BD' . $i, 'Accent Gemstone Type')
                        ->setCellValue('BE' . $i, $totalsku[$i - 2][2][1]['name']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('BF' . $i, 'Main Stone Color')
                    ->setCellValue('BG' . $i, $totalsku[$i - 2][2][0]['color'])
                    ->setCellValue('BH' . $i, 'Exact Carat Total Weight')
                    ->setCellValue('BI' . $i, $totalsku[$i - 2][0]['totstowei'])
                    ->setCellValue('BJ' . $i, 'Metal')
                    ->setCellValue('BK' . $i, $totalsku[$i - 2][4])
                    ->setCellValue('BL' . $i, 'Metal Purity')
                    ->setCellValue('BM' . $i, $totalsku[$i - 2][6])
                    ->setCellValue('BN' . $i, 'Main Stone Treatment')
                    ->setCellValue('BO' . $i, 'None');
            if ($totalsku[$i - 2][1]['type'] == "Ring") {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BP' . $i, 'Ring Size')
                        ->setCellValue('BQ' . $i, $totalsku[$i - 2][1]['sizelowrange']);
            }
            if ($totalsku[$i - 2][2][0]['name'] == "Gem") {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BR' . $i, 'Gem ctw')
                        ->setCellValue('BS' . $i, $totalsku[$i - 2][0]['totstowei']);
            }
            if (isset($totalsku[$i - 2][1]['size'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BT' . $i, $totalsku[$i - 2][1]['size']);
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="CA.xlsx"');
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


