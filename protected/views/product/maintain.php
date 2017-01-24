<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	'Maintain',
);

$this->menu=array(
	array('label'=>'Manage Sku', 'url'=>array('product/admin')),
	array('label'=>'Create New Sku', 'url'=>array('product/create')),
);
?>

<span class="required"><?php echo Yii::app()->user->getFlash('skuimage',''); ?></span>

<h1>Sku</h1>
<h4>Newly added data would not be update-able right away after creation, please revisit the page to update thru the links provided.</h4>
<!--
<h4><a id="pageRefresher" href=""><span>refresh</span></a></h4>
<?php
//Yii::app()->clientScript->registerScript('refresherScript','$("#pageRefresher").click(function(){window.location.reload();});',1);
?>
-->
<?php
$tabs=array();
$tabs['Add Metal']=$this->renderPartial("_form_metal", array("model"=>$modelmetal), true);
$tabs['Update Sku']=$this->renderPartial("_form_sku", array("model"=>$modelsku), true);
$tabs['Add Stone']=$this->renderPartial("_form_stone", array("model"=>$modelstone), true);
$tabs['Add Labor']=$this->renderPartial("_form_addon", array("model"=>$modeladdon), true);
$tabs['Add Finding']=$this->renderPartial("_form_finding", array("model"=>$modelfinding), true);
$tabs['Update Content']=$this->renderPartial("_form_content", array("model"=>$modelcontent), true);
$tabs['Seller Data']=$this->renderPartial("_form_selmap", array("model"=>$modelselmap), true);
$tabs['Add Image']=$this->renderPartial("_form_image", array("model"=>$modelimage), true);
$tabs['Add Review']=$this->renderPartial("_form_review", array("model"=>$modelreview), true);



$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
        'selected'=>-1,
        //'ajaxOptions'=>array('async'=>true),
        //'idPrefix'=>'ui-tabs-',
    ),
));
?>
<!-- cost fetch div -->
<div class="uniForm" style="width:100%;">
    <div class="buttonHolder" style="width:95%;margin:0;">
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'skucostcalc-form','action'=>$this->createUrl('product/fetchCost/'.$modelsku->idsku),
                'enableAjaxValidation'=>false,
        )); ?>
        <?php echo CHtml::ajaxSubmitButton('Get Cost',array('product/fetchCost/'.$modelsku->idsku),array('update'=>'#costDisplay'),array('id'=>'sku-cost-getter','class'=>'primaryAction', 'style'=>'width:15%;float:left;')); ?>
        <?php $this->endWidget(); ?>
        <div id="costDisplay">
        $<div id="okMsg" style="width:80%;float:right;margin:0;font-size:17px;padding:0.5em">&nbsp;</div>
        </div>
    </div>
    
</div>
<div style="float:right; width:100%;text-align:right;margin:10px;"><a href="<?php echo(Yii::app()->request->baseUrl); ?>/index.php/barcode?barcode=<?php echo($modelsku->skucode); ?>&quality=200"><IMG SRC="<?php echo(Yii::app()->request->baseUrl); ?>/index.php/barcode?barcode=<?php echo($modelsku->skucode); ?>&quality=75" /></a><?php if($image) echo CHtml::image($image,'',array('alt'=>'Gallery'));?>
</div>
<br>
<h4> Sku Metals </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skumetals-grid',
	'dataProvider'=>new CActiveDataProvider('Skumetals', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'summaryText'=>'',
	'columns'=>array(
		array('name'=>'idskumetals','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','value'=>'$data->idsku0->skucode'),
		array('name'=>'idmetal','value'=>'$data->idmetal0->namevar'),
            array('name'=>'metal','header'=>'Metal','value'=>'$data->idmetal0->idmetalm0->name'),
            array('name'=>'metalstamp','header'=>'MetalStamp','value'=>'$data->idmetal0->idmetalstamp0->name'),
		'weight',
		'usage',
		/*
		'lossfactor',
		'cdate',
		'mdate',
		'updby',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateMetal",array("id"=>$data->idskumetals)),array(
                    "onclick"=>"$(\"#updateMetal\").dialog(\"open\"); return false;",
                    "update"=>"#updateMetal",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteMetal",array("id"=>$data->idskumetals))',
                        )
                    )
		),
	),
)); ?>

<div id="updateMetal"></div>
<br>
<h4> Sku Stones </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skustones-grid',
	'dataProvider'=>new CActiveDataProvider('Skustones', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
	'columns'=>array(
		array('name'=>'idstone','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		//array('name'=>'Stone Alias','type'=>'raw','value'=>'$data->idstone0->namevar'),
        array('name'=>'stone','header'=>'Stone','value'=>'$data->idstone0->idstonem0->name'),
        array('name'=>'shape','header'=>'Shape','value'=>'$data->idstone0->idshape0->name'),
        array('name'=>'grade','header'=>'Grade','value'=>'$data->idstone0->quality'),
        array('name'=>'size','header'=>'Size','value'=>'$data->idstone0->idstonesize0->size'),
        array('name'=>'curcost','header'=>'Price /Ct','value'=>'($data->idstone0->weight!=0)?round($data->idstone0->curcost/$data->idstone0->weight,2):""'),

//            array('name'=>'height','header'=>'Height','value'=>'$data->height'),
//            array('name'=>'mmsize','header'=>'MM','value'=>'$data->mmsize'),
//            array('name'=>'dia','header'=>'Dia','value'=>'$data->diasize'),
        array('name'=>'weight','header'=>'Weight','value'=>'$data->idstone0->weight*$data->pieces'),
		'pieces',
        array('name'=>'idsetting','header'=>'Setting','value'=>'$data->idsetting0->name'),
		/*array('name'=>'idsetting','type'=>'raw','value'=>'$data->idsetting0->name'),
		'type',
		
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'creatmeth',
		'treatmeth',
		'cdate',
		'mdate',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::link("update","javascript:void(0);",array(
                         "onClick"=>CHtml::ajax(array
                   (
                       "url"=>Yii::app()->createUrl("product/updateStone",array("id"=>$data->idskustones)),
                       "success"=>"function(data){jQuery(\'#updateStone\').html(data).dialog(\'open\');return false;}",
                       "update"=>"#updateStone",
                                            
                    ) 
                     )
            ))'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteStone",array("id"=>$data->idskustones))',
                        )
                    )
		),
	),
)); ?>

<div id="updateStone"></div>
<br>
<h4> Sku Findings </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skufindings-grid',
	'dataProvider'=>new CActiveDataProvider('Skufindings', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
	'columns'=>array(
		array('name'=>'idskufindings','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		array('name'=>'idfinding','type'=>'raw','value'=>'$data->idfinding0->name'),
            array('name'=>'metal','header'=>'Metal','type'=>'raw','value'=>'($data->idfinding0->idmetal0)?$data->idfinding0->idmetal0->namevar:NULL'),
            array('name'=>'weight','header'=>'Wt','type'=>'raw','value'=>'($data->idfinding0->weight)?$data->idfinding0->weight:NULL'),
		'qty',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
                /*
		'updby',
		'cdate',
		'name',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateFinding",array("id"=>$data->idskufindings)),array(
                    "onclick"=>"$(\"#updateFinding\").dialog(\"open\"); return false;",
                    "update"=>"#updateFinding",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteFinding",array("id"=>$data->idskufindings))',
                        )
                    )
		),
	),
)); ?>

<div id="updateFinding"></div>
<br>
<h4> Sku Addon </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skuaddon-grid',
	'dataProvider'=>new CActiveDataProvider('Skuaddon', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'summaryText'=>'',
	'columns'=>array(
		array('name'=>'idskuaddon','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		array('name'=>'idcostaddon','type'=>'raw','value'=>'$data->idcostaddon0->name'),
            array('name'=>'type','value'=>'$data->idcostaddon0->type'),
		'qty',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		/*
		'cdate',
		'mdate',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateAddon",array("id"=>$data->idskuaddon)),array(
                    "onclick"=>"$(\"#updateAddon\").dialog(\"open\"); return false;",
                    "update"=>"#updateAddon",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteAddon",array("id"=>$data->idskuaddon))',
                        )
                    )
		),
	),
)); ?>


<div id="updateAddon"></div>
<br>
<h4> Sku Seller Data </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skuselmap-grid',
	'dataProvider'=>new CActiveDataProvider('Skuselmap', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
	'columns'=>array(
		array('name'=>'idskuselmap','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		array('name'=>'idclient','type'=>'raw','value'=>'$data->idclient0->name'),
		'clientcode',
		'csname',
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateSelmap",array("id"=>$data->idskuselmap)),array(
                    "onclick"=>"$(\"#updateSelmap\").dialog(\"open\"); return false;",
                    "update"=>"#updateSelmap",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteSelmap",array("id"=>$data->idskuselmap))',
                        )
                    )
		),
	),
)); ?>


<div id="updateSelmap"></div>
<br>
<h4> Sku Images </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skuimage-grid',
	'dataProvider'=>new CActiveDataProvider('Skuimages', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
	'columns'=>array(
		array('name'=>'idskuimages','header'=>'id'),
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		array('name'=>'idclient','type'=>'raw','value'=>'($data->idclient0)?$data->idclient0->name:NULL'),
                array('name'=>'image','type'=>'image','value'=>'$data->imageThumbUrl'),
                array('name'=>'image','header'=>'Image Name'),
		'imgalt',
		'type',
                array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateImage",array("id"=>$data->idskuimages)),array(
                    "onclick"=>"$(\"#updateImage\").dialog(\"open\"); return false;",
                    "update"=>"#updateImage",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("product/deleteImage",array("id"=>$data->idskuimages))',
                        )
                    )
		),
	),
)); ?>


<div id="updateImage"></div>
<br>

<h4> Sku Reviews </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'skureviews-grid',
    'dataProvider'=>new CActiveDataProvider('Skureviews', array(
                'criteria'=>array(
                'condition'=>'idsku='.$modelsku->idsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'columns'=>array(
        array('name'=>'idskureview','header'=>'id'),
        array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
        'mdate',
        'reviews',
        array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'), 
        array('type'=>'raw',
            'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("product/updateReview",array("id"=>$data->idskureview)),array(
                "onclick"=>"$(\"#updateReview\").dialog(\"open\"); return false;",
                "update"=>"#updateReview",
        ));'),
        array(
            'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("product/deleteReview",array("id"=>$data->idskureview))',
                    )
                )
        ),
    ),
)); ?>


<div id="updateReview"></div>
<br>

<div id="message"></div>
<label>SKU VERIFIED</label>
<?php echo CHtml::activeCheckbox($modelsku,'review',array('ajax'=>array(
   'url'=>$this->createUrl("product/review"),
   'type'=>'POST',
   'beforeSend'=>'function(){
                    var msg  = "Are you sure?";
                    var a = confirm(msg);
                    if(a==false){
                        return false;
                    }
                }',
    "data"=>array('idsku'=>$_GET['id']),
    "success"=>"function(data){
         if(data=='success'){
                if($('#Sku_review').is(':checked'))
                    $('#Sku_review').prop('checked', false);
                else
                    $('#Sku_review').prop('checked', true);
                     
             $('#message').html('Action completed successfully!');
             $('#message').fadeIn().fadeOut(3000);
             location.href='".$this->createUrl('product/admin')."';
         }
     }", 
   ))
  );
?>