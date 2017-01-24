<?php
$this->breadcrumbs=array(
	'Clarities'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Clarity', 'url'=>array('index')),
	array('label'=>'Create Clarity', 'url'=>array('create')),
	array('label'=>'Update Clarity', 'url'=>array('update', 'id'=>$model->idclarity)),
	array('label'=>'Delete Clarity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idclarity),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Clarity', 'url'=>array('admin')),
);
?>

<h1>View Clarity #<?php echo $model->idclarity; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idclarity',
		'name',
	),
)); ?>
