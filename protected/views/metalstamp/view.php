<?php
$this->breadcrumbs=array(
	'Metalstamps'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Metalstamp', 'url'=>array('index')),
	array('label'=>'Create Metalstamp', 'url'=>array('create')),
	array('label'=>'Update Metalstamp', 'url'=>array('update', 'id'=>$model->idmetalstamp)),
	array('label'=>'Delete Metalstamp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmetalstamp),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Metalstamp', 'url'=>array('admin')),
);
?>

<h1>View Metalstamp #<?php echo $model->idmetalstamp; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmetalstamp',
		'name',
		'purity',
	),
)); ?>
