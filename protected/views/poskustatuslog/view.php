<?php
$this->breadcrumbs=array(
	'Poskustatuslogs'=>array('index'),
	$model->idposkustatuslog,
);

$this->menu=array(
	//array('label'=>'List Poskustatuslog', 'url'=>array('index')),
	array('label'=>'Create Poskustatuslog', 'url'=>array('create')),
	array('label'=>'Update Poskustatuslog', 'url'=>array('update', 'id'=>$model->idposkustatuslog)),
	array('label'=>'Delete Poskustatuslog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idposkustatuslog),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Poskustatuslog', 'url'=>array('admin')),
);
?>

<h1>View Poskustatuslog #<?php echo $model->idposkustatuslog; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idposkustatuslog',
		'idposku',
		'reqdqty',
		'processqty',
		'delqty',
		'idprocdept',
		'cdate',
		'mdate',
		'updby',
		'rcvddate',
		'dlvddate',
		'idstatusm',
		'descrip',
		'remark',
	),
)); ?>
