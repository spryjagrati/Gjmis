<?php
$this->breadcrumbs=array(
	'Stonecostlogs'=>array('index'),
	$model->idstonecostlog,
);

$this->menu=array(
	//array('label'=>'List Stonecostlog', 'url'=>array('index')),
	array('label'=>'Create Stonecostlog', 'url'=>array('create')),
	array('label'=>'Update Stonecostlog', 'url'=>array('update', 'id'=>$model->idstonecostlog)),
	array('label'=>'Delete Stonecostlog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstonecostlog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stonecostlog', 'url'=>array('admin')),
);
?>

<h1>View Stonecostlog #<?php echo $model->idstonecostlog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstonecostlog',
		'idstone',
		'cdate',
		'mdate',
		'updby',
		'cost',
	),
)); ?>
