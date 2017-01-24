<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QJC
 *
 * @author maverick
 */
class Qjc {
    
    /**
     * Export based on skuids
     */
    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
       // echo "<pre>";print_r($totalsku);die();
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();

        //$filepath = Yii::app()->getBasePath() . '/components/exports/QJC.xls';live
        $filepath = Yii::app()->getBasePath() . '/components/QJC.xls';
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        
        $objPHPExcel->getProperties()->setCreator("QJC")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        
        for ($i = 2; $i < (($repeat) + 2); $i++) {
        $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][2][0]['mainstone']));
        $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias :$totalsku[($i - 2)][2][0]['mainstone'];
            
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, 'Q' . $totalsku[($i - 2)][0]['skucode'])
                    ->setCellValue('B' . $i, $totalsku[($i - 2)][0]['skucode'])
                    ->setCellValue('D' . $i, $totalsku[($i - 2)][20]['dimwid'] .' MM')
                    ->setCellValue('E' . $i, $totalsku[($i - 2)][20]['dimhei'] .' MM');
            
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X' . $i, number_format($totalsku[($i - 2)][0]['totstowei'],2,'.',',') .' Carat');
            
            $chain_wt = 0;
            foreach ($totalsku[($i - 2)][12] as $finds) {
                if (strpos($finds['name'], 'Chain') != false)
                    $chain_wt = $finds['weight'];
            }
            if ($totalsku[($i - 2)][1]['type'] == 'Pendant' || $totalsku[($i - 2)][1]['type'] == 'Set') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('Y' . $i, number_format(($totalsku[($i - 2)][0]['grosswt'] + $chain_wt),2,'.',',') .' Grams');
            } else {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('Y' . $i, number_format($totalsku[($i - 2)][0]['grosswt'],2,'.',',') .' Grams');
            }
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH' . $i, $totalsku[($i - 2)][11])
                    ->setCellValue('BI' . $i, $totalsku[($i - 2)][16])
                    ->setCellValue('BJ' . $i, $stone_alias_name)
                    ->setCellValue('BK' . $i, $totalsku[($i - 2)][4])
                    ->setCellValue('BL' . $i, $totalsku[($i - 2)][1]['type'])
                    ->setCellValue('BM' . $i, $totalsku[($i - 2)][18]);
            
            $costname = '';
            foreach ($totalsku[($i - 2)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                }
            }
            $sizestone = sizeof($totalsku[($i - 2)][22]);
            $diamond = 0;
            $gems = 0;
            $we = 0;
            $stone_wt = 0;
            $diamond_wt = 0;
            $t_metal = (strpos($totalsku[($i - 2)][23], 'Brass') !== false) ? "Brass" : $totalsku[($i - 2)][23];
            
            $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }
            
            $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][22][0]['name']));
            $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 2)][22][0]['name'];
            
            
            {
                for ($k = 0; $k < $sizestone; $k++) {
                    $we+= $totalsku[($i - 2)][22][$k]['weight'];
                    if ($totalsku[($i - 2)][22][$k]['type'] == 'diamond') {
                        $diamond_wt+= $totalsku[($i - 2)][22][$k]['weight'];
                        $diamond++;
                    } else {
                        $stone_wt+= $totalsku[($i - 2)][22][$k]['weight'];
                        $gems++;
                    }
                    
                    $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 2)][22][$k]['name']));
                    $totalsku[($i - 2)][22][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i - 2)][22][$k]['name'];
                }
            }
            
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 2)][22][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 2)][22][1]['name'], 1) . ' ' . $totalsku[($i - 2)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)));
            } elseif ($diamond == 1 && $gems == 1 || ($diamond >= 2 && $gems == 1)) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 2)][22][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 2)][1]['type']));
            } elseif ($diamond == 0 && $gems > 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($totalsku[($i - 2)][21][0]['weight'], 2, '.', '') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 2)][22][0]['name'], 1) . ' ' . $totalsku[($i - 2)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 2)][21][0]['weight']), 2, '.', '') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($t_metal, 1)));
            } elseif ($gems >= 2 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 2)][1]['type']));
            } elseif ($diamond == 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 2)][22][0]['name'] . ' and ' . $totalsku[($i - 2)][22][1]['name'] . ' ' . $totalsku[($i - 2)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)));
            }elseif ($diamond > 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Diamond '.ComSpry::findalias($t_metal, 1).' '.$totalsku[($i - 2)][1]['type']));
                        
            }else{
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('Z' . $i, $prepend.$costname . (number_format($totalsku[($i - 2)][0]['totstowei'], 2, '.', '') .
                                ' Carat Genuine ' . $totalsku[($i - 2)][22][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 2)][1]['type']));
            }
            
            if($totalsku[($i - 2)][1]['type'] == 'Bracelet' || $totalsku[($i - 2)][1]['type'] == 'Bangle'){
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $totalsku[($i - 2)][20]['dimlen'] .' inches');
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $totalsku[($i - 2)][20]['dimlen'] .' MM');
            }
            
            if(isset($totalsku[($i - 2)][13][0]) && !empty($totalsku[($i - 2)][13][0])){
                $column_array = ['BN' . $i, 'BO' . $i, 'BP' . $i, 'BQ' . $i, 'BR' . $i, 'BS' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][0], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][1]) && !empty($totalsku[($i - 2)][13][1])){
                $column_array = ['BT' . $i, 'BU' . $i, 'BV' . $i, 'BW' . $i, 'BX' . $i, 'BY' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][1], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][2]) && !empty($totalsku[($i - 2)][13][2])){
                $column_array = ['BZ' . $i, 'CA' . $i, 'CB' . $i, 'CC' . $i, 'CD' . $i, 'CE' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][2], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][3]) && !empty($totalsku[($i - 2)][13][3])){
                $column_array = ['CF' . $i, 'CG' . $i, 'CH' . $i, 'CI' . $i, 'CJ' . $i, 'CK' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][3], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][4]) && !empty($totalsku[($i - 2)][13][4])){
                $column_array = ['CL' . $i, 'CM' . $i, 'CN' . $i, 'CO' . $i, 'CP' . $i, 'CQ' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][4], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][5]) && !empty($totalsku[($i - 2)][13][5])){
                $column_array = ['CR' . $i, 'CS' . $i, 'CT' . $i, 'CU' . $i, 'CV' . $i, 'CW' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][5], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][6]) && !empty($totalsku[($i - 2)][13][6])){
                $column_array = ['CX' . $i, 'CY' . $i, 'CZ' . $i, 'DA' . $i, 'DB' . $i, 'DC' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][6], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][7]) && !empty($totalsku[($i - 2)][13][7])){
                $column_array = ['DD' . $i, 'DE' . $i, 'DF' . $i, 'DG' . $i, 'DH' . $i, 'DI' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][7], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][8]) && !empty($totalsku[($i - 2)][13][8])){
                $column_array = ['DJ' . $i, 'DK' . $i, 'DL' . $i, 'DM' . $i, 'DN' . $i, 'DO' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][8], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][9]) && !empty($totalsku[($i - 2)][13][9])){
                $column_array = ['DP' . $i, 'DQ' . $i, 'DR' . $i, 'DS' . $i, 'DT' . $i, 'DU' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][9], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][10]) && !empty($totalsku[($i - 2)][13][10])){
                $column_array = ['DV' . $i, 'DW' . $i, 'DX' . $i, 'DY' . $i, 'DZ' . $i, 'EA' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][10], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][11]) && !empty($totalsku[($i - 2)][13][11])){
                $column_array = ['EB' . $i, 'EC' . $i, 'ED' . $i, 'EE' . $i, 'EF' . $i, 'EG' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][11], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][12]) && !empty($totalsku[($i - 2)][13][12])){
                $column_array = ['EH' . $i, 'EI' . $i, 'EJ' . $i, 'EK' . $i, 'EL' . $i, 'EM' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][12], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][13]) && !empty($totalsku[($i - 2)][13][13])){
                $column_array = ['EN' . $i, 'EO' . $i, 'EP' . $i, 'EQ' . $i, 'ER' . $i, 'ES' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][13], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][14]) && !empty($totalsku[($i - 2)][13][14])){
                $column_array = ['ET' . $i, 'EU' . $i, 'EV' . $i, 'EW' . $i, 'EX' . $i, 'EY' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][14], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][15]) && !empty($totalsku[($i - 2)][13][15])){
                $column_array = ['EZ' . $i, 'FA' . $i, 'FB' . $i, 'FC' . $i, 'FD' . $i, 'FE' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][15], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][16]) && !empty($totalsku[($i - 2)][13][16])){
                $column_array = ['FF' . $i, 'FG' . $i, 'FH' . $i, 'FI' . $i, 'FJ' . $i, 'FK' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][16], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][17]) && !empty($totalsku[($i - 2)][13][17])){
                $column_array = ['FL' . $i, 'FM' . $i, 'FN' . $i, 'FO' . $i, 'FP' . $i, 'FQ' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][17], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][18]) && !empty($totalsku[($i - 2)][13][18])){
                $column_array = ['FR' . $i, 'FS' . $i, 'FT' . $i, 'FU' . $i, 'FV' . $i, 'FW' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][18], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][19]) && !empty($totalsku[($i - 2)][13][19])){
                $column_array = ['FX' . $i, 'FY' . $i, 'FZ' . $i, 'GA' . $i, 'GB' . $i, 'GC' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][19], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][20]) && !empty($totalsku[($i - 2)][13][20])){
                $column_array = ['GD' . $i, 'GE' . $i, 'GF' . $i, 'GG' . $i, 'GH' . $i, 'GI' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][20], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][21]) && !empty($totalsku[($i - 2)][13][21])){
                $column_array = ['GJ' . $i, 'GK' . $i, 'GL' . $i, 'GM' . $i, 'GN' . $i, 'GO' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][21], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][22]) && !empty($totalsku[($i - 2)][13][22])){
                $column_array = ['GP' . $i, 'GQ' . $i, 'GR' . $i, 'GS' . $i, 'GT' . $i, 'GU' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][22], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][23]) && !empty($totalsku[($i - 2)][13][23])){
                $column_array = ['GV' . $i, 'GW' . $i, 'GX' . $i, 'GY' . $i, 'GZ' . $i, 'HA' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][23], $column_array);
            }
            
            if(isset($totalsku[($i - 2)][13][24]) && !empty($totalsku[($i - 2)][13][24])){
                $column_array = ['HB' . $i, 'HC' . $i, 'HD' . $i, 'HE' . $i, 'HF' . $i, 'HG' . $i];
                $this->sendStonearray($objPHPExcel->setActiveSheetIndex(0), $totalsku[($i - 2)][13][24], $column_array);
            }
            //hiiiii
           

            if ($totalsku[($i - 2)][1]['type'] == 'Pendant' || $totalsku[($i - 2)][1]['type'] == 'Necklace' || $totalsku[($i - 2)][1]['type'] == 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('HI' . $i, $totalsku[($i - 2)][1]['chaintype']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('HJ' . $i, $totalsku[($i - 2)][1]['clasptype']);
            }


            if (isset($totalsku[($i - 2)][12][0])) {
                if (ComSpry::findaliases($totalsku[($i - 2)][12][0]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 2)][12][0]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    
                    if ($totalsku[($i - 2)][1]['type'] === 'Pendant' || $totalsku[($i - 2)][1]['type'] == 'Necklace' || $totalsku[($i - 2)][1]['type'] == 'Set') {
                      
                        if($deptAlias['chain_type'] == $totalsku[($i - 2)][1]['chaintype']){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('HI' . $i, $deptAlias['chain_type']);
                        }
                        if($deptAlias['clasp_type'] == $totalsku[($i - 2)][1]['clasptype']){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('HJ' . $i, $deptAlias['clasp_type']);
                        }

                    } elseif ($totalsku[($i - 2)][1]['type'] === 'Bangle' || $totalsku[($i - 2)][1]['type'] === 'Bracelet') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('HJ' . $i, ucwords(str_replace('-',' ',$deptAlias['clasp_type'])));
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('HI' . $i, ucwords(str_replace('-',' ',('no-chain-type'))));
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('HH' . $i, $deptAlias['back_finding']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('HH' . $i, $totalsku[($i - 2)][1]['backfinding']);
                }
            }
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('HN' . $i, ComSpry::findaliases($totalsku[($i - 2)][2][0]['setting'], 1)['alias']);
            if (!(ComSpry::findaliases($totalsku[($i - 2)][2][0]['setting'], 1)['alias'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('HN' . $i, $totalsku[($i - 2)][2][0]['setting']);
            }
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('HK' . $i, $totalsku[($i - 2)][19])
                    ->setCellValue('HL' . $i, $totalsku[($i - 2)][24])
                    ->setCellValue('HM' . $i, $totalsku[($i - 2)][6]);
            
        }
        
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        
        $objPHPExcel->getActiveSheet(0)->getStyle('A1:HU'.($repeat+1))->applyFromArray($styleArray);
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="QJC.xlsx"');
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
        $stoneweight = number_format($stone['weight'],2,'.',',');
        
        $shape = str_replace( "S/C", 'Single Cut',$stone['shape']);
        $shape = str_replace("F/C", 'Full Cut', $shape);
        
        $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '11', 'aField' => 'Stone Name', 'initial' => $stone['name']));
        $stone_alias_name = isset($stone_alias_name) ? $stone_alias_name->alias :$stone['name'];
         
        $excel
            ->setCellValue($column[0], $stone_alias_name)
            ->setCellValue($column[1], $shape.'/'.$stone['size'])
            ->setCellValue($column[2], $stone['pieces'].'/'.$stoneweight.' ctw');
                
        if(stripos($stone['name'], 'Diamond') !== false){
            if(stripos($stone['name'], 'White') !== false){
                $excel->setCellValue($column[3], $stone['clarity']);
            }
            
            $excel   ->setCellValue($column[4], $stone['color'])
                ->setCellValue($column[5], $stoneweight);
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
            $dimensions = array('dimdia' => 0, 'dimhei' => 0, 'dimwid' => 0, 'dimlen' => 0, 'dimunit' => '');
            if($skucontent->type && (($skucontent->type == 'Bracelet') || ($skucontent->type == 'Bangle'))){
                if($sku->dimunit == 'IN'){
                    $dimensions['dimdia'] = number_format($sku->dimdia * 25.4,2, ".", '');
                    $dimensions['dimhei'] = number_format($sku->dimhei * 25.4,2, ".", '');
                    $dimensions['dimwid'] = number_format($sku->dimwid * 25.4,2, ".", '');
                    $dimensions['dimlen'] = number_format($sku->dimlen,2, ".", '') ;
                }else{
                    $dimensions['dimdia'] = number_format($sku->dimdia,2, ".", '') ;
                    $dimensions['dimhei'] = number_format($sku->dimhei,2, ".", '') ;
                    $dimensions['dimwid'] = number_format($sku->dimwid,2, ".", '') ;
                    $dimensions['dimlen'] = number_format($sku->dimlen / 25.4,2, ".", '');
                }
            }else{
                if($sku->dimunit == 'IN'){
                    $dimensions['dimdia'] = number_format($sku->dimdia * 25.4,2, ".", '');
                    $dimensions['dimhei'] = number_format($sku->dimhei * 25.4,2, ".", '');
                    $dimensions['dimwid'] = number_format($sku->dimwid * 25.4,2, ".", '');
                    $dimensions['dimlen'] = number_format($sku->dimlen * 25.4,2, ".", '');
                }else{
                    $dimensions['dimdia'] = number_format($sku->dimdia,2, ".", '') ;
                    $dimensions['dimhei'] = number_format($sku->dimhei,2, ".", '') ;
                    $dimensions['dimwid'] = number_format($sku->dimwid,2, ".", '') ;
                    $dimensions['dimlen'] = number_format($sku->dimlen,2, ".", '') ;
                }
            }
            
            $category = stripos($skucontent->type, 'Earring') !== false ? $skucontent->type : $skucontent->type.'s';
            $skustones = $sku->skustones;
            $dimunit = $sku->dimunit == 'IN' ? 'inches' : $sku->dimunit;
            $stones = array();

            foreach ($skustones as $skustone) {
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' => $sku->totstowei,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => $skustone->idsetting0->name,
                    'color' => $skustone->idstone0->color,
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
                );
            }
            $stones[0]['flag'] = true;
            $newstones = Newstone::qjcunqiuestones($stones);
            $new_stone = $this->uniquestones($stones);
            $allstones = Newstone::unqiuestones($stones);
           
            if(isset($sku->skustones[0]->idstone0->idstone)){
                $coloralias = Stonealias::model()->findByAttributes(array('export' => 8, 'idproperty' => 1,  'idstonem' => $sku->skustones[0]->idstone0->idstonem));
                $stonecolor = !empty($coloralias) ? $coloralias->alias : $sku->skustones[0]->idstone0->color;
            }else{
                $stonecolor =  '';
            }

        if(isset($sku->skustones[0]->idstone0->idstone)){
                $birthalias = Stonealias::model()->findByAttributes(array('export' => 8, 'idproperty' => 2,  'idstonem' => $sku->skustones[0]->idstone0->idstonem));
                $stonebirth = !empty($birthalias) ? $birthalias->alias : $sku->skustones[0]->idstone0->month;
            }else{
                $stonebirth =  '';
            }
            
            $skuimages = $sku->skuimages(array('type' => 'Gall'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }
            $skumetal = $sku->skumetals[0];
            
            if(stripos($skumetal->idmetal0->idmetalm0->name, 'Gold') !== false){
                $metal_name = 'Gold Market';
                $metal = $skumetal->idmetal0->idmetalm0->name;
            }else if(stripos($skumetal->idmetal0->idmetalm0->name, 'Brass') !== false){
                $metal_name = 'Brass Market';
                $metal = $skumetal->idmetal0->idmetalm0->name;
            }else{
                $metal_name = 'Silver Market';
                $metal = str_ireplace("Silver","Sterling Silver",$skumetal->idmetal0->idmetalm0->name);
            }
            
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->idmetalstamp0->name, 'aTarget' => 11, 'aField' => 'Metal Stamp'));
            $metalstamp = isset($metalalias) ? $metalalias->alias : $skumetal->idmetal0->idmetalstamp0->name;
            $main_metal = $skumetal->idmetal0->namevar;
            
            $finisingalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->namevar, 'aTarget' => 11, 'aField' => 'Finish'));
            $finishing = isset($finisingalias) ? $finisingalias->alias : $skumetal->idmetal0->namevar;
            
            $currentcost = $skumetal->idmetal0->currentcost;
            $finds = array();
            $findings = $sku->skufindings;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    'weight' => $finding->idfinding0->weight,
                );
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
            
        $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category, $dimunit,$finishing, $stonecolor, $dimensions, $new_stone, $allstones,$main_metal,$stonebirth);
        }
        return $totalsku;
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
