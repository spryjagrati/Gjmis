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
                $stones[] = array('pieces' => $skustone->pieces, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    'clarity' => isset($skustone->idstone0->idclarity0->name) ? $skustone->idstone0->idclarity0->name : '', 'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    'type' => $skustone->type,'month' => $skustone->idstone0->month,'tmeth' => $skustone->idstone0->treatmeth, 'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight);
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
            $totcost = ComSpry::calcSkuCost($id);
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $newstones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $totcost);
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




        $objPHPExcel->getActiveSheet()->getStyle('A1:CI1')->getFont()->setBold(true);



        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top

        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


        for ($i = 2; $i <= $repeat + 1; $i++) {
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, ($totalsku[$i - 2][8] + (0.1 * $totalsku[$i - 2][8])))
                    ->setCellValue('C' . $i, '')
                    ->setCellValue('D' . $i, $totalsku[$i - 2][4])
                    ->setCellValue('E' . $i, '')
                    ->setCellValue('F' . $i, $totalsku[$i - 2][0]['totmetalwei'])
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['size'])
                    ->setCellValue('H' . $i, $totalsku[$i - 2][0]['grosswt']);
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


            if (isset($totalsku[$i - 2][2][0]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('X' . $i, $totalsku[$i - 2][2][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][1]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AF' . $i, $totalsku[$i - 2][2][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][2]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ' . $i, $totalsku[$i - 2][2][2]['shape']);
            }
            if (isset($totalsku[$i - 2][2][3]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AN' . $i, $totalsku[$i - 2][2][3]['shape']);
            }
            if (isset($totalsku[$i - 2][2][4]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AR' . $i, $totalsku[$i - 2][2][4]['shape']);
            }
            if (isset($totalsku[$i - 2][2][5]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, $totalsku[$i - 2][2][5]['shape']);
            }
            if (isset($totalsku[$i - 2][2][6]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AZ' . $i, $totalsku[$i - 2][2][6]['shape']);
            }
            if (isset($totalsku[$i - 2][2][7]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BD' . $i, $totalsku[$i - 2][2][7]['shape']);
            }
            if (isset($totalsku[$i - 2][2][8]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BH' . $i, $totalsku[$i - 2][2][8]['shape']);
            }
            if (isset($totalsku[$i - 2][2][9]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BL' . $i, $totalsku[$i - 2][2][9]['shape']);
            }
            if (isset($totalsku[$i - 2][2][10]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BP' . $i, $totalsku[$i - 2][2][10]['shape']);
            }
            if (isset($totalsku[$i - 2][2][11]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BT' . $i, $totalsku[$i - 2][2][11]['shape']);
            }
            if (isset($totalsku[$i - 2][2][12]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BX' . $i, $totalsku[$i - 2][2][12]['shape']);
            }
            if (isset($totalsku[$i - 2][2][13]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CB' . $i, $totalsku[$i - 2][2][13]['shape']);
            }
            if (isset($totalsku[$i - 2][2][14]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CF' . $i, $totalsku[$i - 2][2][14]['shape']);
            }


            if (!((isset($totalsku[$i - 2][2][0]['weight']) == NULL) && (isset($totalsku[$i - 2][2][0]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AB' . $i, ($totalsku[$i - 2][2][0]['weight']) . '/' . $totalsku[$i - 2][2][0]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][1]['weight']) == NULL) && (isset($totalsku[$i - 2][2][1]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AH' . $i, ($totalsku[$i - 2][2][1]['weight']) . '/' . $totalsku[$i - 2][2][1]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][2]['weight']) == NULL) && (isset($totalsku[$i - 2][2][2]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AL' . $i, ($totalsku[$i - 2][2][2]['weight']) . '/' . $totalsku[$i - 2][2][2]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][3]['weight']) == NULL) && (isset($totalsku[$i - 2][2][3]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AP' . $i, ($totalsku[$i - 2][2][3]['weight']) . '/' . $totalsku[$i - 2][2][3]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][4]['weight']) == NULL) && (isset($totalsku[$i - 2][2][4]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AT' . $i, ($totalsku[$i - 2][2][4]['weight']) . '/' . $totalsku[$i - 2][2][4]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][5]['weight']) == NULL) && (isset($totalsku[$i - 2][2][5]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AX' . $i, ($totalsku[$i - 2][2][5]['weight']) . '/' . $totalsku[$i - 2][2][5]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][6]['weight']) == NULL) && (isset($totalsku[$i - 2][2][6]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BB' . $i, ($totalsku[$i - 2][2][6]['weight']) . '/' . $totalsku[$i - 2][2][6]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][7]['weight']) == NULL) && (isset($totalsku[$i - 2][2][7]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BF' . $i, ($totalsku[$i - 2][2][7]['weight']) . '/' . $totalsku[$i - 2][2][7]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][8]['weight']) == NULL) && (isset($totalsku[$i - 2][2][8]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BJ' . $i, ($totalsku[$i - 2][2][8]['weight']) . '/' . $totalsku[$i - 2][2][8]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][9]['weight']) == NULL) && (isset($totalsku[$i - 2][2][9]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BN' . $i, ($totalsku[$i - 2][2][9]['weight']) . '/' . $totalsku[$i - 2][2][9]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][10]['weight']) == NULL) && (isset($totalsku[$i - 2][2][10]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BR' . $i, ($totalsku[$i - 2][2][10]['weight']) . '/' . $totalsku[$i - 2][2][10]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][11]['weight']) == NULL) && (isset($totalsku[$i - 2][2][11]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BV' . $i, ($totalsku[$i - 2][2][11]['weight']) . '/' . $totalsku[$i - 2][2][11]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][12]['weight']) == NULL) && (isset($totalsku[$i - 2][2][12]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BZ' . $i, ($totalsku[$i - 2][2][12]['weight']) . '/' . $totalsku[$i - 2][2][12]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][13]['weight']) == NULL) && (isset($totalsku[$i - 2][2][13]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CD' . $i, ($totalsku[$i - 2][2][13]['weight']) . '/' . $totalsku[$i - 2][2][13]['pieces']);
            }
            if (!((isset($totalsku[$i - 2][2][14]['weight']) == NULL) && (isset($totalsku[$i - 2][2][14]['pieces']) == NULL))) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CH' . $i, ($totalsku[$i - 2][2][14]['weight']) . '/' . $totalsku[$i - 2][2][14]['pieces']);
            }
        }



        // Rename sheet
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

    

}
