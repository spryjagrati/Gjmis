<?php
$this->breadcrumbs=array(
	'Matreqlogs'=>array('index'),
	$model->idtbl_matreqlog,
);

$this->menu=array(
	//array('label'=>'List Matreqlog', 'url'=>array('index')),
	array('label'=>'Create Matreqlog', 'url'=>array('create')),
	array('label'=>'Update Matreqlog', 'url'=>array('update', 'id'=>$model->idtbl_matreqlog)),
	array('label'=>'Delete Matreqlog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idtbl_matreqlog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Matreqlog', 'url'=>array('admin')),
);
?>

<h1>View Matreqlog #<?php echo $model->idtbl_matreqlog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idtbl_matreqlog',
		'idmatreq',
		'cdate',
		'mdate',
		'updby',
		'rqty',
		'fqty',
		'idstatusm',
	),
)); ?>
