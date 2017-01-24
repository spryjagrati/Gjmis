<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Approval
 *
 * @author maverick
 */
class Approval extends CController{
   
    public function export($id) {
        $memo = Memo::model()->findByPk($id);
        $dept = Dept::model()->findByPk($memo->iddptfrom);
        $memoskus = Memosku::model()->findallByAttributes(array('idmemo' => $id, 'type' => 1));
        $skus = Approval::getSkudata($memoskus);
        
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();

        $filepath = Yii::app()->getBasePath() . '/components/exports/approval.xls';
        
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        
        $objPHPExcel->getProperties()->setCreator("Approval Memo")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3',  $dept->name)
                ->setCellValue('A4',  $dept->location)
                ->setCellValue('A5',  'Phone: '.$dept->phone)
                ->setCellValue('B10',  $memo->memoto)
                ->setCellValue('G9',   date('d-M-y', strtotime($memo->mdate)))
                ->setCellValue('G10',  $memo->code)
                ->setCellValue('J67',  'For '.$dept->name)
                 ->setCellValue('J57',  '=Sum(J20,J56)')
                 ->setCellValue('K57',  '=Sum(K20,K56)')
                 ->setCellValue('L57',  '=Sum(L20,L56)')
                 ->setCellValue('M57',  '=Sum(M20,M56)')
                 ->setCellValue('O57',  '=Sum(O20,O56)');
        
        
        $i = 20;
        foreach($skus as $sku){ 
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,  $i - 19)
                ->setCellValue('C'.$i,  $sku['code'])
                ->setCellValue('E'.$i,  $sku['size'])
                ->setCellValue('G'.$i,  $sku['type'])
                ->setCellValue('H'.$i,  $sku['metal'])
                ->setCellValue('I'.$i,  $sku['qty'])
                ->setCellValue('J'.$i,  $sku['grosswt'])
                ->setCellValue('K'.$i,  $sku['gemwt'])
                ->setCellValue('L'.$i,  $sku['diawt'])
                ->setCellValue('M'.$i,  $sku['metalwt'])
                ->setCellValue('N'.$i,  $sku['price'])
                ->setCellValue('O'.$i,  '=Product((N' . $i . '),(J' . $i. '))');
            $i++;
        }
        
        
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Approval_Memo.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        spl_autoload_register(array('YiiBase', 'autoload'));
    }
    
    public function getSkudata($memoskus){
        $skus = array();
        
        foreach ($memoskus as $memosku){
            $allstones = $memosku->idsku0->topStoneWeightNum();
            $diamonds = $memosku->idsku0->DiamondWeightNum();
                    
            $skus[$memosku->idsku]['code'] = $memosku->idsku0->skucode;
            $skus[$memosku->idsku]['size'] = $memosku->idsku0->skucontent->size;
            $skus[$memosku->idsku]['type'] = $memosku->idsku0->skucontent->type;
            $skus[$memosku->idsku]['metal'] = $memosku->idsku0->skumetals[0]->idmetal0->namevar;
            $skus[$memosku->idsku]['qty'] = $memosku->qty;
            $skus[$memosku->idsku]['grosswt'] =$memosku->qty *  $memosku->idsku0->grosswt;
            $skus[$memosku->idsku]['price'] = $memosku->qty * ComSpry::calcSkuCost($memosku->idsku);
            $skus[$memosku->idsku]['gemwt'] = $memosku->qty * ($allstones['wt'] - $diamonds['wt']);
            $skus[$memosku->idsku]['diawt'] = $memosku->qty * $diamonds['wt'];
            $skus[$memosku->idsku]['metalwt'] = $memosku->idsku0->totmetalwei * $memosku->qty;
            
        }
       
        return $skus;
    }
    
    
}
