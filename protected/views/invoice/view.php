<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->idinvoice,
);

$this->menu=array(
//	array('label'=>'List Invoice', 'url'=>array('index')),
	array('label'=>'Create Invoice', 'url'=>array('create')),
	array('label'=>'Update Invoice', 'url'=>array('update', 'id'=>$model->idinvoice)),
	array('label'=>'Delete Invoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idinvoice),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);
?>

<h1>View Invoice #<?php echo $model->idinvoice; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idinvoice',
		'idlocation',
		'cdate',
		'mdate',
		'updby',
		'activ',
	),
)); ?>
