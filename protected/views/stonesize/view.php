<?php
$this->breadcrumbs=array(
	'Stonesizes'=>array('index'),
	$model->idstonesize,
);

$this->menu=array(
	//array('label'=>'List Stonesize', 'url'=>array('index')),
	array('label'=>'Create Stonesize', 'url'=>array('create')),
	array('label'=>'Update Stonesize', 'url'=>array('update', 'id'=>$model->idstonesize)),
	array('label'=>'Delete Stonesize', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstonesize),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stonesize', 'url'=>array('admin')),
);
?>

<h1>View Stonesize #<?php echo $model->idstonesize; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstonesize',
		'size',
	),
)); ?>
