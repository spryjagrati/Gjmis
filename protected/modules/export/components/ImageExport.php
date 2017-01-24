<?php

/**
 * Description of ImageExport
 *
 * @author maverick
 */

class ImageExport extends CController {
    
    public static function export($skuids, $excel){
        $skus = explode(',', $skuids);
        //$pathname = Yii::app()->basePath.'/../images/'; live
       $pathname = dirname(dirname(Yii::app()->basePath)).'/gjmis/images/';
        $folderto = 'temp/'.date('ymdhis');
        $folderfrom = '650x650';
                
        foreach($skus as $sku){
            $skuimages = Skuimages::model()->findallbyattributes(array('idsku' => $sku));
            if(isset($skuimages) && is_array($skuimages) && count($skuimages) > 0){
                $innerfolder = preg_replace("[^\w\s\d\.\-_~,;:\[\]\(\]]", '', $skuimages[0]->idsku0->skucode);
                if (!file_exists($pathname.$folderto.'/'.$innerfolder)){
                   if (!mkdir($pathname.$folderto.'/'.$innerfolder, 0777, true)) {
                        die('Failed to create folders...');
                    }else{
                        foreach($skuimages as $skuimage){
                            if( $skuimage->type != 'MISG'){
                                if(file_exists($pathname.$folderfrom.'/'.$skuimage->image))
                                    copy($pathname.$folderfrom.'/'.$skuimage->image, $pathname.$folderto.'/'.$innerfolder.'/'.$skuimage->image);
                            }
                        }
                    }
                }
            }
        }
        ImageExport::zipdirectory($pathname, $folderto);
    }
    
    public static function zipdirectory($path, $directory){
        $rootPath = $path . $directory;
        
        $zip = new ZipArchive;
        $zip->open($rootPath.'.zip', ZipArchive::CREATE); 
        $files = array_merge(glob($rootPath."/*/*.PNG") , glob($rootPath."/*/*.png"));
        $files = array_merge(glob($rootPath."/*/*.jpg") , $files);
        $files = array_merge(glob($rootPath."/*/*.JPG") , $files);
        $files = array_merge(glob($rootPath."/*/*.JPEG") , $files);
        $files = array_merge(glob($rootPath."/*/*.jpeg") , $files);
        $zip->addEmptyDir('.');
        foreach ($files as $file) {
            {
                $zip->addFile($file, basename($file));
            }
        }
        $zip->close();
        
        header('Content-disposition: attachment; filename=attachment.zip');
        header('Content-type: application/zip');
        readfile($rootPath.'.zip');
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
