<?php
$this->breadcrumbs=array(
	'Deptmetallogs'=>array('index'),
	$model->iddeptmetallog,
);

$this->menu=array(
	//array('label'=>'List Deptmetallog', 'url'=>array('index')),
	array('label'=>'Create Deptmetalstocks', 'url'=>array('createstocks')),
	array('label'=>'Update Deptmetalstocks', 'url'=>array('updatestocks', 'id'=>$model->iddeptmetallog)),
	array('label'=>'Manage Deptmetalstocks', 'url'=>array('admin')),
);
?>

<h1>View Deptmetalstocks #<?php echo $model->iddeptmetallog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'iddeptmetallog',
		'idmetal',
		'iddept',
		'qty',
		'cunit',
		'idpo',
		'cdate',
		'mdate',
		'updby',
		'refrcvd',
		'refsent',
	),
)); ?>
