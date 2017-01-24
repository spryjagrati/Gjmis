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
class RS {

    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        
        $pathname = dirname(dirname(Yii::app()->basePath));
        $folderto = '/gjmis/images/temp/'.date('ymdhis');

        $metaltype = ['0'=>'METAL TYPE' , '1'=>'Sterling Silver','2'=>'Sterling Silver 14 KT gold plated', '3'=>'Sterling Silver 18 KT gold plated','4'=>'Sterling Silver 22 KT gold plated','5'=>'Sterling Silver 24 KT gold plated','6'=>'14K Gold','7'=>'18K Gold','8'=>'Platinum', '9'=>'Stainless Steel','10'=>'Base Metal','11'=>'MCRON FOR PLATING'];

        $metalcolor = ['0' => 'METAL COLOR','1'=>'Yellow','2'=>'White','3'=>'Two-Tone','4'=>'Rose','5'=>'Tri-Color'];
        $othercomponent = ['0'=>'OTHER COMPONENTS','1'=>'Leather','2'=>'Rubber','3'=>'Other (Specify) :'];
        $finish = ['0'=>'FINISH', '1'=>'Polish','2'=>'Rhodium','3'=>'Diamond Cut', '4'=>'Satin','5'=>'Antique','6'=>'Other (Specify) :'];
        $category = ['0'=> 'CHAINS/BRACELETS/NECKLACES/PENDANTS'];
        $cat_type = ['0'=> 'TYPE','1'=>'Box','2'=>'Rope','3'=>'Figaro' ,'4'=>'Wheat','5'=>'Rolo'];
        $cat_safety = ['0'=> 'SAFETY','1'=>'Safety Chain','2'=>'Figure 8','3'=>'Single Latch','4'=>'Ext. Bar','5'=>'Double Latch','6'=>'Other'];
        $cat_clasp = ['0'=> 'CLASP','1'=>'Springring','2'=>'Box','3'=>'Claw' ,'4'=>'Barrel ','5'=>'Lobster','6'=>'Other','7'=>'Toggle'];
        $cat_bale = ['0'=> 'BALE','1'=>'Single','2'=>'Hinged','3'=>'Double','4'=>'None','5'=>'Fixed ','6'=>'Other'];
        $earingtype = ['0'=>'EARRINGS','1'=>'BACK TYPE','2'=>'Clip','3'=>'Lever','4'=>'Omega','5'=>'Post','6'=>'Screwback','7'=>'Wire'];
        //metal array for item description
        $silver_arr= array('.925 Silver W/Rhodium'=>'Silver','925 Silver W/Oxside'=>'Silver','.925 Silver'=>'Silver','.925 Silver W/Platinum Plating'=>'Silver','Brass W/Rhodium'=>'Silver','Brass W/Platinum Plating'=>'Silver');

        $gold_arr = array('9K Yellow Gold'=>'9K Yellow Gold','9K White Gold'=>'9K White Gold','9K Rose Gold'=>'9K Rose Gold','10K Yellow Gold'=>'10K Yellow Gold','10K White Gold'=>'10K White Gold','10K Rose Gold'=>'10K Rose Gold','14K Yellow Gold'=>'14K Yellow Gold','14K White Gold'=>'14K White Gold','14K Rose Gold'=>'14K Rose Gold','18K Yellow Gold'=>'18K Yellow Gold','18K White Gold'=>'18K White Gold','18K Rose Gold'=>'18K Rose Gold');

        $gold_plated = array('.925 Silver W/14KGP'=>'14K Yellow Gold Plated','.925 Silver W/18KGP'=>'18K Yellow Gold Plated','.925 Silver W/14K RGP'=>'14K Rose Gold Plated','.925 Silver W/18K RGP'=>'18K Rose Gold Plated','.925 Silver W/14KW GP'=>'14K White Gold Plated','Brass W/14KGP'=>'14K Yellow Gold Plated','Brass W/14K RGP'=>'14K Rose Gold Plated');

        $add_manually = array('9K 2Tone','.925 Silver W/3Tone','.925 Silver W/2Tone','.925 Silver W/1Mic GP','.925 Silver W/2Mic GP','.925 Silver W/3Mic GP','.925 Silver W/1Mic RGP','.925 Silver W/2Mic RGP','.925 Silver W/3Mic RGP');

        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
       
        //echo "<pre>";print_r($totalsku);die();
        for ($i = 2; $i < (($repeat) + 2); $i++) {

            $objPHPExcel = new PHPExcel();

            //$filepath = Yii::app()->getBasePath() . '/components/exports/RS.xls'; live
            $filepath = Yii::app()->getBasePath() . '/components/RS.xls';
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objReader = PHPExcel_IOFactory::createReader("Excel2007");
            $objPHPExcel = PHPExcel_IOFactory::load($filepath);
            
            $objPHPExcel->getProperties()->setCreator("RS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");

            $styleColor = array(
                'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FFFFFF')
                    ),
            );  

            $BStyle = array(
                  'borders' => array(
                    'outline' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN,
                      'color' => array('rgb' => '000000')
                    )
                )
            );

            $styleFontUnderline = array(
                'font' => array(
                    'bold' => true,
                    'size'=>10,
                    'name'=>'Arial',
                    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                ),
            );

            $styleFontBold = array(
                'font' => array(
                    'bold' => true,
                    'size'=>11,
                    'name'=>'Arial',
                ),
            );

            $styleFont = array(
                'font' => array(
                    'bold' => false,
                    'size'=>10,
                    'name'=>'Arial',
                    'color' => array('rgb' => '000000'),
                ),
            );
            $styleLeftAlign = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                ),
            );

            $skucode =$totalsku[($i-2)][0]['skucode'];
            $metal = $totalsku[($i-2)][4];

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A7','Vendor Model #: '.$skucode)
                ->setCellValue('B5', date("m/d/Y"));

            //item description start   

                $sizestone = sizeof($totalsku[($i-2)][2]);
                $diamond = 0;
                $gems = 0;
                $we = 0;
                $stone_wt = 0;
                $diamond_wt = 0;
                $diamond_name = '';

                for ($k = 0; $k < $sizestone; $k++) {
                    $we+= $totalsku[($i-2)][2][$k]['weight'];
                    if ($totalsku[($i-2)][2][$k]['type'] == 'diamond') {
                        $diamond_wt+= $totalsku[($i-2)][2][$k]['tot_weight'];
                        $diamond_name2 = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i-2)][2][$k]['name']));
                        $diamond_name = isset($diamond_name2) ? $diamond_name2->alias : $totalsku[($i-2)][2][$k]['name'];
                        $diamond++;
                    } else {
                        $stone_wt+= $totalsku[($i-2)][2][$k]['tot_weight'];
                        $gems++;
                    }

                    $stone_alias_name = Aliases::model()->findbyattributes(array('aTarget' => '0', 'aField' => 'Complete Sheet', 'initial' => $totalsku[($i-2)][2][$k]['name']));
                    $totalsku[($i-2)][2][$k]['name'] = isset($stone_alias_name) ? $stone_alias_name->alias : $totalsku[($i-2)][2][$k]['name']; 
                }
                $baseprice = 0.00;
                $value = Yii::app()->cache->get('set-term');
                $srate = $value['srate'];$grate = $value['grate'];
                $baseprice = $srate; $color='';
                $metaln= $totalsku[($i-2)][4]; $t_metal='Silver';$costname='';$metal_type='';
                if(array_key_exists($metaln, $silver_arr)){
                    $color = 'White';
                    $metal_type='Sterling Silver';
                }elseif(array_key_exists($metaln, $gold_arr)){
                    $t_metal = $gold_arr[$metaln].' ';
                    $metal_type = $totalsku[($i-2)][16];
                    $color = $this->getColor($totalsku[($i-2)][4]);
                    $baseprice = $grate;
                }elseif(array_key_exists($metaln, $gold_plated)){
                    $costname = $gold_plated[$metaln].' ';
                    $get_c = explode(' ',$costname);
                    $color=$get_c[1];
                    if(stripos($metaln, 'W/14')!== false){
                        $metal_type = 'Sterling Silver 14 KT gold plated';
                    }elseif(stripos($metaln, 'W/18')!== false){
                        $metal_type = 'Sterling Silver 18 KT gold plated';
                    }
                }elseif(in_array($metaln, $add_manually)){
                    if($metaln == '9K 2Tone'){
                        $t_metal = '9K Gold';
                        $baseprice = $grate;
                    }elseif($metaln == '.925 Silver W/3Tone' || $metaln == '.925 Silver W/2Tone'){
                        foreach($totalsku[($i - 2)][18] as $addon){
                            if(stripos($addon['name'],'Gold Plating') !== false){
                                $costname = str_replace('ing', 'ed', $addon['name']) . ' ';
                                $get_c = explode(' ',$costname);
                                $color=$get_c[1];
                                if(stripos($addon['name'], '14K')!== false){
                                    $metal_type = 'Sterling Silver 14 KT gold plated';
                                }elseif(stripos($addon['name'], '18K')!== false){
                                    $metal_type = 'Sterling Silver 18 KT gold plated';
                                }
                            }
                        }
                    }else{
                        foreach($totalsku[($i - 2)][18] as $addon){
                            if(stripos($addon['name'],'Gold Plating') !== false){
                                $costname = str_replace('ing', 'ed', $addon['name']) . ' ';
                                if(stripos($metaln, 'GP')!== false){
                                    $color='Yellow';
                                }elseif(stripos($metaln, 'RGP')!== false){
                                    $color='Rose';
                                } 
                            }
                        }
                    }
                }

                if ($diamond == 0 && $gems == 2) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8','Item Description :'.$costname.(number_format($stone_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' and '.$totalsku[($i-2)][2][1]['name'].' '.$t_metal.' ' .$totalsku[($i-2)][1]['type']));
                    
                } elseif ($diamond == 1 && $gems == 1) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8', 'Item Description :'.$costname.(number_format($diamond_wt + $stone_wt, 2, '.', '').' Carat Genuine '.ComSpry::findalias($totalsku[($i-2)][2][0]['name'], 1).' and '.$totalsku[($i-2)][2][1]['name'].' '.$t_metal.' '.$totalsku[($i-2)][1]['type']));
        
                }elseif ($diamond == 0 && $gems > 2) {
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8', 'Item Description :'.$costname.(number_format($stone_wt, 2, '.', '').' Carat Genuine Multi-Gem Stone '.$t_metal.' '.$totalsku[($i-2)][1]['type']));


                }elseif ($gems > 1 && $diamond != 0) {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8', 'Item Description :'.$costname. (number_format($stone_wt + $diamond_wt, 2, '.', '').' Carat Genuine Multi-Gem Stone'.' and '. $diamond_name. ' ' .$t_metal.' '.$totalsku[($i-2)][1]['type']));


                } elseif ($diamond == 2 && $gems == 0) {
                      $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8', 'Item Description :'.$costname. (number_format($diamond_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' and '. $totalsku[($i -2)][2][1]['name']. ' ' .$t_metal.' '.$totalsku[($i-2)][1]['type']));

                }else{
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A8','Item Description :'.$costname. (number_format($stone_wt+$diamond_wt, 2, '.', '').' Carat Genuine '.$totalsku[($i-2)][2][0]['name'].' '.$t_metal.' ' .$totalsku[($i-2)][1]['type']));

                }

                $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($styleFontBold);
            // item description end  


            //metal type style
                $objPHPExcel->getActiveSheet()->getStyle('A14:D25')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('A14:D25')->applyFromArray($BStyle);
                
                $k=14;
                for($j=0 ; $j<=10 ; $j++){
                    if($metaltype[$j] == $metal_type){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$k , '( '.$metaltype[$j].' )');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $k)->applyFromArray($styleFontBold);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$k , $metaltype[$j]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $k )->applyFromArray($styleFont);
                    }
                    $k++;
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B14', $metaltype[11]);
                $objPHPExcel->getActiveSheet()->getStyle('A14:B14')->applyFromArray($styleFontUnderline);
                $objPHPExcel->setActiveSheetIndex()->getStyle('A15:A24')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            //metal type style end

            //metal color style
                $objPHPExcel->getActiveSheet()->getStyle('A27:A34')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('A27:A34')->applyFromArray($BStyle);

                $k =27;
                for($j=0 ; $j<=5 ; $j++){
                    if($metalcolor[$j] == $color){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$k , '('. $metalcolor[$j].')');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $k )->applyFromArray($styleFontBold);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$k , $metalcolor[$j]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $k )->applyFromArray($styleFont);
                    }
                    $k++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('A27')->applyFromArray($styleFontUnderline);
            //metal color style end

            //Other Components
                $objPHPExcel->getActiveSheet()->getStyle('B27:B34')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('B27:B34')->applyFromArray($BStyle);

                $k =27;
                for($j=0 ; $j<=3 ; $j++){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$k , $othercomponent[$j]);
                    $objPHPExcel->getActiveSheet(0)->getStyle('B' . $k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $k)->applyFromArray($styleFont);
                    $k++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('B27')->applyFromArray($styleFontBold);
            // Other Components end

            // Finish
                $objPHPExcel->getActiveSheet()->getStyle('C27:D34')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('C27:D34')->applyFromArray($BStyle);

                $k=27; $count = 0;
                // for($j=0 ; $j<=6 ; $j++){
                //     if(isset($totalsku[0][8]['formula'][0]) && ($totalsku[0][8]['formula'][0]['name'] == $finish[$j])){
                //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$k , '('.$finish[$j].')');
                //         $objPHPExcel->getActiveSheet()->getStyle('C' . $k)->applyFromArray($styleFontBold);
                //     }else{
                //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$k , $finish[$j]);
                //         $objPHPExcel->getActiveSheet()->getStyle('C' . $k)->applyFromArray($styleFont);
                //     }
                //     $k++;
                // }

                $finish_arr = array();
               
                foreach ($totalsku[($i-2)][18] as $key => $value) {
                    if(stripos($value['name'] , 'Polish') !== false ){
                        $finish_arr[] = 'Polish'; 
                    }elseif (stripos($value['name'] , 'Rhodium') !== false){
                        $finish_arr[] = 'Rhodium';
                    }
                }
                $finish_arr = array_unique($finish_arr);
                for($j=0 ; $j<=6 ; $j++){
                    if(in_array($finish[$j], $finish_arr)){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$k , '('.$finish[$j].')');
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $k)->applyFromArray($styleFontBold);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$k , $finish[$j]);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $k)->applyFromArray($styleFont);
                    }
                    $k++;
                }


                $objPHPExcel->getActiveSheet()->getStyle('C27')->applyFromArray($styleFontUnderline);
            // finish end


            //Category type
                $objPHPExcel->getActiveSheet()->getStyle('F15:J29')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('F15:J29')->applyFromArray($BStyle);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F15', $category[0]);
                $objPHPExcel->getActiveSheet()->getStyle('F15')->applyFromArray($styleFontBold);

                $k = 17;$count=0; $found = 0; $chain_type = trim(ucfirst($totalsku[($i-2)][1]['chaintype']));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F16', $cat_type[0]);
                $objPHPExcel->getActiveSheet()->getStyle('F16')->applyFromArray($styleFontUnderline);
                for($j=1 ; $j<sizeof($cat_type) ; $j++){ 
                    if($count == 0){
                        if($cat_type[$j] == $chain_type){
                            $found = 1;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$k, '('.$cat_type[$j].')');
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->applyFromArray($styleFontBold);
                            $count = 1;
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $k, $cat_type[$j]);
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->applyFromArray($styleFont);
                            $count = 1;
                        }
                        
                    }else{
                        if($cat_type[$j] == $chain_type){
                             $found = 1;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k,'('.$cat_type[$j].')');
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFontBold);
                            $count = 0;
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k, $cat_type[$j]);
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFont);
                            $count = 0;
                        }
                    }
                    if($j%2 == 0){ $k++;}
                }

                if(($found == 0) && ($totalsku[($i-2)][1]['type'] == 'Pendant' || $totalsku[($i-2)][1]['type'] == 'Set' ||$totalsku[($i-2)][1]['type'] == 'Necklace')){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k,'(Other)');
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFontBold);
                }else{
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k, 'Other');
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFont);
                }


                $k=17; $count=0; 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H16', $cat_safety[0]);
                $objPHPExcel->getActiveSheet()->getStyle('H16')->applyFromArray($styleFontUnderline);
                for($j=1 ; $j<=6 ; $j++){
                    if($count == 0){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $k, $cat_safety[$j]);
                        $count = 1;
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $k, $cat_safety[$j]);
                        $count = 0;
                    }
                    if($j%2 == 0){ $k++;}
                }

                
                $k=22; $count=0; $found=0;$clasp_type = $totalsku[($i-2)][1]['clasptype'];
                if($clasp_type == 'spring-ring'){
                    $clasp_type = 'Springring';
                }elseif($clasp_type == 'lobster-claw'){
                    $clasp_type = 'Lobster';
                }elseif($clasp_type == 'box-with-tongue-and-safety'){
                    $clasp_type = 'Box';
                }elseif($clasp_type == 'other-clasp-type'){
                    $clasp_type = 'Other';
                }
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F21', $cat_clasp[0]);
                $objPHPExcel->getActiveSheet()->getStyle('F21')->applyFromArray($styleFontUnderline);
                for($j=1 ; $j<sizeof($cat_clasp) ; $j++){
                    if($count == 0){
                        if($cat_clasp[$j] == $clasp_type){
                            $found=1;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$k,'('.$cat_clasp[$j].')');
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->applyFromArray($styleFontBold); 
                            $count = 1;

                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $k, $cat_clasp[$j]);
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->applyFromArray($styleFont);
                            $count = 1;
                        }
                        
                    }else{
                        if($cat_clasp[$j] == $clasp_type){
                            $found=1;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k,'('.$cat_clasp[$j].')');
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFontBold);
                            $count = 0;
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $k, $cat_clasp[$j]);
                            $objPHPExcel->getActiveSheet()->getStyle('G'.$k)->applyFromArray($styleFont);
                            $count = 0;
                        }
                    }
                    if($j%2 == 0){$k++;}
                }

                
                if(($found == 0) && ($totalsku[($i-2)][1]['type'] == 'Pendant' || $totalsku[($i-2)][1]['type'] == 'Set' ||$totalsku[($i-2)][1]['type'] == 'Necklace')){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . ($k-1),'(Other)');
                    $objPHPExcel->getActiveSheet()->getStyle('G'.($k-1))->applyFromArray($styleFontBold);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . ($k-1), 'Other');
                    $objPHPExcel->getActiveSheet()->getStyle('G'.($k-1))->applyFromArray($styleFont);
                }



                $k=22; $count=0;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H21', $cat_bale[0]);
                $objPHPExcel->getActiveSheet()->getStyle('H21')->applyFromArray($styleFontUnderline);
                for($j=1 ; $j<=6 ; $j++){
                    if($count == 0){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $k, $cat_bale[$j]);
                        $count = 1;
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $k, $cat_bale[$j]);
                        $count = 0;
                    }
                    if($j%2 == 0){$k++;}
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F27', 'BANGLE:');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G27', 'Yes/No');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I27', 'LENGTH:');
        
                if($totalsku[($i-2)][1]['size'] !== NULL && $totalsku[($i-2)][1]['size'] !== 'N/A' && $totalsku[($i-2)][1]['size'] !== ' '){
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J27', $totalsku[($i-2)][1]['size']); 
                }
                $objPHPExcel->getActiveSheet()->getStyle('J27')->applyFromArray($styleLeftAlign);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F28', 'CHAIN INCLUDED:');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H28', 'Yes/No');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I28', 'WIDTH:');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J28', '________');

              
                $objPHPExcel->getActiveSheet()->getStyle('F27')->applyFromArray($styleFontBold);
                $objPHPExcel->getActiveSheet()->getStyle('I27')->applyFromArray($styleFontBold);
                $objPHPExcel->getActiveSheet()->getStyle('F28')->applyFromArray($styleFontBold);
                $objPHPExcel->getActiveSheet()->getStyle('I28')->applyFromArray($styleFontBold);
            //Category type end

            //earring type

                $objPHPExcel->getActiveSheet()->getStyle('L15:L29')->applyFromArray($styleColor);
                $objPHPExcel->getActiveSheet()->getStyle('L15:L29')->applyFromArray($BStyle);
                $ear_type = 'null';
                if(isset($totalsku[($i-2)][12][0])){
                    $ear = $totalsku[($i-2)][12][0]['name'];
                    if(stripos($ear, 'Push & Post') !== false){
                        $ear_type = 'Post';
                    }elseif(stripos($ear, 'Clip on') !== false){
                        $ear_type = 'Clip';
                    }elseif(stripos($ear, 'Omega') !== false){
                        $ear_type = 'Omega';
                    }elseif(stripos($ear, 'Lever Back') !== false){
                        $ear_type = 'Lever';
                    }elseif(stripos($ear, 'Earwire') !== false){
                        $ear_type = 'Wire';
                    }
                }
                $k=15; 
                for($j=0 ; $j<=7 ; $j++){
                    if($earingtype[$j] == $ear_type){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$k ,'('.$earingtype[$j].')');
                        $objPHPExcel->getActiveSheet()->getStyle('L'.$k)->applyFromArray($styleFontBold);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$k ,$earingtype[$j]);
                        $objPHPExcel->getActiveSheet()->getStyle('L'.$k)->applyFromArray($styleFont);
                    }
                    $k++;
                }
                
                $objPHPExcel->getActiveSheet()->getStyle('L15')->applyFromArray($styleFontBold);
                $objPHPExcel->getActiveSheet()->getStyle('L16')->applyFromArray($styleFontUnderline);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L24','JACKETS:'.'Yes/No');
                $objPHPExcel->getActiveSheet()->getStyle('L24')->applyFromArray($styleFontBold);
            //earing type end
            
            //for stone
                $stone = $totalsku[($i-2)][2]; 
                $k = 40;$stonesize = sizeof($totalsku[($i-2)][2]);$count =1;
                $treatment = array();
                foreach($stone as $key){
                    $key['ppc'] = ($key['weight']!=0)?$key['ppc']/$key['weight']:'';
                    $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue('A' . $k, 'Stone '.$count)
                      ->setCellValue('B' . $k, $key['name'])
                      ->setCellValue('C' . $k, $key['pieces'])
                      ->setCellValue('D' . $k, $key['shape'])
                      ->setCellValue('E' . $k, '')
                      ->setCellValue('F' . $k, '')
                      ->setCellValue('G' . $k, $key['weight'])
                      ->setCellValue('H' . $k, $key['size'])
                      ->setCellValue('I' . $k, '=(G' . ($k) . '*C' . ($k) . ')')
                      ->setCellValue('J' . $k, $key['ppc'])
                      ->setCellValue('L' . $k, '=(J'.($k).'*I'.($k).')');
                    $treatment[] = $key['name'].' - '.$key['treatm'];
                    if (strpos($key['name'], 'Diamond') == true) {
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('E' . $k, $key['color'])
                            ->setCellValue('F' . $k, $key['clarity'])
                            ->setCellValue('G' . $k, $key['weight']);
                        $objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.$k)->getNumberFormat()->setFormatCode('#0.000');
                    }
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.$k)->getNumberFormat()->setFormatCode('#0.0');
                    $k++;$count++;
                }
                $objPHPExcel->setActiveSheetIndex()->getStyle('A40:L54')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //for stone end

            //for treatment Method
                $treat_uni = array_unique($treatment);$p = 58;
                foreach ($treat_uni as $key ) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H' . $p, $key);
                    $objPHPExcel->getActiveSheet(0)->getStyle('H'.$p)->getFont()->setBold(false)->setName('Arial')->setSize(12)->setUnderline(true);
                    $p++;
                }
            //end treatment Method

            //additional
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H' .($p + 1), 'Additional lengths available: ')
                        ->setCellValue('H' .($p + 2), 'Length: ________ ')
                        ->setCellValue('J' .($p + 2), 'Cost: ________ ')
                        ->setCellValue('H' .($p + 3), 'Length: ________ ')
                        ->setCellValue('J' .($p + 3), 'Cost: ________ ')
                        ->setCellValue('H' .($p + 4), 'Length: ________ ')
                        ->setCellValue('J' .($p + 4), 'Cost: ________ ');

                $objPHPExcel->setActiveSheetIndex(0)->getStyle('H'.($p + 1))->applyFromArray(
                    array( 'font' => array( 'bold' => true,'size'=>12,'name'=>'Arial', ),
                    )
                );
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('H'.($p + 2).':J'.($p + 4))->applyFromArray(
                    array( 'font' => array( 'bold' => false,'size'=>12,'name'=>'Arial'),
                    )
                );

            //end additional

            //review
                $reviews='';
                foreach($totalsku[($i-2)][17] as $key => $value){
                    $reviews = trim($value);
                }

                $objPHPExcel->getActiveSheet()->getStyle('B40:'.'B'.($k))->applyFromArray($styleFont);
                
                if(($k + 1) < 54 ){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($k + 1), $reviews);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.($k + 1))->applyFromArray(
                        array(
                            'font' => array(
                                'bold' => true, 'size'=>11, 'name'=>'Arial',
                                'color' => array('rgb' => 'FF0000')
                            ),
                        )
                    );
                }
                
            //end review

            //for image
            if(isset($totalsku[($i-2)][3][0])){
                $imagename = $totalsku[($i-2)][3][0];
                //$basepath = Yii::app()->basePath . '/..' .$imagename ; live
                $basepath = dirname(dirname(Yii::app()->basePath)).$imagename;
                if(file_exists($basepath)){
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('image');
                    $objDrawing->setDescription('image');
                    $objDrawing->setPath($basepath);
                    $objDrawing->setCoordinates('F3');
                    $objDrawing->setOffsetX(80); 
                    $objDrawing->setOffsetY(3);
                    $objDrawing->setWidthAndHeight(700,150);
                    $objDrawing->setResizeProportional(true);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }  
            }

            $objPHPExcel->setActiveSheetIndex(0)->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //for image end

            // last block
            $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('E60', $baseprice)
               ->setCellValue('E61', $totalsku[0][8]['labor']);

            //total wt of finished piece
            $chainwt = 0.00;
            if($totalsku[($i-2)][1]['type'] == 'Pendant' || $totalsku[($i-2)][1]['type'] == 'Set' ||$totalsku[($i-2)][1]['type'] == 'Necklace' ){
                foreach ($totalsku[($i-2)][12] as $key) {
                   $chainwt += $key['wt'];
                }
            }
            if($chainwt > 0){
                $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('E57', $totalsku[($i-2)][0]['totmetalwei'] + $chainwt);
            }else{
                $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('E57', $totalsku[($i-2)][0]['totmetalwei']);
            }
            $p=40;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E58', '= E57' .'+(' .'I'.($p + 0). '+'.'I'.($p + 1). '+'.'I'.($p + 2). '+'.'I'.($p + 3). '+'.'I'.($p + 4). '+'.'I'.($p + 5). '+'.'I'.($p + 6). '+'.'I'.($p + 7).'+'.'I'.($p + 8).'+'.'I'.($p + 9).'+'.'I'.($p + 10).'+'.'I'.($p + 11).'+'.'I'.($p + 12).'+'.'I'.($p + 13).'+'.'I'.($p + 14).')/5'); 
        
            //Total cost
                $type = $totalsku[0][1]['type'];$multiplyby = 1;
                if($type == 'Pendant'){
                    $multiplyby = 0.58;
                } 
                if($type == 'Ring'){
                    $multiplyby = 26.5;
                }
                if($type == 'Earrings'){
                    $multiplyby = 0.57;
                }
                if($type == 'Bracelet'){
                    $multiplyby = 0.65;
                }

                $p=40;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E63','= (E57*'.$multiplyby.')+('.'L'.($p + 0).'+'.'L'.($p + 1).'+'.'L'.($p + 2).'+'.'L'.($p + 3).'+'.'L'.($p + 4).'+'.'L'.($p + 5).'+'.'L'.($p + 6).'+'.'L'.($p + 7).'+'.'L'.($p + 8).'+'.'L'.($p + 9).'+'.'L'.($p + 10).'+'.'L'.($p + 11).'+'.'L'.($p + 12).')+'.'E61');
            //total cost end
            $new_skucode = str_replace('/', '_', $skucode);
            $innerfolder = preg_replace("[^\w\s\d\.\-_~,;:\[\]\(\]]", '', $new_skucode);

            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->setPreCalculateFormulas();
            if (!file_exists($pathname.$folderto.'/'.$innerfolder)){
                if (!mkdir($pathname.$folderto.'/'.$innerfolder, 0777, true)) {
                    die('Failed to create folders...');
                }else{
                    $objWriter->save($pathname.$folderto.'/'.$innerfolder.'/'.'RS'.'_'.$new_skucode.'.xlsx');
                }
            }
        }
        die();
       $this->zipdirectory($pathname, $folderto);
    }

    public function getColor($metal){
        $color = '';
        if(stripos($metal , 'Yellow') !== false){
            $color = 'Yellow';
        }elseif(stripos($metal , 'White') !== false){
            $color = 'White';
        }elseif(stripos($metal , 'Rose') !== false){
            $color = "Rose";
        }elseif(stripos($metal , 'Silver') !== false){
            $color = "White";
        }
        return $color;
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
            $skureviews = $sku->skureviews;
            $skustones = $sku->skustones;
            $skuaddon =$sku->skuaddons;
           // $dimunit = $sku->dimunit == 'IN' ? 'inches' : $sku->dimunit;
            $stones = array();
            foreach ($skustones as $skustone) {
                $settingalias = Aliases::model()->findbyattributes(array('initial' => $skustone->idsetting0->name, 'aTarget' => 12, 'aField' => 'Setting'));
                $stones[] = array(
                    'skus' => $sku->skucode,
                    'item_type' => $skucontent->type,
                    'tot_weight' =>$skustone->idstone0->weight * $skustone->pieces,
                    'stowei_unit' => $sku->stoweiunit,
                    'pieces' => $skustone->pieces,
                    'reviews' => $skustone->reviews,
                    'setting' => isset($settingalias) ? $settingalias->alias : $skustone->idsetting0->name,
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
                    'treatm' => $skustone->idstone0->idstonem0->treatmeth,
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month,
                ); 
            }
            $stones[0]['flag'] = true;
            $newstones = Newstone::unqiuestones($stones);
            //$stonecode = $this->stoneDetails($stones);
            $skuimages = $sku->skuimages();
            $imageUrls = array();
            foreach ($skuimages as $skuimage) {
                if($skuimage->type == 'MISG'){
                    $imageUrls[] = $skuimage->imageThumbUrl;
                } 
            }

            $skumetal = $sku->skumetals[0];
            $metal = $skumetal->idmetal0->namevar;
            $metal_name = $skumetal->idmetal0->idmetalm0->name;
            $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
            $metalstamp = $skumetal->idmetal0->idmetalstamp0->name;
            $currentcost = $skumetal->idmetal0->currentcost;

            $metaltype = $skumetal->idmetal0->idmetalm0->name;

            if($metaltype == '.925 Silver'){
                $metaltype = 'Sterling Silver';
            }

            $finisingalias = Aliases::model()->findbyattributes(array('initial' => $skumetal->idmetal0->namevar, 'aTarget' => 11, 'aField' => 'Finish'));
            $finishing = isset($finisingalias) ? $finisingalias->alias : $skumetal->idmetal0->namevar;
 
            $finisingalias = Aliases::model()->findbyattributes(array('initial' => $finishing, 'aTarget' => 12, 'aField' => 'Finish/Plating'));
            $finishing = isset($finisingalias) ? $finisingalias->alias : $finishing;

          
            $finds = array();
            $findwt = 0;
            $findings = $sku->skufindings;
          
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    'find_metal'=>$finding->idfinding0->idmetal0->namevar,
                    'wt'=>$finding->idfinding0->weight,
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
            $reviews = array();
            foreach($skureviews as $skureview){
                $reviews[] = $skureview->reviews;
            }

            $addon = array();
            foreach($skuaddon as $skuadd){
                $addon[] = array(
                    'id'=> $skuadd->idskuaddon,
                    'name'=> $skuadd->idcostaddon0->name,
                );
               
            }
            //$depends $alias
            $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $imageUrls, $metal, $metalcost, $metalstamp, $currentcost, $cost, $totcost, $cpf, $metal_name, $finds, $newstones,$finishing, $findwt,$metaltype,$reviews,$addon);
           
        }
        return $totalsku;
        
    }

    public static function zipdirectory($path, $directory){
        $rootPath = $path . $directory;
        $zip = new ZipArchive;
        $zip->open($rootPath.'.zip', ZipArchive::CREATE); 
        $files = array_merge(glob($rootPath."/*/*.XLSX") , glob($rootPath."/*/*.xlsx"));
        $files = array_merge(glob($rootPath."/*/*.xlsx") , $files);
        $zip->addEmptyDir('.');
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        header('Content-disposition: attachment; filename=attachment.zip');
        header('Content-type: application/zip');
        readfile($rootPath.'.zip');
        header("Pragma: no-cache");
        header("Expires: 0");
    }

}