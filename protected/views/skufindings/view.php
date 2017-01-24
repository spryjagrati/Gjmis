<?php
$this->breadcrumbs=array(
	'Skufindings'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Skufindings', 'url'=>array('index')),
	array('label'=>'Create Skufindings', 'url'=>array('create')),
	array('label'=>'Update Skufindings', 'url'=>array('update', 'id'=>$model->idskufindings)),
	array('label'=>'Delete Skufindings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskufindings),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skufindings', 'url'=>array('admin')),
);
?>

<h1>View Skufindings #<?php echo $model->idskufindings; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskufindings',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>$model->idsku0->skucode),
		array('name'=>'idfinding','type'=>'raw','value'=>$model->idfinding0->name),
		'qty',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'name',
	),
)); ?>
