<?php
$this->breadcrumbs=array(
	'Chemicals'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Chemical', 'url'=>array('index')),
	array('label'=>'Create Chemical', 'url'=>array('create')),
	array('label'=>'Update Chemical', 'url'=>array('update', 'id'=>$model->idchemical)),
	array('label'=>'Delete Chemical', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idchemical),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chemical', 'url'=>array('admin')),
);
?>

<h1>View Chemical #<?php echo $model->idchemical; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idchemical',
		'name',
		'weiunit',
	),
)); ?>
