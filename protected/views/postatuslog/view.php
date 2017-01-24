<?php
$this->breadcrumbs=array(
	'Postatuslogs'=>array('index'),
	$model->idpostatuslog,
);

$this->menu=array(
	//array('label'=>'List Postatuslog', 'url'=>array('index')),
	array('label'=>'Create Postatuslog', 'url'=>array('create')),
	array('label'=>'Update Postatuslog', 'url'=>array('update', 'id'=>$model->idpostatuslog)),
	array('label'=>'Delete Postatuslog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idpostatuslog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Postatuslog', 'url'=>array('admin')),
);
?>

<h1>View Postatuslog #<?php echo $model->idpostatuslog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idpostatuslog',
		'idpo',
		'cdate',
		'mdate',
		'updby',
		'idstatusm',
		'instructions',
	),
)); ?>
