<?php
$this->breadcrumbs=array(
	'po'=>array('admin'),
	'Maintain',
);

$this->menu=array(
	array('label'=>'Manage POs', 'url'=>array('purchaseOrder/admin')),
    array('label'=>'Process PO', 'url'=>array('purchaseOrder/process','id'=>$modelpo->idpo)),
    array('label'=>'Requirements for PO', 'url'=>array('purchaseOrder/requirements','id'=>$modelpo->idpo)),
    array('label'=>'Export PO', 'url'=>array('purchaseOrder/export','id'=>$modelpo->idpo)),
);
?>
<h1>Purchase Order #<?php echo $modelpo->idpo; ?></h1>
<h4>Newly added items would not be update-able right away after creation, please revisit the page to update through the links provided in list.</h4>

<?php if(Yii::app()->user->hasFlash('posku')){ ?>
        <span class="required"><?php echo Yii::app()->user->getFlash('posku',''); ?></span>
<?php
        echo '<br /><br />';
}
$tabs=array();
$tabs['Update Po']=$this->renderPartial("_form_po", array("model"=>$modelpo), true);
$tabs['Add Item']=$this->renderPartial("_form_sku", array("model"=>$modelposku), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
        //'selected'=>-1,
        //'ajaxOptions'=>array('async'=>true),
        //'idPrefix'=>'ui-tabs-',
    ),
));
?>
<!-- cost fetch div -->
<div class="uniForm" style="width:60%;">
    <div class="buttonHolder" style="width:100%;margin:0;">
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'pocostcalc-form','action'=>$this->createUrl('purchaseOrder/fetchCost/'.$modelpo->idpo),
                'enableAjaxValidation'=>false,
        )); ?>
        <?php echo CHtml::ajaxSubmitButton('Get Current Amt',array('purchaseOrder/fetchCost/'.$modelpo->idpo),array('update'=>'#okMsg'),array('id'=>'po-cost-getter','class'=>'primaryAction', 'style'=>'width:50%;float:left;')); ?>
        <?php $this->endWidget(); ?>
        $<div id="okMsg" style="width:20%;float:right;margin:0;font-size:17px;padding:0.5em">&nbsp;</div>
    </div>
</div>
<br>
<h4> PO Items </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'poskus-grid',
	'dataProvider'=>new CActiveDataProvider('Poskus', array(
                'criteria'=>array(
                'condition'=>'idpo='.$modelpo->idpo,
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        )),
	'columns'=>array(
		array('name'=>'idposkus','header'=>'id'),
		array('name'=>'idsku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		'totamt',
		'reforder',
		'usnum',
		'qty',
                'refno',
		'custsku',
		'appmetwt',
		'itemtype',
		'itemmetal',
		'metalstamp',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		/*
		'stonevar',
		'descrip',
		'ext',
		'remark',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("purchaseOrder/updateItem",array("id"=>$data->idposkus)),array(
                    "onclick"=>"$(\"#updateItem\").dialog(\"open\"); return false;",
                    "update"=>"#updateItem",
            ));'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("purchaseOrder/deleteItem",array("id"=>$data->idposkus))',
                        )
                    )
		),
	),
)); ?>

<div id="updateItem"></div>
<br>

<h2>Sku Search Widget</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sku-grid',
	'dataProvider'=>$modelsku->search(),
	'filter'=>$modelsku,
	'columns'=>array(
		'idsku',
		'skucode',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'refpo',
		'totmetalwei',
		'totstowei',
		'numstones',
		/*
		'leadtime',
		'parentsku',
		'parentrel',
		'taxcode',
		'dimunit',
		'dimdia',
		'dimhei',
		'dimwid',
		'dimlen',
		'metweiunit',
		'stoweiunit',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("$$",Yii::app()->createUrl("product/fetchCostDisplay",array("id"=>$data->idsku)),array(
                    "update"=>"#skuCostDisplay",
                ));',
                'htmlOptions'=>array('style'=>'width:3%;'),
                ),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{update}',
                    'buttons'=>array(
                        'update'=>array(
                            'url'=>'Yii::app()->createUrl("product/maintain",array("id"=>$data->idsku))',
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width:3%;'),
		),
	),
)); ?>

<h2><div id="skuCostDisplay"></div></h2>