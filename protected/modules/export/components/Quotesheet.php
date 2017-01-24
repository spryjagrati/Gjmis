<?php

class Quotesheet extends CController {

    public function export($skuids, $client) {

        $ids = explode(",", $skuids);
        $repeat = count($ids);
        // get a reference to the path of PHPExcel classes
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

        $totalsku = array();
        $clientinfo = Client::model()->find('idclient=:idclient', array(':idclient' => trim($client)));
        $url = Yii::app()->request->getParam('type');

        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));

            if ($sku == NULL) {
                throw new CHttpException('Please check the entered values again.');
            }
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $skureviews = $sku->skureviews;
            $stones = array();
            $stonecost = 0;
            $stonenum = 0;
            $diamond_wt = 0;
            foreach ($skustones as $skustone) {
                $stonenum++;
                $stones[] = array('pieces' => $skustone->pieces, 'reviews' => $skustone->reviews, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    'month' => $skustone->idstone0->month, 
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight);
                $stonecost += ($skustone->idstone0->weight) * ($skustone->idstone0->curcost);

                if ($skustone->idstone0->idstonem0->type == "diamond") {
                    $diamond_wt += ($skustone->pieces * $skustone->idstone0->weight);
                }
            }
            
            $stone_wt = $this->processStones($stones);

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


            if (!is_null($id) && $id !== '' && $id !== 0) {

                $cost = ComSpry::calcSkuCost($id);
                $cost += (($clientinfo->commission) / 100) * $cost;
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
                );
            }

            
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $diamond_wt, $stone_wt,$reviews,$finds);
        }

       
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

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Image')
                ->setCellValue('B1', 'GJ#')
                ->setCellValue('C1', 'Category')
                ->setCellValue('D1', 'Gemstone(s) Description')
                ->setCellValue('E1', 'Gemstone(s)')
                ->setCellValue('F1', 'Product Remarks')
                ->setCellValue('G1', 'Metal')
                ->setCellValue('H1', 'Size')
                ->setCellValue('I1', 'Qty')
                ->setCellValue('J1', 'Gross Wt')
                ->setCellValue('K1', 'Gem Wt')
                ->setCellValue('L1', 'Dia Wt')
                ->setCellValue('M1', 'Metal Wt')
                ->setCellValue('N1', 'Price')
                ->setCellValue('O1', 'Amount')
                ->setCellValue('Q1', 'Emerald')
                ->setCellValue('R1', 'Ruby')
                ->setCellValue('S1', 'Sapphire')
                ->setCellValue('T1', 'Semi-Precious')
                ->setCellValue('U1', 'Diamond');


        $objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->freezePane('A2');
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);



        for ($i = 2; $i <= $repeat + 1; $i++) {
            $stonecount = '';
            $stonereview = '';
            $stonearray = array();
        foreach($totalsku[$i - 2][11] as $key => $value){
            if (trim($value != "")) {
                $stonereview .= $value. ', ';
            }
        }
        $dia=0;$gem=0;
        foreach ($totalsku[$i - 2][2] as $stone) {
            if ($stone['name'] != "") {
                $stonecount .=($stone['name'] . ' ' . $stone['shape'] . ' ' . $stone['size'] . ' - ' . $stone['pieces'] . 'Pcs + ');
                $stonearray[] = $stone['name'];
            }
            if(stripos($stone['name'], 'Diamond') !== false){
                $dia++;
            }else{
                $gem++;
            }
        }
         
        if($gem == 0 && $dia >= 1){
            $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('K' . $i, '');
        }else{
            if(($totalsku[$i - 2][0]['totstowei'] - $totalsku[$i - 2][9]) > .00001){
                $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('K' . $i, $totalsku[$i - 2][0]['totstowei'] - $totalsku[$i - 2][9]);
            }else{
                $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $i,'');
            }
           
        }


        $stonefinal = implode(",", array_unique($stonearray));
        $stonecount = substr_replace($stonecount, "", -2, -1);
        $stonereview = substr_replace($stonereview, "", -2, -1);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $i, $totalsku[$i - 2][0]['skucode']);

        $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $i, $totalsku[$i - 2][1]['type'])
                ->setCellValue('D' . $i, $stonecount)
                ->setCellValue('E' . $i, $stonefinal)
                ->setCellValue('F' . $i, $stonereview)
                ->setCellValue('G' . $i, $totalsku[$i - 2][4])
                ->setCellValue('H' . $i, $totalsku[$i - 2][1]['size'])
                ->setCellValue('I' . $i, '')
                ->setCellValue('J' . $i, $totalsku[$i - 2][0]['grosswt'])
                ->setCellValue('Q' . $i, $totalsku[$i - 2][10]['emrald'])
                ->setCellValue('R' . $i, $totalsku[$i - 2][10]['ruby'])
                ->setCellValue('S' . $i, $totalsku[$i - 2][10]['sapphire'])
                ->setCellValue('T' . $i, $totalsku[$i - 2][10]['semi'])
                ->setCellValue('U' . $i, $totalsku[$i - 2][10]['diamond']);
        if ($totalsku[$i - 2][9] !== 0) {
            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, $totalsku[$i - 2][9]);
        }


        $chain_wt = 0;
        if($totalsku[$i - 2][1]['type'] == 'Pendant' || $totalsku[$i - 2][1]['type'] == 'Set' ){
            foreach ($totalsku[$i - 2][12] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }
        }

        echo $totalsku[$i - 2][0]['totmetalwei'];echo "<br>";echo $chain_wt; echo "<br>";
        echo $totalsku[$i - 2][0]['totmetalwei']+$chain_wt; die();
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, $totalsku[$i - 2][0]['totmetalwei']+$chain_wt)
                ->setCellValue('N' . $i, $totalsku[$i - 2][8])
                ->setCellValue('O' . $i, '');
        if ($url=='master') {
            $objPHPExcel->getActiveSheet()->removeColumn('N');
        }
    }

        $styleThickBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleThickBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('Q1:U1')->applyFromArray($styleThickBorderOutline);

        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        for ($l = 2; $l <= $repeat + 1; $l++) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $l . ':O' . $l)->applyFromArray($styleThinBlackBorderOutline);
        }
        
        for ($l = 2; $l <= $repeat + 1; $l++) {
            $objPHPExcel->getActiveSheet()->getStyle('Q' . $l . ':U' . $l)->applyFromArray($styleThinBlackBorderOutline);
        }

        // for ($i = 2; $i <= $repeat+1; $i++) {
        //   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        //   $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(125);
        //   if(isset($totalsku[$i-2][3][0])){
        //   $objDrawing = new PHPExcel_Worksheet_Drawing();
        //   $objDrawing->setName('image');
        //   $objDrawing->setDescription('image');
        //   $objDrawing->setOffsetX(10);
        //   $objDrawing->setOffsetY(10);
        //   $objDrawing->setPath(Yii::app()->basePath . '/..' . $totalsku[$i-2][3][0]);
        //   $objDrawing->setCoordinates('A'.($i+0));
        //   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        //   }
        // }

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
        header('Content-Disposition: attachment;filename="Quote.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));


        Yii::app()->end();
    }
    
    public function processStones($stones){
        if($stones && is_array($stones)){
            $stone_wt = array('emrald' => '', 'ruby' => '', 'sapphire' => '', 'semi' => '', 'diamond' => '');
            foreach($stones as $stone){
                if(strpos($stone['name'], 'Emerald') != false){
                    $stone_wt['emrald'] += number_format($stone['weight']*$stone['pieces'], 2, '.', '');
                }else if(strpos($stone['name'], 'Ruby') != false){
                    $stone_wt['ruby'] += number_format($stone['weight']*$stone['pieces'], 2, '.', '');
                }else if(strpos($stone['name'], 'Sapphire') != false){
                    $stone_wt['sapphire'] += number_format($stone['weight']*$stone['pieces'], 2, '.', '');
                }else if(strpos($stone['name'], 'Diamond') != false){
                    $stone_wt['diamond'] += number_format($stone['weight']*$stone['pieces'], 2, '.', '');
                }else{
                    $stone_wt['semi'] += number_format($stone['weight']*$stone['pieces'], 2, '.', '');
                }
            }
            return $stone_wt;
        }
    }

}