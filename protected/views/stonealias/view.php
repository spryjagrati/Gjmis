<?php
/* @var $this StonealiasController */
/* @var $model Stonealias */

$this->breadcrumbs=array(
	'Stonealiases'=>array('index'),
	$model->idstone_alias,
);

$this->menu=array(
	array('label'=>'List Stonealias', 'url'=>array('index')),
	array('label'=>'Create Stonealias', 'url'=>array('create')),
	array('label'=>'Update Stonealias', 'url'=>array('update', 'id'=>$model->idstone_alias)),
	array('label'=>'Delete Stonealias', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstone_alias),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stonealias', 'url'=>array('admin')),
);
?>

<h1>View Stonealias #<?php echo $model->idstone_alias; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstone_alias',
		'idstonem',
		'export',
		'idproperty',
		'alias',
	),
)); ?>
