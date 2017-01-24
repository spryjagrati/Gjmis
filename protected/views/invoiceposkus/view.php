<?php
$this->breadcrumbs=array(
	'Invoiceposkuses'=>array('index'),
	$model->idinvoiceposkus,
);

$this->menu=array(
	array('label'=>'List Invoiceposkus', 'url'=>array('index')),
	array('label'=>'Create Invoiceposkus', 'url'=>array('create')),
	array('label'=>'Update Invoiceposkus', 'url'=>array('update', 'id'=>$model->idinvoiceposkus)),
	array('label'=>'Delete Invoiceposkus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idinvoiceposkus),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Invoiceposkus', 'url'=>array('admin')),
);
?>

<h1>View Invoiceposkus #<?php echo $model->idinvoiceposkus; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idinvoiceposkus',
		'idinvoice',
		'idposkus',
		'cdate',
		'mdate',
		'updby',
		'activ',
	),
)); ?>
