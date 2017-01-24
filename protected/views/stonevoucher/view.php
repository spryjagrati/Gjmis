<?php
$this->breadcrumbs=array(
	'Stonevouchers'=>array('index'),
	$model->idstonevoucher,
);

$this->menu=array(
	array('label'=>'Create Stonevoucher', 'url'=>array('create')),
	array('label'=>'Update Stonevoucher', 'url'=>array('update', 'id'=>$model->idstonevoucher)),
	array('label'=>'Manage Stonevoucher', 'url'=>array('admin')),
);
?>

<h1>View Stonevoucher #<?php echo $model->idstonevoucher; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstonevoucher',
		'issuedto',
		'issuedfrom',
		'cdate',
		'mdate',
		'code',
		'acknow',
	),
)); ?>
