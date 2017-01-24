<?php
$this->breadcrumbs=array(
	'Statusnavs'=>array('index'),
	$model->idstatusnav,
);

$this->menu=array(
	//array('label'=>'List Statusnav', 'url'=>array('index')),
	array('label'=>'Create Statusnav', 'url'=>array('create')),
	array('label'=>'Update Statusnav', 'url'=>array('update', 'id'=>$model->idstatusnav)),
	array('label'=>'Delete Statusnav', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstatusnav),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statusnav', 'url'=>array('admin')),
);
?>

<h1>View Statusnav #<?php echo $model->idstatusnav; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstatusnav',
		array('name'=>'idstatusf','type'=>'raw','value'=>$model->idstatusf0->name),
		array('name'=>'idstatust','type'=>'raw','value'=>$model->idstatust0->name),
	),
)); ?>
