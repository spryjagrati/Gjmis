<?php
$this->breadcrumbs=array(
	'Skucontents'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Skucontent', 'url'=>array('index')),
	array('label'=>'Create Skucontent', 'url'=>array('create')),
	array('label'=>'Update Skucontent', 'url'=>array('update', 'id'=>$model->idskucontent)),
	array('label'=>'Delete Skucontent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskucontent),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skucontent', 'url'=>array('admin')),
);
?>

<h1>View Skucontent #<?php echo $model->idskucontent; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskucontent',
		'idsku',
		'name',
		'brand',
		'descr',
		'type',
		'usedfor',
		'attributedata',
		'targetusers',
		'searchterms',
		'resizable',
		'sizelowrange',
		'sizeupprange',
		'chaintype',
		'clasptype',
		'backfinding',
		'cdate',
		'mdate',
		'updby',
	),
)); ?>
