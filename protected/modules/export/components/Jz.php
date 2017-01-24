<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JZ
 *
 * @author maverick
 */
class JZ {
    /**
     * Export based on skuids
     */
    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();

        //$filepath = Yii::app()->getBasePath() . '/components/exports/JZ.xls';
        $filepath = Yii::app()->getBasePath() . '/components/JZ.xls';
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        
        $objPHPExcel->getProperties()->setCreator("JZ")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        
        for ($i = 3; $i < (($repeat) + 3); $i++) {
            $wts = $this->separateWts($totalsku[($i - 3)][13]);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i,  $i - 2)
                ->setCellValue('B' . $i,  $totalsku[($i - 3)][0]['skucode'])
                ->setCellValue('D' . $i,  $totalsku[($i - 3)][1]['type']);
            
            $t_metal = (strpos($totalsku[($i - 3)][4], 'Brass') !== false) ? "Brass" : $totalsku[($i - 3)][4];
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i,  $t_metal);
                    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i,  $totalsku[($i - 3)][6])
                ->setCellValue('G' . $i,  $totalsku[($i - 3)][18])
                ->setCellValue('H' . $i,  $totalsku[($i - 3)][0]['grosswt'] + $totalsku[($i - 3)][21])
                ->setCellValue('I' . $i,  $totalsku[($i - 3)][0]['totstowei'])
                ->setCellValue('J' . $i,  $wts['stones'])
                ->setCellValue('K' . $i,  $wts['diamond'])
                ->setCellValue('O' . $i, $totalsku[($i - 3)][20]);
            
            if ($totalsku[($i - 3)][1]['type'] == 'Ring') {
                $string = preg_replace('/#/', '', $totalsku[($i - 3)][1]['size']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $i, 'Size '.$string);
            }

            if ($totalsku[($i - 3)][1]['type'] === 'Pendant' || $totalsku[($i - 3)][1]['type'] === 'Necklace' || $totalsku[($i - 3)][1]['type'] === 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i,  $totalsku[($i - 3)][1]['clasptype']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i,  $totalsku[($i - 3)][1]['chaintype']);
            }

            if (isset($totalsku[($i - 3)][12][0])) {
                if (ComSpry::findaliases($totalsku[($i - 3)][12][0]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 3)][12][0]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    //echo "<pre>";print_r($deptAlias);die();
                    if ($totalsku[($i - 3)][1]['type'] === 'Pendant' || $totalsku[($i - 3)][1]['type'] === 'Necklace' || $totalsku[($i - 3)][1]['type'] === 'Set') {
                        
                        if($deptAlias['clasp_type'] == $totalsku[($i - 3)][1]['clasptype'] ){
                           $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i,$deptAlias['clasp_type']);
                        }

                        if($deptAlias['chain_type'] == $totalsku[($i - 3)][1]['chaintype'] ){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i,$deptAlias['chain_type']);
                        }

                    } elseif ($totalsku[($i - 3)][1]['type'] === 'Bangle' || $totalsku[($i - 3)][1]['type'] === 'Bracelet') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $i, ucwords(str_replace('-',' ',$deptAlias['clasp_type'])));
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i, ucwords(str_replace('-',' ',('no-chain-type'))));
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, ucwords(str_replace('-',' ',($deptAlias['back_finding']))));
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, ucwords(str_replace('-',' ',($totalsku[($i - 3)][1]['backfinding']))));
                }
            }
            
            if(isset($totalsku[($i - 3)][2][0]) && !empty($totalsku[($i - 3)][2][0])){
                $column_array = ['P' . $i, 'Q' . $i, 'R' . $i, 'S' . $i, 'T' . $i, 'U' . $i, 'V' . $i, 'W' . $i, 'X' . $i, 'Y' . $i, 'Z' . $i, 'AA' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][0], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][1]) && !empty($totalsku[($i - 3)][2][1])){
                $column_array = ['AB' . $i, 'AC' . $i, 'AD' . $i, 'AE' . $i, 'AF' . $i, 'AG' . $i, 'AH' . $i, 'AI' . $i, 'AJ' . $i, 'AK' . $i, 'AL' . $i, 'AM' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][1], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][2]) && !empty($totalsku[($i - 3)][2][2])){
                $column_array = ['AN' . $i, 'AO' . $i, 'AP' . $i, 'AQ' . $i, 'AR' . $i, 'AS' . $i, 'AT' . $i, 'AU' . $i, 'AV' . $i, 'AW' . $i, 'AX' . $i, 'AY' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][2], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][3]) && !empty($totalsku[($i - 3)][2][3])){
                $column_array = ['AZ' . $i, 'BA' . $i, 'BB' . $i, 'BC' . $i, 'BD' . $i, 'BE' . $i, 'BF' . $i, 'BG' . $i, 'BH' . $i, 'BI' . $i, 'BJ' . $i, 'BK' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][3], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][4]) && !empty($totalsku[($i - 3)][2][4])){
                $column_array = ['BL' . $i, 'BM' . $i, 'BN' . $i, 'BO' . $i, 'BP' . $i, 'BQ' . $i, 'BR' . $i, 'BS' . $i, 'BT' . $i, 'BU' . $i, 'BV' . $i, 'BW' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][4], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][5]) && !empty($totalsku[($i - 3)][2][5])){
                $column_array = ['BX' . $i, 'BY' . $i, 'BZ' . $i, 'CA' . $i, 'CB' . $i, 'CC' . $i, 'CD' . $i, 'CE' . $i, 'CF' . $i, 'CG' . $i, 'CH' . $i, 'CI' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][5], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][6]) && !empty($totalsku[($i - 3)][2][6])){
                $column_array = ['CJ' . $i, 'CK' . $i, 'CL' . $i, 'CM' . $i, 'CN' . $i, 'CO' . $i, 'CP' . $i, 'CQ' . $i, 'CR' . $i, 'CS' . $i, 'CT' . $i, 'CU' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][6], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][7]) && !empty($totalsku[($i - 3)][2][7])){
                $column_array = ['CV' . $i, 'CW' . $i, 'CX' . $i, 'CY' . $i, 'CZ' . $i, 'DA' . $i, 'DB' . $i, 'DC' . $i, 'DD' . $i, 'DE' . $i, 'DF' . $i, 'DG' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][7], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][8]) && !empty($totalsku[($i - 3)][2][8])){
                $column_array = ['DH' . $i, 'DI' . $i, 'DJ' . $i, 'DK' . $i, 'DL' . $i, 'DM' . $i, 'DN' . $i, 'DO' . $i, 'DP' . $i, 'DQ' . $i, 'DR' . $i, 'DS' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][8], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][9]) && !empty($totalsku[($i - 3)][2][9])){
                $column_array = ['DT' . $i, 'DU' . $i, 'DV' . $i, 'DW' . $i, 'DX' . $i, 'DY' . $i, 'DZ' . $i, 'EA' . $i, 'EB' . $i, 'EC' . $i, 'ED' . $i, 'EE' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][9], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][10]) && !empty($totalsku[($i - 3)][2][10])){
                $column_array = ['EF' . $i, 'EG' . $i, 'EH' . $i, 'EI' . $i, 'EJ' . $i, 'EK' . $i, 'EL' . $i, 'EM' . $i, 'EN' . $i, 'EO' . $i, 'EP' . $i, 'EQ' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][10], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][11]) && !empty($totalsku[($i - 3)][2][11])){
                $column_array = ['ER' . $i, 'ES' . $i, 'ET' . $i, 'EU' . $i, 'EV' . $i, 'EW' . $i, 'EX' . $i, 'EY' . $i, 'EZ' . $i, 'FA' . $i, 'FB' . $i, 'FC' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][11], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][12]) && !empty($totalsku[($i - 3)][2][12])){
                $column_array = ['FD' . $i, 'FE' . $i, 'FF' . $i, 'FG' . $i, 'FH' . $i, 'FI' . $i, 'FJ' . $i, 'FK' . $i, 'FL' . $i, 'FM' . $i, 'FN' . $i, 'FO' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][12], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][13]) && !empty($totalsku[($i - 3)][2][13])){
                $column_array = ['FP' . $i, 'FQ' . $i, 'FR' . $i, 'FS' . $i, 'FT' . $i, 'FU' . $i, 'FV' . $i, 'FW' . $i, 'FX' . $i, 'FV' . $i, 'FZ' . $i, 'GA' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][13], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][14]) && !empty($totalsku[($i - 3)][2][14])){
                $column_array = ['GB' . $i, 'GC' . $i, 'GD' . $i, 'GE' . $i, 'GF' . $i, 'GG' . $i, 'GH' . $i, 'GI' . $i, 'GJ' . $i, 'GK' . $i, 'GL' . $i, 'GM' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][14], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][15]) && !empty($totalsku[($i - 3)][2][15])){
                $column_array = ['GN' . $i, 'GO' . $i, 'GP' . $i, 'GQ' . $i, 'GR' . $i, 'GS' . $i, 'GT' . $i, 'GU' . $i, 'GV' . $i, 'GW' . $i, 'GX' . $i, 'GY' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][15], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][16]) && !empty($totalsku[($i - 3)][2][16])){
                $column_array = ['GZ' . $i, 'HA' . $i, 'HB' . $i, 'HC' . $i, 'HD' . $i, 'HE' . $i, 'HF' . $i, 'HG' . $i, 'HH' . $i, 'HI' . $i, 'HJ' . $i, 'HK' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][16], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][17]) && !empty($totalsku[($i - 3)][2][17])){
                $column_array = ['HL' . $i, 'HM' . $i, 'HN' . $i, 'HO' . $i, 'HP' . $i, 'HQ' . $i, 'HR' . $i, 'HS' . $i, 'HT' . $i, 'HU' . $i, 'HV' . $i, 'HW' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][17], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][18]) && !empty($totalsku[($i - 3)][2][18])){
                $column_array = ['HX' . $i, 'HY' . $i, 'HZ' . $i, 'IA' . $i, 'IB' . $i, 'IC' . $i, 'ID' . $i, 'IE' . $i, 'IF' . $i, 'IG' . $i, 'IH' . $i, 'II' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][18], $column_array);
            }
            
            if(isset($totalsku[($i - 3)][2][19]) && !empty($totalsku[($i - 3)][2][19])){
                $column_array = ['IJ' . $i, 'IK' . $i, 'IL' . $i, 'IM' . $i, 'IN' . $i, 'IO' . $i, 'IP' . $i, 'IQ' . $i, 'IR' . $i, 'IS' . $i, 'IT' . $i, 'IU' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 3)][2][19], $column_array);
            }
            
           
            
            
            
        }
        
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        
        $objPHPExcel->getActiveSheet(0)->getStyle('A3:IU'.($repeat+2))->applyFromArray($styleArray);
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="JZ.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        spl_autoload_register(array('YiiBase', 'autoload'));
    }
    
    /**
     * Return filled excel sheet object
     */
    private function sendStonearray($excel, $stone, $column){
        $excel
            ->setCellValue($column[0], $stone['stonealias']);
        
        $aliases = ComSpry::findaliases($stone['shape'], 12);
        if(isset($aliases['alias']) && $aliases['alias']){
            $excel->setCellValue($column[1], $aliases['alias']);
        }else{
            $excel->setCellValue($column[1], $stone['shape']);
        }
        if(isset($aliases['deptAlias']) && $aliases['deptAlias']){
            $excel->setCellValue($column[2], ( $aliases['deptAlias'][0]->alias == 'Faceted' ) ? 'Ideal Cut' : $aliases['deptAlias'][0]->alias );
        }else{
            $excel->setCellValue($column[2], ($stone['cut'] == 'Faceted') ? 'Ideal Cut' : $stone['cut']);
        }

    if(stripos($stone['name'],'White') !== false){
            $clarity = $stone['clarity'];
        }else{
            $clarity = '';
        }

        
        $excel->setCellValue($column[3], $stone['size'])
            ->setCellValue($column[4], $stone['pieces'])
            ->setCellValue($column[5], number_format($stone['tot_weight'], 2, '.', ''))
            ->setCellValue($column[6], $stone['color'])
            ->setCellValue($column[7], $clarity)
            ->setCellValue($column[8], $stone['cmeth'])
            ->setCellValue($column[9], $stone['tmeth']);
        $excel->setCellValue($column[11], $stone['setting']);
        
        $tmethod = Aliases::model()->findbyattributes(array('aTarget' => '12', 'aField' => 'Treatment Method', 'initial' => $stone['name']));
        if(isset($tmethod)){
            $excel->setCellValue($column[10], $tmethod->alias);
        }else{
            $excel->setCellValue($column[10], '');
        }
        $excel;
    }
    
    /**
     * Create an array of all skus and their components
     */
    public function masterarray($ids){
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            $aliases = Aliases::model()->findAll();
            $depends = DependentAlias::model()->findAll();
            $skucontent = $sku->skucontent;
            $category = stripos($skucontent->type, 'Earring') !== false ? $skucontent->type : $skucontent->type.'s';
            $skustones = $sku->skustones;
        $skureviews = $sku->skureviews;
            $dimunit = $sku->dimunit == 'IN' ? 'inches' : $sku->dimunit;
            $stones = array();

            foreach ($skustones as $skustone) {
                $settingalias = Aliases::model()->findbyattributes(array('initial' => $skustone->idsetting0->name, 'aTarget' => 12, 'aField' => 'Setting'));
        $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $skustone->idstone0->namevar));
               
                $coloralias = Stonealias::model()->findByAttributes(array('export' => 9, 'idproperty' => 1,  'idstonem' => $skustone->idstone0->idstonem));
                $coloralias = isset($coloralias) ? $coloralias->alias : $skustone->idstone0->color;    
                
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' =>$skustone->idstone0->weight * $skustone->pieces,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'setting' => isset($settingalias) ? $settingalias->alias : $skustone->idsetting0->name,
                    'color' => $coloralias,
                    'clarity' => $skustone->idstone0->idclarity0['name'],
                    'shape' => trim($skustone->idstone0->idshape0->name),
                    'size' => $skustone->idstone0->idstonesize0->size,
                    'cmeth' => $skustone->idstone0->creatmeth,
                    'tmeth' => $skustone->idstone0->idstonem0->treatmeth,
                    'ppc' => $skustone->idstone0->curcost,
                    'pps' => (($skustone->idstone0->curcost) * ($skustone->idstone0->weight)),
                    'name' => $skustone->idstone0->namevar,
                    'weight' => $skustone->idstone0->weight,
                    'type' => $skustone->idstone0->idstonem0->type,
                    'mainstone' => $skustone->idstone0->idstonem0->name,
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month,
            'idstonem'=>$skustone->idstone0->idstonem,
                    'stonealias'=>isset($stone_alias_name) ? ucfirst($stone_alias_name->alias) : $skustone->idstone0->namevar,
                );
                
            }
            $stones[0]['flag'] = true;
            $newstones = Newstone::unqiuestones($stones);
        $reviews = '';
        foreach($skureviews as $skureview){
                $reviews .= $skureview->reviews;
            }
            
            $stonecode = $this->stoneDetails($stones,$reviews);
            
            $coloralias = Stonealias::model()->findByAttributes(array('export' => 9, 'idproperty' => 1,  'idstonem' => $sku->skustones[0]->idstone0->idstonem));
            $stonecolor = !empty($coloralias) ? $coloralias->alias : '';
            
            $skuimages = $sku->skuimages(array('type' => 'Gall'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }
            $skumetal = $sku->skumetals[0];
            
            if(stripos($skumetal->idmetal0->idmetalm0->name, 'Gold') !== false){
                $metal_name = 'Gold Market';
                $metal = $skumetal->idmetal0->namevar;
            }else if(stripos($skumetal->idmetal0->idmetalm0->name, 'Brass') !== false){
                $metal_name = 'Brass Market';
                $metal = $skumetal->idmetal0->idmetalm0->name;
            }else{
                $metal_name = 'Silver Market';
                $metal = str_ireplace("Silver","Sterling Silver", $skumetal->idmetal0->idmetalm0->name);
            }
            
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstampalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->idmetalstamp0->name, 'aTarget' => 12, 'aField' => 'Metal Stamp'));
            $metalstamp = isset($metalstampalias) ? $metalstampalias->alias : $skumetal->idmetal0->idmetalstamp0->name;
            
            $metalalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->namevar, 'aTarget' => 12, 'aField' => 'Metal'));
            $metal = isset($metalalias) ? $metalalias->alias : $skumetal->idmetal0->namevar;
            
            //$finishing = isset($metalalias->depaliases[0]) ? $metalalias->depaliases[0]->alias : '';
            $finishing='';
            $currentcost = $skumetal->idmetal0->currentcost;
            $finds = array();
            $findwt = 0;
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                );
                $findwt += $finding->idfinding0->weight;
            }
            
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
           
        $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category, $dimunit,$finishing, $stonecolor, $stonecode, $findwt);
        }
        return $totalsku;
    }
    
    private function separateWts($newstones){
        $diawt = 0;
        $stowt = 0;
        $wts = [];
        foreach($newstones as $newstone){
            if($newstone['type'] == 'diamond'){
                $diawt += $newstone['weight'];
            }else{
                $stowt += $newstone['weight'];
            }
        }
            
        $wts['diamond'] = ($diawt == 0) ? '' : $diawt;
        $wts['stones'] = ($stowt == 0) ? '' : $stowt;
        
        return $wts;
    }
    
    public function stoneDetails($stones,$reviews){
        $detail = '';
        $i = 0;
        foreach($stones as $stone){
            if($i != 0){
                $detail .= ' + ';
            }
            $detail .= $stone['stonealias'].' '.$stone['shape'].' '.$stone['size'].' - '.$stone['pieces'].'Pcs';
            $i++;
       
        }
        if(trim($reviews)){
            return $detail.' '.trim($reviews);
        }else{
            return $detail;
        }
    }
}
