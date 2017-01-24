<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Amazon extends CController {

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
        //include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel'. DIRECTORY_SEPARATOR . 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $filepath = Yii::app()->getBasePath() . '/components/AMZN_Datasheet.xls';
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        for ($i = 4; $i < (($repeat) + 4); $i++) {
            $styleThickBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    ),
                ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':IK' . $i)->applyFromArray($styleThickBlackBorderOutline);

            $costname = '';
            foreach ($totalsku[($i - 4)][8]['formula'] as $formula) {
                if (strpos($formula['name'], 'Gold Plating') !== false) {
                    $costname = str_replace('ing', 'ed', $formula['name']) . ' ';
                }
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $totalsku[($i - 4)][0]['skucode'])
                    ->setCellValue('C' . $i, 'Johareez');
            $value = '';
            $stonum = sizeof($totalsku[($i - 4)][2]);
            for ($k = 0; $k < $stonum; $k++) {
                if (strpos($value, $totalsku[($i - 4)][2][$k]['name'])) {
                    continue;
                } else {
                    $value = $value . " " . $totalsku[($i - 4)][2][$k]['name'];
                }
            }
            foreach ($totalsku[($i - 4)][16] as $cat) {
                if ($totalsku[($i - 4)][1]['type'] == $cat['category']) {
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('CI' . $i, $cat['package_length'])
                            ->setCellValue('CJ' . $i, $cat['package_height'])
                            ->setCellValue('CK' . $i, $cat['package_width'])
                            ->setCellValue('CL' . $i, $cat['dimension_unit']);
                }
            }
            $sizestone = sizeof($totalsku[($i - 4)][13]);
            $diamond = 0;$gems = 0; $we = 0;$stone_wt = 0; $diamond_wt = 0;
            $t_metal = (strpos($totalsku[($i - 4)][4], 'Brass') !== false) ? "Brass" : $totalsku[($i - 4)][4];
            $prepend = '';
            if(stripos($t_metal,'W/2Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Two Tone ';
            }else if(stripos($t_metal,'W/3Tone')){
                $t_metal = 'Sterling Silver';
                $prepend = 'Three Tone ';
            }

            for ($k = 0; $k < $sizestone; $k++) {
                $we+= $totalsku[($i - 4)][13][$k]['weight'];
                if ($totalsku[($i - 4)][13][$k]['type'] == 'diamond') {
                    $diamond_wt+= $totalsku[($i - 4)][13][$k]['weight'];
                    $diamond++;
                } else {
                    $stone_wt+= $totalsku[($i - 4)][13][$k]['weight'];
                    $gems++;
                }
                $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i - 4)][13][$k]['name']));
                $totalsku[($i - 4)][13][$k]['name'] = isset($stone_alias_name) ? ucfirst($stone_alias_name->alias) : $totalsku[($i - 4)][13][$k]['name'];

            }
           
            if ($diamond == 0 && $gems == 2) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 4)][13][1]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . ComSpry::findalias($totalsku[($i - 4)][13][1]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } elseif ($diamond == 1 && $gems == 1 || ($diamond >= 2 && $gems == 1)) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .' Carat Genuine ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' and Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } elseif ($diamond == 0 && $gems > 2) {
                
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][17][0]['weight'], 2, '.', '') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 4)][17][0]['weight']), 2, '.', '') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][17][0]['weight'], 2, '.', '') .
                                ' Carat ' . ComSpry::findalias($totalsku[($i - 4)][13][0]['name'], 1) . ' ' . $totalsku[($i - 4)][1]['type'] . ' with ' . number_format(($we - $totalsku[($i - 4)][17][0]['weight']), 2, '.', '') . ' ct. t.w. Multi-Gems in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } elseif ($gems >= 2 && $diamond != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($stone_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Gems ' . 'and ' . number_format($diamond_wt, 2, '.', '') . ' ct.t.w Genuine Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' and Diamond Accents ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } elseif ($diamond == 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . $totalsku[($i - 4)][13][1]['name'] . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' ct. t.w. ' . $totalsku[($i - 4)][13][0]['name'] . ' and ' . $totalsku[($i - 4)][13][1]['name'] . ' ' . $totalsku[($i - 4)][1]['type'] . ' in ' . ComSpry::findalias($t_metal, 1)))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } elseif ($diamond > 2 && $gems == 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Diamond '.ComSpry::findalias($t_metal, 1).' '.$totalsku[($i - 4)][1]['type']))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($diamond_wt, 2, '.', '') .
                                ' Carat Genuine Multi-Diamond '.ComSpry::findalias($t_metal, 1).' '.$totalsku[($i - 4)][1]['type']))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            } else {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][0]['totstowei'], 2, '.', '') .
                                ' Carat Genuine ' . $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('J' . $i, $prepend.$costname . (number_format($totalsku[($i - 4)][0]['totstowei'], 2, '.', '') .
                                ' Carat Genuine ' . $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']))
                    ->setCellValue('AP' . $i, $totalsku[($i - 4)][13][0]['name'] . ' ' . ComSpry::findalias($t_metal, 1) . ' ' . $totalsku[($i - 4)][1]['type']);
            }

            $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('CI' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('CJ' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('CK' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('K' . $i, 'update');
            $objPHPExcel->setActiveSheetIndex()
                    ->setCellValue('F' . $i, ComSpry::findaliases($totalsku[($i - 4)][1]['type'], 1)['alias']);
            if (!(ComSpry::findaliases($totalsku[($i - 4)][1]['type'], 1)['alias'])) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('F' . $i, $totalsku[($i - 4)][1]['type']);
            }
            $bullet = '18" Gold Chain Included';
            if (ComSpry::findaliases($totalsku[($i - 4)][1]['type'], 1)['deptAlias']) {
                $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][1]['type'], 1)['deptAlias'];
                foreach ($deptAliases as $value) {
                    $deptAlias[$value->column] = $value->alias;
                }
                $dim_unit = preg_replace('/ +/', "\r\n", $deptAlias['dimunit']);
                $dim_array = explode(' ', $deptAlias['dimunit']);
                $count_dim = count($dim_array);
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('AG' . $i, $totalsku[($i - 4)][18]['dimunit']);
                if ($count_dim > 1) {
                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
                }
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('E' . $i, $deptAlias['feed_product_type']);
                if ($totalsku[($i - 4)][1]['type'] === "Earrings") {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, $deptAlias['target_audience1']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, $deptAlias['target_audience2']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, $deptAlias['target_audience1']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AV' . $i, $deptAlias['target_audience2']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AW' . $i, $deptAlias['target_audience3']);
                }
                if (!empty($deptAlias['bullet_point4'])) {
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('AS' . $i, (strpos($totalsku[($i - 4)][4], 'Gold') !== false) ? $bullet : $deptAlias['bullet_point4']);
                }
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $i, $totalsku[($i - 4)][1]['type']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AU' . $i, $totalsku[($i - 4)][1]['targetusers']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $i, '0');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $i, 'USD');
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, 'A_Gen_NOTAX');
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AH' . $i, $totalsku[($i - 4)][18]['dimdia']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AI' . $i, $totalsku[($i - 4)][18]['dimhei']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ' . $i, $totalsku[($i - 4)][18]['dimwid']);
            
            if ($totalsku[($i - 4)][1]['type'] === 'Bracelet') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AK' . $i, $totalsku[($i - 4)][1]['size']);
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AK' . $i, $totalsku[($i - 4)][18]['dimlen']);
            }

            if ($totalsku[($i - 4)][1]['type'] == 'Pendant' || $totalsku[($i - 4)][1]['type'] == 'Necklace' || $totalsku[($i - 4)][1]['type'] == 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DO' . $i,  $totalsku[($i - 4)][1]['clasptype']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DP' . $i, $totalsku[($i - 4)][1]['chaintype']);
            }

            if (isset($totalsku[($i - 4)][12][0])) {       
                if (ComSpry::findaliases($totalsku[($i - 4)][12][0]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][12][0]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                   
                    if ($totalsku[($i - 4)][1]['type'] == 'Pendant' || $totalsku[($i - 4)][1]['type'] == 'Necklace' || $totalsku[($i - 4)][1]['type'] == 'Set') {
                        if($deptAlias['clasp_type'] == $totalsku[($i - 4)][1]['clasptype'] ){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('DO' . $i,$deptAlias['clasp_type']);
                        }

                        if($deptAlias['chain_type'] == $totalsku[($i - 4)][1]['chaintype'] ){
                            $objPHPExcel->setActiveSheetIndex()->setCellValue('DP' . $i,$deptAlias['chain_type']);
                        }

                    } elseif ($totalsku[($i - 4)][1]['type'] === 'Bangle' || $totalsku[($i - 4)][1]['type'] === 'Bracelet') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DO' . $i, ucwords(str_replace('-',' ',$deptAlias['clasp_type'])));
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DP' . $i,  ucwords(str_replace('-',' ',('no-chain-type'))));
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('IK' . $i, $deptAlias['back_finding']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('IK' . $i, $totalsku[($i - 4)][1]['backfinding']);
                }
            }

            if (isset($totalsku[($i - 4)][12][1])) {
                if (ComSpry::findaliases($totalsku[($i - 4)][12][1]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][12][1]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    if ($totalsku[($i - 4)][1]['type'] == 'Pendant'  || $totalsku[($i - 4)][1]['type'] == 'Necklace' || $totalsku[($i - 4)][1]['type'] == 'Set') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DO' . $i,  $totalsku[($i - 4)][1]['clasptype']);
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DP' . $i, $totalsku[($i - 4)][1]['chaintype']);
                    } elseif ($totalsku[($i - 4)][1]['type'] === 'Bangle' || $totalsku[($i - 4)][1]['type'] === 'Bracelet') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DO' . $i, ucwords(str_replace('-',' ',$deptAlias['clasp_type'])));
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('DP' . $i, ucwords(str_replace('-',' ',('no-chain-type'))));
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('IK' . $i, $deptAlias['back_finding']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('IK' . $i, $totalsku[($i - 4)][1]['backfinding']);
                }
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('CH' . $i, 'AMAZON_NA');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('CO' . $i, 'Child');

            if ($totalsku[($i - 4)][1]['type'] === 'Ring') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CQ' . $i, 'Variation');
                $objPHPExcel->setActiveSheetIndex()->setCellValue('CR' . $i, 'RingSize');
            } 
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('CP' . $i, ComSpry::findCode($totalsku[($i - 4)][0]['parentsku']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('CT' . $i, 'False');

            $chain_wt = 0;
            foreach ($totalsku[($i - 4)][12] as $finds) {
                if (strpos($finds['name'], 'Chain') !== false)
                    $chain_wt = $finds['weight'];
            }

            if ($totalsku[($i - 4)][1]['type'] === 'Pendant' || $totalsku[($i - 4)][1]['type'] === 'Set') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DA' . $i, ($totalsku[($i - 4)][0]['totmetalwei'] + $chain_wt));
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DA' . $i, $totalsku[($i - 4)][0]['totmetalwei']);
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('DB' . $i, 'GR');

            $we = array();
            $we1 = array();
            for ($k = 0; $k < $stonum; $k++) {
                if ($totalsku[($i - 4)][2][$k]['type'] == "diamond") {
                    $we[] = $totalsku[($i - 4)][2][$k]['weight'] * $totalsku[($i - 4)][2][$k]['pieces'];
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('DC' . $i, array_sum($we));
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('DD' . $i, 'CARATS');
                } elseif ($totalsku[($i - 4)][2][$k]['type'] !== "diamond") {
                    $we1[] = ($totalsku[($i - 4)][2][$k]['weight'] * $totalsku[($i - 4)][2][$k]['pieces']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('DE' . $i, array_sum($we1));
                }
            }
            if (empty($we1)) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DE' . $i, '0.00');
            }


            $stone_check = array();
            foreach ($totalsku[($i - 4)][2] as $stone) {
                $stone_check[] = $stone['type'];
            }
            $unique = array_unique($stone_check);
            if (count($unique) == 1) {
                if ($unique[0] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, '100% Genuine Diamond');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, '100% Genuine Gemstones');
                }
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ' . $i, '100% Genuine Gemstones');
            }

            $objPHPExcel->setActiveSheetIndex()->setCellValue('DF' . $i, 'CARATS');
            $objPHPExcel->setActiveSheetIndex()->setCellValue('DK' . $i, ComSpry::findaliases($totalsku[($i - 4)][4], 1)['alias']);
            if (!(ComSpry::findaliases($totalsku[($i - 4)][4], 1)['alias'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DK' . $i, $totalsku[($i - 4)][4]);
            }
            if (ComSpry::findaliases($totalsku[($i - 4)][4], 1)['deptAlias']) {
                $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][4], 1)['deptAlias'];
                foreach ($deptAliases as $value) {
                    $deptAlias[$value->column] = $value->alias;
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DL' . $i, $deptAlias['Metal Stamp']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AR' . $i, $deptAlias['bullet_point3']);
            } else {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DL' . $i, $totalsku[($i - 4)][6]);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('AR' . $i, $totalsku[($i - 4)][11]);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('DM' . $i, ComSpry::findaliases($totalsku[($i - 4)][2][0]['setting'], 1)['alias']);
            if (!(ComSpry::findaliases($totalsku[($i - 4)][2][0]['setting'], 1)['alias'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DM' . $i, $totalsku[($i - 4)][2][0]['setting']);
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('DN' . $i, $totalsku[($i - 4)][0]['numstones']);
            if ($totalsku[($i - 4)][1]['type'] == 'Ring') {
                $string = preg_replace('/#/', '', $totalsku[($i - 4)][1]['size']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DQ' . $i, $string);
            }
            if ($totalsku[($i - 4)][1]['type'] === 'Ring') {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('DR' . $i, 'false');
            }

            if (isset($totalsku[($i - 4)][17][0]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('EE' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][0]['name'], 1)['alias']);

                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][0]['name'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EE' . $i, $totalsku[($i - 4)][17][0]['name']);
                }

                if (ComSpry::findaliases($totalsku[($i - 4)][17][0]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][17][0]['name'], 1);
                    foreach ($deptAliases['deptAlias'] as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FD' . $i, $deptAlias['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FI' . $i, $deptAlias['tmeth']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FD' . $i, $totalsku[($i - 4)][17][0]['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FI' . $i, $totalsku[($i - 4)][17][0]['tmeth']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('EY' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][0]['shape'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][0]['shape'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EY' . $i, $totalsku[($i - 4)][17][0]['shape']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('GH' . $i, $totalsku[($i - 4)][17][0]['weight']);

                if ($totalsku[($i - 4)][17][0]['cmeth'] == 'Natural') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GV' . $i, 'false');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GV' . $i, 'true');
                }

                if (isset($totalsku[($i - 4)][17][0]['name']) && $totalsku[($i - 4)][17][0]['type'] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EO' . $i, ($totalsku[($i - 4)][17][0]['color'] == 'I-J')?$totalsku[($i - 4)][17][0]['color']:strtolower($totalsku[($i - 4)][17][0]['color']));
                    if ($totalsku[($i - 4)][17][0]['color'] == 'I-J') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('ET' . $i, 'I2-I3');
                    }
                }
            }

            if (isset($totalsku[($i - 4)][17][1]['name'])) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('EF' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][1]['name'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][1]['name'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('EF' . $i, $totalsku[($i - 4)][17][1]['name']);
                }
                if (ComSpry::findaliases($totalsku[($i - 4)][17][1]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][17][1]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('FE' . $i, $deptAlias['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('FJ' . $i, $deptAlias['tmeth']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()
                            ->setCellValue('FE' . $i, $totalsku[($i - 4)][17][1]['cmeth'])
                            ->setCellValue('FJ' . $i, $totalsku[($i - 4)][17][1]['tmeth']);
                }
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('EZ' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][1]['shape'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][1]['shape'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EZ' . $i, $totalsku[($i - 4)][17][1]['shape']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('GI' . $i, $totalsku[($i - 4)][17][1]['weight']);

                if ($totalsku[($i - 4)][17][1]['cmeth'] == 'Natural') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GW' . $i, 'false');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GW' . $i, 'true');
                }
                if (isset($totalsku[($i - 4)][17][1]['name']) && $totalsku[($i - 4)][17][1]['type'] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EP' . $i,($totalsku[($i - 4)][17][1]['color'] == 'I-J')?$totalsku[($i - 4)][17][1]['color']:strtolower($totalsku[($i - 4)][17][1]['color']));
                    if ($totalsku[($i - 4)][17][1]['color'] == 'I-J') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('EU' . $i, 'I2-I3');
                    }
                }
            }

           
            if (isset($totalsku[($i - 4)][17][2]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('EG' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][2]['name'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][2]['name'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EG' . $i, $totalsku[($i - 4)][17][2]['name']);
                }
                if (ComSpry::findaliases($totalsku[($i - 4)][17][2]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][17][2]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FF' . $i, $deptAlias['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FK' . $i, $deptAlias['tmeth']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FF' . $i, $totalsku[($i - 4)][17][2]['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FK' . $i, $totalsku[($i - 4)][17][2]['tmeth']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('FA' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][2]['shape'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][2]['shape'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FA' . $i, $totalsku[($i - 4)][17][2]['shape']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('GJ' . $i, $totalsku[($i - 4)][17][2]['weight']);
                if ($totalsku[($i - 4)][17][2]['cmeth'] == 'Natural') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GX' . $i, 'false');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GX' . $i, 'true');
                }

                if (isset($totalsku[($i - 4)][17][2]['name']) && $totalsku[($i - 4)][17][2]['type'] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EQ' . $i,($totalsku[($i - 4)][17][2]['color'] == 'I-J')?$totalsku[($i - 4)][17][2]['color']:strtolower($totalsku[($i - 4)][17][2]['color']));

                    if ($totalsku[($i - 4)][17][2]['color'] == 'I-J') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('EV' . $i, 'I2-I3');
                    }
                }
            }


            if (isset($totalsku[($i - 4)][17][3]['name'])) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('EH' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][3]['name'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][3]['name'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EG' . $i, $totalsku[($i - 4)][17][3]['name']);
                }
                if (ComSpry::findaliases($totalsku[($i - 4)][17][3]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][17][3]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FG' . $i, $deptAlias['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FL' . $i, $deptAlias['tmeth']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FG' . $i, $totalsku[($i - 4)][17][3]['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FL' . $i, $totalsku[($i - 4)][17][3]['tmeth']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('FB' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][3]['shape'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][3]['shape'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FB' . $i, $totalsku[($i - 4)][17][3]['shape']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('GK' . $i, $totalsku[($i - 4)][17][3]['weight']);

                if ($totalsku[($i - 4)][17][3]['cmeth'] == 'Natural') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GY' . $i, 'false');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GY' . $i, 'true');
                }

                if (isset($totalsku[($i - 4)][17][3]['name']) && $totalsku[($i - 4)][17][3]['type'] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('ER' . $i,($totalsku[($i - 4)][17][3]['color'] == 'I-J')?$totalsku[($i - 4)][17][3]['color']:strtolower($totalsku[($i - 4)][17][3]['color']));
                    if ($totalsku[($i - 4)][17][3]['color'] == 'I-J') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('EW' . $i, 'I2-I3');
                    }
                }
            }

            if (isset($totalsku[($i - 4)][17][4]['name'])) {
                $objPHPExcel->setActiveSheetIndex()
                        ->setCellValue('EI' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][4]['name'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][4]['name'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('EG' . $i, $totalsku[($i - 4)][17][4]['name']);
                }
                if (ComSpry::findaliases($totalsku[($i - 4)][17][4]['name'], 1)['deptAlias']) {
                    $deptAliases = ComSpry::findaliases($totalsku[($i - 4)][17][4]['name'], 1)['deptAlias'];
                    foreach ($deptAliases as $value) {
                        $deptAlias[$value->column] = $value->alias;
                    }
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FH' . $i, $deptAlias['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FM' . $i, $deptAlias['tmeth']);
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FH' . $i, $totalsku[($i - 4)][17][4]['cmeth']);
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FM' . $i, $totalsku[($i - 4)][17][4]['tmeth']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('FC' . $i, ComSpry::findaliases($totalsku[($i - 4)][17][4]['shape'], 1)['alias']);
                if (!(ComSpry::findaliases($totalsku[($i - 4)][17][4]['shape'], 1)['alias'])) {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('FC' . $i, $totalsku[($i - 4)][17][4]['shape']);
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('GL' . $i, $totalsku[($i - 4)][17][4]['weight']);

                if ($totalsku[($i - 4)][17][4]['cmeth'] == 'Natural') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GZ' . $i, 'false');
                } else {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('GZ' . $i, 'true');
                }
                if (isset($totalsku[($i - 4)][17][4]['name']) && $totalsku[($i - 4)][17][4]['type'] == 'diamond') {
                    $objPHPExcel->setActiveSheetIndex()->setCellValue('ES' . $i,($totalsku[($i - 4)][17][4]['color'] == 'I-J')?$totalsku[($i - 4)][17][4]['color']:strtolower($totalsku[($i - 4)][17][4]['color']));
                    if ($totalsku[($i - 4)][17][4]['color'] == 'I-J') {
                        $objPHPExcel->setActiveSheetIndex()->setCellValue('EX' . $i, 'I2-I3');
                    }
                }
            }
            
            $objPHPExcel->setActiveSheetIndex()->setCellValue('IJ' . $i, $totalsku[($i - 4)][19]);
            
            $objPHPExcel->setActiveSheetIndex()->getStyle('AI' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AJ' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('AK' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('DA' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('DC' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('DE' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
            $objPHPExcel->setActiveSheetIndex()->getStyle('GH' . $i . ':GL' . $i)->getNumberFormat()->setFormatCode('#,##0.#0');
        }
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="AMZN.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        //power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
    }

    public function masterarray($ids) {
        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            $aliases = Aliases::model()->findAll();
            $depends = DependentAlias::model()->findAll();
            $category = Category::model()->findAll();
            $dimensions = array('dimdia' => 0, 'dimhei' => 0, 'dimwid' => 0, 'dimlen' => 0, 'dimunit' => '');
            
            $skucontent = $sku->skucontent;
            if($skucontent->type && (($skucontent->type == 'Earrings') || ($skucontent->type == 'Ring')  || ($skucontent->type == 'Set'))){
                if($sku->dimunit == 'IN'){
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei * 25.4;
                    $dimensions['dimwid'] = $sku->dimwid * 25.4;
                    $dimensions['dimlen'] = $sku->dimlen * 25.4;
                    $dimensions['dimunit'] = 'MM';
                }else{
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei ;
                    $dimensions['dimwid'] = $sku->dimwid ;
                    $dimensions['dimlen'] = $sku->dimlen ;
                    $dimensions['dimunit'] = 'MM';
                }
            }else{
                if($sku->dimunit == 'MM'){
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei / 25.4;
                    $dimensions['dimwid'] = $sku->dimwid / 25.4;
                    $dimensions['dimlen'] = $sku->dimlen / 25.4;
                    $dimensions['dimunit'] = 'IN';
                }else{
                    $dimensions['dimdia'] = '';
                    $dimensions['dimhei'] = $sku->dimhei ;
                    $dimensions['dimwid'] = $sku->dimwid ;
                    $dimensions['dimlen'] = $sku->dimlen ;
                    $dimensions['dimunit'] = 'IN';
                }
            }
            $skustones = $sku->skustones;
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
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month
                );
            }
            
            if(isset($sku->skustones[0]->idstone0->idstone)){
                $coloralias = Stonealias::model()->findByAttributes(array('export' => 1,'idproperty' => 1,'idstonem' => $sku->skustones[0]->idstone0->idstonem));
                $stonecolor = !empty($coloralias) ? $coloralias->alias : $sku->skustones[0]->idstone0->color;
            }else{
                $stonecolor =  '';
            }
            
            $newstones = Newstone::unqiuestones($stones);
            $new_stone = $this->uniquestones($stones);
            
            
            $skuimages = $sku->skuimages(array('type' => 'Gall'));
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                $imageUrls[] = $skuimage->imageThumbUrl;
            }
            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metal_name = $skumetal->idmetal0->idmetalm0->name;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
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

            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones, $aliases, $depends, $category,$new_stone, $dimensions, $stonecolor);
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

?>
