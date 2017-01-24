<?php
$this->breadcrumbs=array(
	'Statusms'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Statusm', 'url'=>array('index')),
	array('label'=>'Create Statusm', 'url'=>array('create')),
	array('label'=>'Update Statusm', 'url'=>array('update', 'id'=>$model->idstatusm)),
	array('label'=>'Delete Statusm', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstatusm),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statusm', 'url'=>array('admin')),
);
?>

<h1>View Statusm #<?php echo $model->idstatusm; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstatusm',
		'name',
		'type',
	),
)); ?>
