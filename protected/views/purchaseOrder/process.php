<?php
$this->breadcrumbs=array(
	'po'=>array('admin'),
	'Process',
);

$this->menu=array(
	array('label'=>'Manage POs', 'url'=>array('purchaseOrder/admin')),
    ($modelpo->idstatusm0->name=='Registered')?array('label'=>'Maintain PO', 'url'=>array('purchaseOrder/maintain','id'=>$modelpo->idpo)):array('label'=>''),
    array('label'=>'Requirements for PO', 'url'=>array('purchaseOrder/requirements','id'=>$modelpo->idpo)),
);
?>
<h1>Process Purchase Order #<?php echo $modelpo->idpo; ?></h1>
<?php
$tabs=array();
$tabs['Update Po']=$this->renderPartial("_form_postatus", array("model"=>$modelpo), true);
//display tabs conditional with status - send tab name, button name by default

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'postatuslog-grid',
	'dataProvider'=>new CActiveDataProvider('Postatuslog', array(
                'criteria'=>array(
                'condition'=>'idpo='.$modelpo->idpo,
                'order'=>'mdate desc',
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        )),
	'columns'=>array(
		array('name'=>'idpostatuslog','header'=>'id'),
		//'idpo',
		//'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		array('name'=>'idstatusm','type'=>'raw','value'=>'$data->idstatusm0->name'),
		'instructions',
	),
)); ?>
<h2> PO Items Status </h2>
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
		'qty',
            array('name'=>'Reqd','value'=>'($data->poskustatus)?$data->poskustatus->reqdqty:""'),
            array('name'=>'Processed','value'=>'($data->poskustatus)?$data->poskustatus->processqty:""'),
            array('name'=>'Delivered','value'=>'($data->poskustatus)?$data->poskustatus->delqty:""'),
            array('name'=>'Dept','value'=>'($data->poskustatus)?$data->poskustatus->idprocdept0->locname:""'),
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'totamt',
            array('name'=>'status','value'=>'($data->poskustatus)?$data->poskustatus->idstatusm0->name:""'),
		/*
		'stonevar',
		'reforder',
		'usnum',
		'descrip',
		'ext',
		'remark',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("purchaseOrder/updateItemStatus",array("id"=>$data->idposkus)),array(
                    "onclick"=>"$(\"#updateItemStatus\").dialog(\"open\"); return false;",
                    "update"=>"#updateItemStatus",
            ));'),
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("logs",Yii::app()->createUrl("purchaseOrder/itemStatusLogs",array("id"=>$data->idposkus)),array(
                    "onclick"=>"$(\"#itemStatusLogs\").dialog(\"open\"); return false;",
                    "update"=>"#itemStatusLogs",
            ));'),
	),
)); ?>

<div id="updateItemStatus"></div>
<br>
<div id="itemStatusLogs"></div>
<br>