<?php
$this->breadcrumbs=array(
	'Deptchemlogs'=>array('index'),
	$model->iddeptchemlog,
);

$this->menu=array(
	//array('label'=>'List Deptchemlog', 'url'=>array('index')),
	array('label'=>'Create Deptchemstocks', 'url'=>array('createstocks')),
	array('label'=>'Update Deptchemstocks', 'url'=>array('updatestocks', 'id'=>$model->iddeptchemlog)),
	array('label'=>'Manage Deptchemstocks', 'url'=>array('admin')),
);
?>

<h1>View Deptchemstocks #<?php echo $model->iddeptchemlog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'iddeptchemlog',
		'idchemical',
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
