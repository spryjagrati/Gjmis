<?php
$this->breadcrumbs=array(
	'Skuselmaps'=>array('index'),
	$model->idskuselmap,
);

$this->menu=array(
	//array('label'=>'List Skuselmap', 'url'=>array('index')),
	array('label'=>'Create Skuselmap', 'url'=>array('create')),
	array('label'=>'Update Skuselmap', 'url'=>array('update', 'id'=>$model->idskuselmap)),
	array('label'=>'Delete Skuselmap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskuselmap),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skuselmap', 'url'=>array('admin')),
);
?>

<h1>View Skuselmap #<?php echo $model->idskuselmap; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskuselmap',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>$model->idsku0->skucode),
		array('name'=>'idclient','type'=>'raw','value'=>$model->idclient0->name),
		'clientcode',
		'csname',
	),
)); ?>
