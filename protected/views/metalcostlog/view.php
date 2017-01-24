<?php
$this->breadcrumbs=array(
	'Metalcostlogs'=>array('index'),
	$model->idmetalcostlog,
);

$this->menu=array(
	//array('label'=>'List Metalcostlog', 'url'=>array('index')),
	array('label'=>'Create Metalcostlog', 'url'=>array('create')),
	array('label'=>'Update Metalcostlog', 'url'=>array('update', 'id'=>$model->idmetalcostlog)),
	array('label'=>'Delete Metalcostlog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmetalcostlog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Metalcostlog', 'url'=>array('admin')),
);
?>

<h1>View Metalcostlog #<?php echo $model->idmetalcostlog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmetalcostlog',
		'idmetal',
		'cdate',
		'mdate',
		'cost',
		'updby',
	),
)); ?>
