<?php
$this->breadcrumbs=array(
	'Deptfindlogs'=>array('index'),
	$model->idtbl_deptfindlog,
);

$this->menu=array(
	array('label'=>'Create Deptfindstocks', 'url'=>array('stockscreate')),
	array('label'=>'Update Deptfindstocks', 'url'=>array('stocksupdate', 'id'=>$model->idtbl_deptfindlog)),
	array('label'=>'Manage Deptfindstocks', 'url'=>array('admin')),
);
?>

<h1>View Deptfindstocks #<?php echo $model->idtbl_deptfindlog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idtbl_deptfindlog',
		'iddept',
		'idfinding',
		'cdate',
		'mdate',
		'refrcvd',
		'refsent',
		'idpo',
		'qty',
	),
)); ?>
