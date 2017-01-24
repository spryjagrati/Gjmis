<?php
$this->breadcrumbs=array(
	'Deptstonelogs'=>array('index'),
	$model->iddeptstonelog,
);

$this->menu=array(
	//array('label'=>'List Deptstonelog', 'url'=>array('index')),
	array('label'=>'Create Deptstonestocks', 'url'=>array('stockscreate')),
	array('label'=>'Update Deptstonestocks', 'url'=>array('stocksupdate', 'id'=>$model->iddeptstonelog)),
	array('label'=>'Manage Deptstonestocks', 'url'=>array('admin')),
);
?>

<h1>View Deptstonestocks #<?php echo $model->iddeptstonelog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'iddeptstonelog',
		'iddept',
		'idstone',
		'qty',
		'idpo',
		'cdate',
		'mdate',
		'updby',
		'refrcvd',
		'refsent',
	),
)); ?>
