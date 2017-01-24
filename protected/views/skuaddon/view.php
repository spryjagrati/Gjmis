<?php
$this->breadcrumbs=array(
	'Skuaddons'=>array('index'),
	$model->idskuaddon,
);

$this->menu=array(
	//array('label'=>'List Skuaddon', 'url'=>array('index')),
	array('label'=>'Create Skuaddon', 'url'=>array('create')),
	array('label'=>'Update Skuaddon', 'url'=>array('update', 'id'=>$model->idskuaddon)),
	array('label'=>'Delete Skuaddon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskuaddon),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skuaddon', 'url'=>array('admin')),
);
?>

<h1>View Skuaddon #<?php echo $model->idskuaddon; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskuaddon',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>$model->idsku0->skucode),
                array('name'=>'idcostaddon','type'=>'raw','value'=>$model->idcostaddon0->name),
		'qty',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
	),
)); ?>
