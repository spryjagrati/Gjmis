<?php

class Gtdf extends CController{
    
    public function export($skuids) {
        $ids = explode(",", $skuids);
        $repeat = count($ids);
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        $phpWordPath = Yii::getPathOfAlias('ext.PHPWord');

        $path = dirname(dirname(Yii::app()->basePath)).'/gjmis/images/temp';
        $filepath = $path.'/gtdf.docx';
        $tempfile = $path.'/Gtdf.docx';
        spl_autoload_unregister(array('YiiBase', 'autoload'));
       
        $phpWordPath = Yii::getPathOfAlias('ext.phpword');
        require_once($phpWordPath . DIRECTORY_SEPARATOR . 'PHPWord.php');
        $PHPWord = new PHPWord();
        spl_autoload_register(array('YiiBase','autoload'));
        $document = $PHPWord->loadTemplate($filepath);
        $document->setValue('{date1}', date('M d,Y'));
        $data_array = $this->getDataArray($totalsku, $repeat);
       
        // clone rows   
        $document->cloneRow('T4', $data_array);
        $document->cloneRow('DinamicTable', $data_array);
        $document->save($tempfile);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=Gtdf.docx');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length: ' . filesize($tempfile));
        flush();
        readfile($tempfile);
        unlink($tempfile); // deletes the temporary file
        exit;
    }

    public function masterarray($ids){

        foreach ($ids as $id) {
            $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
            $aliases = Aliases::model()->findAll();
            $depends = DependentAlias::model()->findAll();
            $skucontent = $sku->skucontent;
            $skustones = $sku->skustones;
            $skuaddon =$sku->skuaddons;
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
                    'cut' => $skustone->idstone0->cut,
                    'month' => $skustone->idstone0->month,
                    'scountry'=>$skustone->idstone0->idstonem0->scountry,
                ); 
            }

                $stones[0]['flag'] = true;
                $newstones = Newstone::unqiuestones($stones);
                
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

                $finds = array();
                $findwt = 0;
                $findings = $sku->skufindings;
                foreach ($findings as $finding) {
                    $finds[] = array(
                        'name' => $finding->idfinding0->name,
                        'weight' => $finding->idfinding0->weight,
                        'size'=>$finding->idfinding0->size,
                        'cost'=>$finding->idfinding0->cost,
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
                foreach($skuaddon as $skuadd){
                    $addon[] = array(
                        'id'=> $skuadd->idskuaddon,
                        'name'=> $skuadd->idcostaddon0->name,
                    );
                }

                $totalsku[] = array($sku->attributes, $skucontent->attributes, $stones, $metal, $metalcost, $metalstamp,$metaltype, $currentcost, $metal_name, $newstones,$cost,$totcost,$finds,$addon);
        }
        return $totalsku;
    }

    public function getDataArray($totalsku,$repeat){

        $silver_arr= array('.925 Silver W/Rhodium'=>'Sterling Silver','925 Silver W/Oxside'=>'Sterling Silver','.925 Silver'=>'Sterling Silver','.925 Silver W/Platinum Plating'=>'Sterling Silver','Brass W/Rhodium'=>'Sterling Silver','Brass W/Platinum Plating'=>'Sterling Silver');

        $gold_arr = array('9K Yellow Gold'=>'Yellow Gold','9K White Gold'=>'White Gold','9K Rose Gold'=>'Rose Gold','10K Yellow Gold'=>'Yellow Gold','10K White Gold'=>'White Gold','10K Rose Gold'=>'Rose Gold','14K Yellow Gold'=>'Yellow Gold','14K White Gold'=>'White Gold','14K Rose Gold'=>'Rose Gold','18K Yellow Gold'=>'Yellow Gold','18K White Gold'=>'White Gold','18K Rose Gold'=>'Rose Gold');
 
        $gold_plated = array('.925 Silver W/14KGP'=>'Yellow Gold Plated','.925 Silver W/18KGP'=>' Yellow Gold Plated','.925 Silver W/14K RGP'=>'Rose Gold Plated','.925 Silver W/18K RGP'=>'Rose Gold Plated','.925 Silver W/14KW GP'=>'White Gold Plated','Brass W/14KGP'=>'Yellow Gold Plated','Brass W/14K RGP'=>'Rose Gold Plated');

        $add_manually = array('9K 2Tone','.925 Silver W/3Tone','.925 Silver W/2Tone','.925 Silver W/1Mic GP','.925 Silver W/2Mic GP','.925 Silver W/3Mic GP','.925 Silver W/1Mic RGP','.925 Silver W/2Mic RGP','.925 Silver W/3Mic RGP');

        $complete_array = array(
                'val1'=>array(),
                'val2'=>array(),
                'val3'=>array(),
                'val4'=>array(),
                'val5'=>array(),
            );

        for ($i = 2; $i < (($repeat) + 2); $i++) {
            $skucode = $totalsku[($i-2)][0]['skucode'];
            $skutype = $totalsku[($i-2)][1]['type'];
            $mcountry = "INDIA";
            $metal = $totalsku[($i-2)][3];

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

            $metaln= $totalsku[($i-2)][3]; $t_metal='';$costname='';
            
            if(array_key_exists($metaln, $silver_arr)){
                $costname = $silver_arr[$metaln];
            }elseif(array_key_exists($metaln, $gold_arr)){
                $costname = 'Gold';
            }elseif(array_key_exists($metaln, $gold_plated)){
                $costname = 'Sterling Silver Gold Plated';
            }elseif(in_array($metaln, $add_manually)){
                if($metaln == '9K 2Tone'){
                    $costname = 'Gold';
                }elseif($metaln == '.925 Silver W/3Tone' || $metaln == '.925 Silver W/2Tone'){
                    foreach($totalsku[($i - 2)][13] as $addon){
                        if(stripos($addon['name'],'Gold Plating') !== false){
                            $costname = 'Sterling Silver Gold Plated';
                        }
                    }
                }else{
                    foreach($totalsku[($i - 2)][13] as $addon){
                        if(stripos($addon['name'],'Gold Plating') !== false){
                            $costname = 'Sterling Silver Gold Plated';
                        }
                    }
                }
            }

            $count = 0;  
            $stone_arr = $totalsku[($i-2)][2];
            for ($k = 0; $k < $sizestone; $k++) {
                if(stripos($stone_arr[$k]["name"],'Diamond') !== false){
                    $stone_arr[$k]["tot_weight"] = round($stone_arr[$k]["tot_weight"],3);
                }else{
                    $stone_arr[$k]["tot_weight"] = round($stone_arr[$k]["tot_weight"],2);
                }

                if($count == 0){
                    array_push($complete_array['val1'], $skucode);
                    $des = $stone_arr[$k]["name"].', '.$stone_arr[$k]["tot_weight"].'ctw, '.$skutype." in ".$t_metal.$costname;
                    array_push($complete_array['val2'], $des);
                    array_push($complete_array['val3'], $stone_arr[$k]["tmeth"]);
                    array_push($complete_array['val4'], 'INDIA');
                    array_push($complete_array['val5'], $stone_arr[$k]["scountry"]);
                    $count++;
                }else{
                    array_push($complete_array['val1'], '');
                    $des=$stone_arr[$k]["name"].', '.$stone_arr[$k]["tot_weight"].'ctw';
                    array_push($complete_array['val2'], $des);
                    array_push($complete_array['val3'], $stone_arr[$k]["tmeth"]);
                    array_push($complete_array['val4'], 'INDIA');
                    array_push($complete_array['val5'], $stone_arr[$k]["scountry"]);
                    
                }
            }        
        }
        return $complete_array;  
    }
}