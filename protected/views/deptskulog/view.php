<?php
$this->breadcrumbs=array(
	'Deptskulogs'=>array('index'),
	$model->iddeptskulog,
);

$this->menu=array(
	array('label'=>'Create Deptskulog', 'url'=>array('create')),
	array('label'=>'Update Deptskulog', 'url'=>array('update', 'id'=>$model->iddeptskulog)),
	array('label'=>'Delete Deptskulog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddeptskulog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Deptskulog', 'url'=>array('admin')),
);
?>

<h1>View Deptskulog #<?php echo $model->iddeptskulog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'iddeptskulog',
		'iddept',
		'idsku',
		'qty',
		'po_num',
		'cdate',
		'mdate',
		'updby',
		'refrcvd',
		'refsent',
	),
)); ?>
