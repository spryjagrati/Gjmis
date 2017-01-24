<?php
$this->breadcrumbs=array(
	'Clientparams'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Clientparams', 'url'=>array('index')),
	array('label'=>'Create Clientparams', 'url'=>array('create')),
	array('label'=>'Update Clientparams', 'url'=>array('update', 'id'=>$model->idclientparams)),
	array('label'=>'Delete Clientparams', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idclientparams),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Clientparams', 'url'=>array('admin')),
);
?>

<h1>View Clientparams #<?php echo $model->idclientparams; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idclientparams',
		'idclient',
		'name',
		'defaultval',
		'formula',
		'type',
	),
)); ?>
