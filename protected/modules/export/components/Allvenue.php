<?php

/**
 * 
 */
class Allvenue extends CController {

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
                $stones[] = array('pieces' => $skustone->pieces, 'setting' => $skustone->idsetting0->name, 'color' => $skustone->idstone0->color,
                    'clarity' => $skustone->idstone0->idclarity0->name, 'shape' => trim($skustone->idstone0->idshape0->name), 'size' => $skustone->idstone0->idstonesize0->size, 'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' =>$skustone->idstone0->idstonem0->treatmeth,'name' => $skustone->idstone0->namevar, 'weight' => $skustone->idstone0->weight, 'month' => $skustone->idstone0->month);
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


        //Venue : Amazon


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SKU')
                ->setCellValue('B1', 'Current Cost')
                ->setCellValue('C1', 'StandardProductID')
                ->setCellValue('D1', 'ProductIDType')
                ->setCellValue('E1', 'ProductName')
                ->setCellValue('F1', 'LaunchDate')
                ->setCellValue('G1', 'Brand')
                ->setCellValue('H1', 'Designer')
                ->setCellValue('I1', 'Manufacturer')
                ->setCellValue('J1', 'MfrModelNumber')
                ->setCellValue('K1', 'MerchantCatalogNumber')
                ->setCellValue('L1', 'Description')
                ->setCellValue('M1', 'ProductType')
                ->setCellValue('N1', 'Prop65')
                ->setCellValue('O1', 'ItemType')
                ->setCellValue('P1', 'UsedFor1')
                ->setCellValue('Q1', 'UsedFor2')
                ->setCellValue('R1', 'UsedFor3')
                ->setCellValue('S1', 'UsedFor4')
                ->setCellValue('T1', 'UsedFor5')
                ->setCellValue('U1', 'OtherItemAttribute1')
                ->setCellValue('V1', 'OtherItemAttribute2')
                ->setCellValue('W1', 'OtherItemAttribute3')
                ->setCellValue('X1', 'OtherItemAttribute4')
                ->setCellValue('Y1', 'OtherItemAttribute5')
                ->setCellValue('Z1', 'SubjectContent1')
                ->setCellValue('AA1', 'SubjectContent2')
                ->setCellValue('AB1', 'SubjectContent3')
                ->setCellValue('AC1', 'SubjectContent4')
                ->setCellValue('AD1', 'SubjectContent5')
                ->setCellValue('AE1', 'TargetAudience1')
                ->setCellValue('AF1', 'TargetAudience2')
                ->setCellValue('AG1', 'TargetAudience3')
                ->setCellValue('AH1', 'SearchTerms1')
                ->setCellValue('AI1', 'SearchTerms2')
                ->setCellValue('AJ1', 'SearchTerms3')
                ->setCellValue('AK1', 'SearchTerms4')
                ->setCellValue('AL1', 'SearchTerms5')
                ->setCellValue('AM1', 'PlatinumKeywords1')
                ->setCellValue('AN1', 'PlatinumKeywords2')
                ->setCellValue('AO1', 'PlatinumKeywords3')
                ->setCellValue('AP1', 'PlatinumKeywords4')
                ->setCellValue('AQ1', 'PlatinumKeywords5')
                ->setCellValue('AR1', 'Parentage')
                ->setCellValue('AS1', 'ParentSKU')
                ->setCellValue('AT1', 'RelationshipType')
                ->setCellValue('AU1', 'VariationTheme')
                ->setCellValue('AV1', 'MainImageURL')
                ->setCellValue('AW1', 'SwatchImageURL')
                ->setCellValue('AX1', 'OtherImageURL1')
                ->setCellValue('AY1', 'OtherImageURL2')
                ->setCellValue('AZ1', 'OtherImageURL3')
                ->setCellValue('BA1', 'OtherImageURL4')
                ->setCellValue('BB1', 'OtherImageURL5')
                ->setCellValue('BC1', 'OtherImageURL6')
                ->setCellValue('BD1', 'OtherImageURL7')
                ->setCellValue('BE1', 'OtherImageURL8')
                ->setCellValue('BF1', 'PackageWeightUnitOfMeasure')
                ->setCellValue('BG1', 'PackageWeight')
                ->setCellValue('BH1', 'ProductTaxCode')
                ->setCellValue('BI1', 'DimensionUnitOfMeasure')
                ->setCellValue('BJ1', 'Diameter')
                ->setCellValue('BK1', 'Height')
                ->setCellValue('BL1', 'Width')
                ->setCellValue('BM1', 'Length')
                ->setCellValue('BN1', 'TotalMetalWeight')
                ->setCellValue('BO1', 'MetalWeightUnitOfMeasure')
                ->setCellValue('BP1', 'TotalDiamondWeight')
                ->setCellValue('BQ1', 'TotalGemWeight')
                ->setCellValue('BR1', 'Material1')
                ->setCellValue('BS1', 'Material2')
                ->setCellValue('BT1', 'Material3')
                ->setCellValue('BU1', 'Material4')
                ->setCellValue('BV1', 'MetalType')
                ->setCellValue('BW1', 'MetalStamp')
                ->setCellValue('BX1', 'SettingType')
                ->setCellValue('BY1', 'NumberOfStones')
                ->setCellValue('BZ1', 'ClaspType')
                ->setCellValue('CA1', 'ChainType')
                ->setCellValue('CB1', 'RingSize')
                ->setCellValue('CC1', 'ReSizable')
                ->setCellValue('CD1', 'SizingLowerRange')
                ->setCellValue('CE1', 'SizingUpperRange')
                ->setCellValue('CF1', 'BackFinding')
                ->setCellValue('CG1', 'EstatePeriod')
                ->setCellValue('CH1', 'CertificateType1')
                ->setCellValue('CI1', 'CertificateNumber1')
                ->setCellValue('CJ1', 'CertificateType2')
                ->setCellValue('CK1', 'CertificateNumber2')
                ->setCellValue('CL1', 'CertificateType3')
                ->setCellValue('CM1', 'CertificateNumber3')
                ->setCellValue('CN1', 'CertificateType4')
                ->setCellValue('CO1', 'CertificateNumber4')
                ->setCellValue('CP1', 'CertificateType5')
                ->setCellValue('CQ1', 'CertificateNumber5')
                ->setCellValue('CR1', 'CertificateType6')
                ->setCellValue('CS1', 'CertificateNumber6')
                ->setCellValue('CT1', 'CertificateType7')
                ->setCellValue('CU1', 'CertificateNumber7')
                ->setCellValue('CV1', 'CertificateType8')
                ->setCellValue('CW1', 'CertificateNumber8')
                ->setCellValue('CX1', 'CertificateType9')
                ->setCellValue('CY1', 'CertificateNumber9')
                ->setCellValue('CZ1', 'GemType1')
                ->setCellValue('DA1', 'StoneCut1')
                ->setCellValue('DB1', 'StoneColor1')
                ->setCellValue('DC1', 'StoneClarity1')
                ->setCellValue('DD1', 'StoneShape1')
                ->setCellValue('DE1', 'StoneWeight1')
                ->setCellValue('DF1', 'StoneCreationMethod1')
                ->setCellValue('DG1', 'StoneTreatmentMethod1')
                ->setCellValue('DH1', 'LabCreated1')
                ->setCellValue('DI1', 'Inscription1')
                ->setCellValue('DJ1', 'StoneDepthPercentage1')
                ->setCellValue('DK1', 'StoneTablePercentage1')
                ->setCellValue('DL1', 'StoneSymmetry1')
                ->setCellValue('DM1', 'StonePolish1')
                ->setCellValue('DN1', 'StoneGirdle1')
                ->setCellValue('DO1', 'StoneCulet1')
                ->setCellValue('DP1', 'StoneFluorescence1')
                ->setCellValue('DQ1', 'GemType2')
                ->setCellValue('DR1', 'StoneCut2')
                ->setCellValue('DS1', 'StoneColor2')
                ->setCellValue('DT1', 'StoneClarity2')
                ->setCellValue('DU1', 'StoneShape2')
                ->setCellValue('DV1', 'StoneWeight2')
                ->setCellValue('DW1', 'StoneCreationMethod2')
                ->setCellValue('DX1', 'StoneTreatmentMethod2')
                ->setCellValue('DY1', 'LabCreated2')
                ->setCellValue('DZ1', 'Inscription2')
                ->setCellValue('EA1', 'StoneDepthPercentage2')
                ->setCellValue('EB1', 'StoneTablePercentage2')
                ->setCellValue('EC1', 'StoneSymmetry2')
                ->setCellValue('ED1', 'StonePolish2')
                ->setCellValue('EE1', 'StoneGirdle2')
                ->setCellValue('EF1', 'StoneCulet2')
                ->setCellValue('EG1', 'StoneFluorescence2')
                ->setCellValue('EH1', 'GemType3')
                ->setCellValue('EI1', 'StoneCut3')
                ->setCellValue('EJ1', 'StoneColor3')
                ->setCellValue('EK1', 'StoneClarity3')
                ->setCellValue('EL1', 'StoneShape3')
                ->setCellValue('EM1', 'StoneWeight3')
                ->setCellValue('EN1', 'StoneCreationMethod3')
                ->setCellValue('EO1', 'StoneTreatmentMethod3')
                ->setCellValue('EP1', 'LabCreated3')
                ->setCellValue('EQ1', 'Inscription3')
                ->setCellValue('ER1', 'StoneDepthPercentage3')
                ->setCellValue('ES1', 'StoneTablePercentage3')
                ->setCellValue('ET1', 'StoneSymmetry3')
                ->setCellValue('EU1', 'StonePolish3')
                ->setCellValue('EV1', 'StoneGirdle3')
                ->setCellValue('EW1', 'StoneCulet3')
                ->setCellValue('EX1', 'StoneFluorescence3')
                ->setCellValue('EY1', 'PearlType')
                ->setCellValue('EZ1', 'PearlMinimumColor')
                ->setCellValue('FA1', 'PearlLustre')
                ->setCellValue('FB1', 'PearlShape')
                ->setCellValue('FC1', 'PearlUniformity')
                ->setCellValue('FD1', 'PearlSurfaceMarkingsAndBlemishes')
                ->setCellValue('FE1', 'PearlStringingMethod')
                ->setCellValue('FF1', 'SizePerPearl')
                ->setCellValue('FG1', 'NumberOfPearls')
                ->setCellValue('FH1', 'MSRP')
                ->setCellValue('FI1', 'ItemPrice')
                ->setCellValue('FJ1', 'SalesPrice')
                ->setCellValue('FK1', 'Currency')
                ->setCellValue('FL1', 'FulfillmentCenterID')
                ->setCellValue('FM1', 'SaleStartDate')
                ->setCellValue('FN1', 'SaleEndDate')
                ->setCellValue('FO1', 'Quantity')
                ->setCellValue('FP1', 'ReleaseDate')
                ->setCellValue('FQ1', 'leadtime-to-ship')
                ->setCellValue('FR1', 'RestockDate')
                ->setCellValue('FS1', 'MaxAggregateShipQuantity')
                ->setCellValue('FT1', 'IsGiftMessageAvailable')
                ->setCellValue('FU1', 'IsGiftWrapAvailable')
                ->setCellValue('FV1', 'IsDiscontinuedByManufacturer')
                ->setCellValue('FW1', 'registered-parameter')
                ->setCellValue('FX1', 'update-delete')
                ->setCellValue('FY1', 'Size');




        $objPHPExcel->getActiveSheet()->getStyle('A1:FY1')->getFont()->setBold(true);


        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top

        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


        for ($i = 2; $i <= $repeat + 1; $i++) {

            $usedfor = explode(",", $totalsku[$i - 2][1]['usedfor']);
            $othatt = explode(",", $totalsku[$i - 2][1]['attributedata']);
            $taruser = explode(",", $totalsku[$i - 2][1]['targetusers']);
            $srchtrm = explode(",", $totalsku[$i - 2][1]['searchterms']);


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, $totalsku[$i - 2][7])
                    ->setCellValue('E' . $i, $totalsku[$i - 2][1]['name'])
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['brand'])
                    ->setCellValue('M' . $i, $totalsku[$i - 2][1]['type'])
                    ->setCellValue('N' . $i, 'False')
                    ->setCellValue('O' . $i, $totalsku[$i - 2][1]['type']);
            if (isset($usedfor[0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $i, $usedfor[0]);
            }
            if (isset($usedfor[1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $i, $usedfor[1]);
            }
            if (isset($usedfor[2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $i, $usedfor[2]);
            }
            if (isset($usedfor[3])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $i, $usedfor[3]);
            }
            if (isset($usedfor[4])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T' . $i, $usedfor[4]);
            }
            if (isset($othatt[0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U' . $i, $othatt[0]);
            }
            if (isset($othatt[1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V' . $i, $othatt[1]);
            }
            if (isset($othatt[2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W' . $i, $othatt[2]);
            }
            if (isset($othatt[3])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X' . $i, $othatt[3]);
            }
            if (isset($othatt[4])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y' . $i, $othatt[4]);
            }
            if (isset($othatt[0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z' . $i, $othatt[0]);
            }
            if (isset($othatt[1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA' . $i, $othatt[1]);
            }
            if (isset($othatt[2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB' . $i, $othatt[2]);
            }
            if (isset($othatt[3])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC' . $i, $othatt[3]);
            }
            if (isset($othatt[4])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD' . $i, $othatt[4]);
            }
            if (isset($taruser[0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE' . $i, $taruser[0]);
            }
            if (isset($taruser[1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF' . $i, $taruser[1]);
            }
            if (isset($taruser[2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG' . $i, $taruser[2]);
            }
            if (isset($srchtrm[0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH' . $i, $srchtrm[0]);
            }
            if (isset($srchtrm[1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI' . $i, $srchtrm[1]);
            }
            if (isset($srchtrm[2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK' . $i, $srchtrm[2]);
            }
            if (isset($srchtrm[3])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL' . $i, $srchtrm[3]);
            }
            if ($totalsku[$i - 2][0]['parentsku'] != NULL) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR' . $i, 'Child');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS' . $i, $totalsku[$i - 2][0]['parentsku']);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR' . $i, 'Parent');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS' . $i, '');
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT' . $i, $totalsku[$i - 2][0]['parentrel']);
            if ($totalsku[$i - 2][1]['type'] == "Ring") {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU' . $i, 'RingSize');
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU' . $i, '');
            }
            if (isset($totalsku[$i - 2][3][0])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][0]);
            }
            if (isset($totalsku[$i - 2][3][1])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][1]);
            }
            if (isset($totalsku[$i - 2][3][2])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][2]);
            }
            if (isset($totalsku[$i - 2][3][3])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BA' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][3]);
            }
            if (isset($totalsku[$i - 2][3][4])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BB' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][4]);
            }
            if (isset($totalsku[$i - 2][3][5])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BC' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][5]);
            }
            if (isset($totalsku[$i - 2][3][6])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BD' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][6]);
            }
            if (isset($totalsku[$i - 2][3][7])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BE' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][7]);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH' . $i, 'A_Gen_NOTAX');
            if ($totalsku[$i - 2][0]['dimunit'] != '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI' . $i, $totalsku[$i - 2][0]['dimunit']);
            }
            if ($totalsku[$i - 2][0]['dimdia'] != '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI' . $i, $totalsku[$i - 2][0]['dimdia']);
            }
            if ($totalsku[$i - 2][0]['dimhei'] != '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BK' . $i, $totalsku[$i - 2][0]['dimhei']);
            }
            if ($totalsku[$i - 2][0]['dimwid'] != '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL' . $i, $totalsku[$i - 2][0]['dimwid']);
            }
            if ($totalsku[$i - 2][0]['dimlen'] != '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM' . $i, $totalsku[$i - 2][0]['dimlen']);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN' . $i, $totalsku[$i - 2][0]['totmetalwei'])
                    ->setCellValue('BO' . $i, 'GR')
                    ->setCellValue('BQ' . $i, $totalsku[$i - 2][0]['totstowei'])
                    ->setCellValue('BV' . $i, $totalsku[$i - 2][4])
                    ->setCellValue('BW' . $i, $totalsku[$i - 2][6])
                    // ->setCellValue('BX'. $i,  $totalsku[$i-2][2]['setting'])
                    ->setCellValue('BY' . $i, $totalsku[$i - 2][0]['numstones']);
            if (isset($totalsku[$i - 2][1]['clasptype'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BZ' . $i, $totalsku[$i - 2][1]['clasptype']);
            }
            if (isset($totalsku[$i - 2][1]['chaintype'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CA' . $i, $totalsku[$i - 2][1]['chaintype']);
            }
            if (isset($totalsku[$i - 2][1]['sizelowrange'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CB' . $i, $totalsku[$i - 2][1]['sizelowrange']);
            }
            if (isset($totalsku[$i - 2][1]['resizable'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CC' . $i, $totalsku[$i - 2][1]['resizable']);
            }
            if (isset($totalsku[$i - 2][1]['sizelowrange'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CD' . $i, $totalsku[$i - 2][1]['sizelowrange']);
            }
            if (isset($totalsku[$i - 2][1]['sizeupprange'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CE' . $i, $totalsku[$i - 2][1]['sizeupprange']);
            }
            if (isset($totalsku[$i - 2][1]['backfinding'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CF' . $i, $totalsku[$i - 2][1]['backfinding']);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ' . $i, $totalsku[$i - 2][2][0]['name'])
                    ->setCellValue('DB' . $i, $totalsku[$i - 2][2][0]['color']);
            if (isset($totalsku[$i - 2][2][0]['clarity'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DC' . $i, $totalsku[$i - 2][2][0]['clarity']);
            }
            if (isset($totalsku[$i - 2][2][0]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DD' . $i, $totalsku[$i - 2][2][0]['shape']);
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DE' . $i, $totalsku[$i - 2][2][0]['weight']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DF' . $i, $totalsku[$i - 2][2][0]['cmeth']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DG' . $i, $totalsku[$i - 2][2][0]['tmeth']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DH' . $i, 'false');
            if (isset($totalsku[$i - 2][2][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DQ' . $i, $totalsku[$i - 2][2][1]['name']);
            }
            if (isset($totalsku[$i - 2][2][1]['color'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DS' . $i, $totalsku[$i - 2][2][1]['color']);
            }
            if (isset($totalsku[$i - 2][2][1]['clarity'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DT' . $i, $totalsku[$i - 2][2][1]['clarity']);
            }
            if (isset($totalsku[$i - 2][2][1]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DU' . $i, $totalsku[$i - 2][2][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][1]['weight'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DV' . $i, $totalsku[$i - 2][2][1]['weight']);
            }
            if (isset($totalsku[$i - 2][2][1]['creatmeth'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DW' . $i, $totalsku[$i - 2][2][1]['cmeth']);
            }
            if (isset($totalsku[$i - 2][2][1]['treatmeth'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DX' . $i, $totalsku[$i - 2][2][1]['tmeth']);
            }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DY' . $i, 'false');
            if (isset($totalsku[$i - 2][2][2]['name'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EH' . $i, $totalsku[$i - 2][2][2]['name']);
            }
            if (isset($totalsku[$i - 2][2][2]['color'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EJ' . $i, $totalsku[$i - 2][2][2]['color']);
            }
            if (isset($totalsku[$i - 2][2][2]['clarity'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EK' . $i, $totalsku[$i - 2][2][2]['clarity']);
            }
            if (isset($totalsku[$i - 2][2][2]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EL' . $i, $totalsku[$i - 2][2][2]['shape']);
            }
            if (isset($totalsku[$i - 2][2][2]['weight'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EM' . $i, $totalsku[$i - 2][2][2]['weight']);
            }
            if (isset($totalsku[$i - 2][2][2]['creatmeth'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EN' . $i, $totalsku[$i - 2][2][2]['cmeth']);
            }
            if (isset($totalsku[$i - 2][2][2]['treatmeth'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EO' . $i, $totalsku[$i - 2][2][2]['tmeth']);
            }
            if (isset($totalsku[$i - 2][2]['size'])) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FY' . $i, $totalsku[$i - 2][1]['size']);
            }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EP' . $i, 'false');
        }





        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');



        // For creating a new sheet

        $objPHPExcel->createSheet();



        // Add some data
        //Venue : CA

        $objPHPExcel->setActiveSheetIndex(1)
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
                ->setCellValue('AL1', 'Attribute10Name')
                ->setCellValue('AM1', 'Attribute10Value')
                ->setCellValue('AN1', 'Attribute11Name')
                ->setCellValue('AO1', 'Attribute11Value')
                ->setCellValue('AP1', 'Attribute12Name')
                ->setCellValue('AQ1', 'Attribute12Value')
                ->setCellValue('AR1', 'Attribute13Name')
                ->setCellValue('AS1', 'Attribute13Value')
                ->setCellValue('AT1', 'Attribute14Name')
                ->setCellValue('AU1', 'Attribute14Value')
                ->setCellValue('AV1', 'Attribute15Name')
                ->setCellValue('AW1', 'Attribute15Value')
                ->setCellValue('AX1', 'Attribute16Name')
                ->setCellValue('AY1', 'Attribute16Value')
                ->setCellValue('AZ1', 'Attribute17Name')
                ->setCellValue('BA1', 'Attribute17Value')
                ->setCellValue('BB1', 'Attribute18Name')
                ->setCellValue('BC1', 'Attribute18Value')
                ->setCellValue('BD1', 'Attribute19Name')
                ->setCellValue('BE1', 'Attribute19Value')
                ->setCellValue('BF1', 'Attribute20Name')
                ->setCellValue('BG1', 'Attribute20Value')
                ->setCellValue('BH1', 'Attribute21Name')
                ->setCellValue('BI1', 'Attribute21Value')
                ->setCellValue('BJ1', 'Attribute22Name')
                ->setCellValue('BK1', 'Attribute22Value')
                ->setCellValue('BL1', 'Attribute23Name')
                ->setCellValue('BM1', 'Attribute23Value')
                ->setCellValue('BN1', 'Attribute24Name')
                ->setCellValue('BO1', 'Attribute24Value')
                ->setCellValue('BP1', 'Attribute25Name')
                ->setCellValue('BQ1', 'Attribute25Value')
                ->setCellValue('BR1', 'Attribute26Name')
                ->setCellValue('BS1', 'Attribute26Value')
                ->setCellValue('BT1', 'Size');




        $objPHPExcel->getActiveSheet()->getStyle('A1:BT1')->getFont()->setBold(true);


        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top

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
            if ($totalsku[$i - 2][2]['size']) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BT' . $i, $totalsku[$i - 2][1]['size']);
            }
        }




        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');


        // For creating a new sheet

        $objPHPExcel->createSheet();



        // Venue : JOV


        $objPHPExcel->setActiveSheetIndex(2)
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


            $objPHPExcel->setActiveSheetIndex(2)
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
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('Z' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][0]);
            }
            if (isset($totalsku[$i - 2][3][1])) {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AA' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][1]);
            }
            if (isset($totalsku[$i - 2][3][2])) {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AB' . $i, 'http://gjmis.com/' . $totalsku[$i - 2][3][2]);
            } {
                if (count($number[$i - 2]) == 3) {
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name'] . ',' . $totalsku[$i - 2][2][1]['name'] . ',' . $totalsku[$i - 2][2][2]['name']);
                } elseif (count($number[$i - 2]) == 2) {
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name'] . ',' . $totalsku[$i - 2][2][1]['name']);
                } else {
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AC' . $i, $totalsku[$i - 2][4] . ',' . $totalsku[$i - 2][2][0]['name']);
                }
            }
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AD' . $i, '0');
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('AE' . $i, 'JEWELRYAUCTIONSTV')
                    ->setCellValue('AF' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('AG' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('AH' . $i, 'N')
                    ->setCellValue('AK' . $i, '11021')
                    ->setCellValue('AL' . $i, $totalsku[$i - 2][1]['size']);
        }


        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        $objPHPExcel->createSheet();

        // For creating a new sheet
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




        $objPHPExcel->getActiveSheet()->getStyle('A1:AK1')->getFont()->setBold(true);



        $objPHPExcel->getActiveSheet()->freezePane('A2');

        // Rows to repeat at top

        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


        for ($i = 2; $i <= $repeat + 1; $i++) {

            $objPHPExcel->setActiveSheetIndex(3)
                    ->setCellValue('A' . $i, $totalsku[$i - 2][0]['skucode'])
                    ->setCellValue('B' . $i, ($totalsku[$i - 2][7] + ($totalsku[$i - 2][7] * 0.1)))
                    ->setCellValue('C' . $i, '')
                    ->setCellValue('D' . $i, $totalsku[$i - 2][4])
                    ->setCellValue('E' . $i, '')
                    ->setCellValue('F' . $i, $totalsku[$i - 2][0]['totmetalwei'])
                    ->setCellValue('G' . $i, $totalsku[$i - 2][1]['size'])
                    ->setCellValue('H' . $i, $totalsku[$i - 2][0]['grosswt']);
            if (isset($totalsku[$i - 2][2][0]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $i, $totalsku[$i - 2][2][0]['name']);
            }
            if (isset($totalsku[$i - 2][2][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $i, $totalsku[$i - 2][2][1]['name']);
            }
            if (isset($totalsku[$i - 2][2][2]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('K' . $i, $totalsku[$i - 2][2][2]['name']);
            }
            if (isset($totalsku[$i - 2][2][3]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('L' . $i, $totalsku[$i - 2][2][3]['name']);
            }
            if (isset($totalsku[$i - 2][2][4]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('M' . $i, $totalsku[$i - 2][2][4]['name']);
            }

            if (isset($totalsku[$i - 2][2][5]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('N' . $i, $totalsku[$i - 2][2][5]['name']);
            }
            if (isset($totalsku[$i - 2][2][6]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('O' . $i, $totalsku[$i - 2][2][6]['name']);
            }
            if (isset($totalsku[$i - 2][2][7]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('P' . $i, $totalsku[$i - 2][2][7]['name']);
            }
            if (isset($totalsku[$i - 2][2][8]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('Q' . $i, $totalsku[$i - 2][2][8]['name']);
            }
            if (isset($totalsku[$i - 2][2][9]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('R' . $i, $totalsku[$i - 2][2][9]['name']);
            }
            if (isset($totalsku[$i - 2][2][10]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('S' . $i, $totalsku[$i - 2][2][10]['name']);
            }
            if (isset($totalsku[$i - 2][2][11]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('T' . $i, $totalsku[$i - 2][2][11]['name']);
            }
            if (isset($totalsku[$i - 2][2][12]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('U' . $i, $totalsku[$i - 2][2][12]['name']);
            }
            if (isset($totalsku[$i - 2][2][13]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('V' . $i, $totalsku[$i - 2][2][13]['name']);
            }
            if (isset($totalsku[$i - 2][2][14]['name'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('W' . $i, $totalsku[$i - 2][2][14]['name']);
            }

            if (isset($totalsku[$i - 2][2][0]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('X' . $i, $totalsku[$i - 2][2][0]['shape']);
            }
            if (isset($totalsku[$i - 2][2][1]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AF' . $i, $totalsku[$i - 2][2][1]['shape']);
            }
            if (isset($totalsku[$i - 2][2][2]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AJ' . $i, $totalsku[$i - 2][2][2]['shape']);
            }
            if (isset($totalsku[$i - 2][2][3]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AN' . $i, $totalsku[$i - 2][2][3]['shape']);
            }
            if (isset($totalsku[$i - 2][2][4]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AR' . $i, $totalsku[$i - 2][2][4]['shape']);
            }
            if (isset($totalsku[$i - 2][2][5]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AV' . $i, $totalsku[$i - 2][2][5]['shape']);
            }
            if (isset($totalsku[$i - 2][2][6]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('AZ' . $i, $totalsku[$i - 2][2][6]['shape']);
            }
            if (isset($totalsku[$i - 2][2][7]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('BD' . $i, $totalsku[$i - 2][2][7]['shape']);
            }
            if (isset($totalsku[$i - 2][2][8]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BH' . $i, $totalsku[$i - 2][2][8]['shape']);
            }
            if (isset($totalsku[$i - 2][2][9]['shape'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('BL' . $i, $totalsku[$i - 2][2][9]['shape']);
            }
            if (isset($totalsku[$i - 2][2][10]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('BP' . $i, $totalsku[$i - 2][2][10]['shape']);
            }
            if (isset($totalsku[$i - 2][2][11]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('BT' . $i, $totalsku[$i - 2][2][11]['shape']);
            }
            if (isset($totalsku[$i - 2][2][12]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('BX' . $i, $totalsku[$i - 2][2][12]['shape']);
            }
            if (isset($totalsku[$i - 2][2][13]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('CB' . $i, $totalsku[$i - 2][2][13]['shape']);
            }
            if (isset($totalsku[$i - 2][2][14]['shape'])) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('CF' . $i, $totalsku[$i - 2][2][14]['shape']);
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




        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');






        // Set active sheet index to the first sheet,
        // so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Venue Specific Sheet.xlsx"');
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        spl_autoload_register(array('YiiBase', 'autoload'));
  }

}

?>
