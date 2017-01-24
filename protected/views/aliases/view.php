<?php
/* @var $this AliasesController */
/* @var $model Aliases */

$this->breadcrumbs=array(
	'Aliases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Aliases', 'url'=>array('index')),
	array('label'=>'Create Aliases', 'url'=>array('create')),
	array('label'=>'Update Aliases', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Aliases', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Aliases', 'url'=>array('admin')),
);
?>

<h1>View Aliases #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'aTarget',
		'aField',
		'initial',
		'alias',
	),
)); ?>
