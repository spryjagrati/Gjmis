<?php
$this->breadcrumbs=array(
	'Poskustones'=>array('index'),
	$model->idtbl_poskustones,
);

$this->menu=array(
	//array('label'=>'List Poskustones', 'url'=>array('index')),
	array('label'=>'Create Poskustones', 'url'=>array('create')),
	array('label'=>'Update Poskustones', 'url'=>array('update', 'id'=>$model->idtbl_poskustones)),
	array('label'=>'Delete Poskustones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idtbl_poskustones),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Poskustones', 'url'=>array('admin')),
);
?>

<h1>View Poskustones #<?php echo $model->idtbl_poskustones; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idtbl_poskustones',
		'idposku',
		'idskustone',
		'idstone',
		'cdate',
		'mdate',
		'updby',
	),
)); ?>
