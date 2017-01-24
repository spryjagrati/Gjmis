<?php
$this->breadcrumbs=array(
	'Shapes'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Shape', 'url'=>array('index')),
	array('label'=>'Create Shape', 'url'=>array('create')),
	array('label'=>'Update Shape', 'url'=>array('update', 'id'=>$model->idshape)),
	array('label'=>'Delete Shape', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idshape),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shape', 'url'=>array('admin')),
);
?>

<h1>View Shape #<?php echo $model->idshape; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idshape',
		'name',
	),
)); ?>
