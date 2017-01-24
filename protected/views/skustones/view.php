<?php
$this->breadcrumbs=array(
	'Skustones'=>array('index'),
	$model->idskustones,
);

$this->menu=array(
	//array('label'=>'List Skustones', 'url'=>array('index')),
	array('label'=>'Create Skustones', 'url'=>array('create')),
	array('label'=>'Update Skustones', 'url'=>array('update', 'id'=>$model->idskustones)),
	array('label'=>'Delete Skustones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskustones),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skustones', 'url'=>array('admin')),
);
?>

<h1>View Skustones #<?php echo $model->idskustones; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskustones',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>$model->idsku0->skucode),
		array('name'=>'idstone','type'=>'raw','value'=>$model->idstone0->namevar),
		'pieces',
		array('name'=>'idsetting','type'=>'raw','value'=>$model->idsetting0->name),
		'type',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
	),
)); ?>
