<?php
$this->breadcrumbs=array(
	'Metalms'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Metalm', 'url'=>array('index')),
	array('label'=>'Create Metalm', 'url'=>array('create')),
	array('label'=>'Update Metalm', 'url'=>array('update', 'id'=>$model->idmetalm)),
	array('label'=>'Delete Metalm', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmetalm),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Metalm', 'url'=>array('admin')),
);
?>

<h1>View Metalm #<?php echo $model->idmetalm; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmetalm',
		'name',
	),
)); ?>
