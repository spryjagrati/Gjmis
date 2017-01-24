<?php
/* @var $this BeadController */
/* @var $model Bead */

$this->breadcrumbs=array(
	'Beads'=>array('index'),
	$model->idbeadsku,
);

$this->menu=array(
	array('label'=>'List Bead', 'url'=>array('index')),
	array('label'=>'Create Bead', 'url'=>array('create')),
	array('label'=>'Update Bead', 'url'=>array('update', 'id'=>$model->idbeadsku)),
	array('label'=>'Delete Bead', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idbeadsku),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bead', 'url'=>array('admin')),
);
?>

<h1>View Bead #<?php echo $model->idbeadsku; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idbeadsku',
		'beadskucode',
		'dimhei',
		'dimwid',
		'dimlen',
		'grosswt',
		'totmetalwei',
		'totstowei',
		'numstones',
		'cdate',
		'mdate',
		'updby',
	),
)); ?>
