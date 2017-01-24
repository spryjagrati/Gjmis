<?php
$this->breadcrumbs=array(
	'Memos'=>array('index'),
	$model->idmemo,
);

$this->menu=array(
	array('label'=>'List Memo', 'url'=>array('index')),
	array('label'=>'Create Memo', 'url'=>array('create')),
	array('label'=>'Update Memo', 'url'=>array('update', 'id'=>$model->idmemo)),
	array('label'=>'Delete Memo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmemo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Memo', 'url'=>array('admin')),
);
?>

<h1>View Memo #<?php echo $model->idmemo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmemo',
		'code',
		'iddptfrom',
		'memoto',
		'remark',
		'status',
		'type',
		'memoreturn',
		'returndate',
		'cdate',
		'mdate',
		'createdby',
		'updatedby',
	),
)); ?>
