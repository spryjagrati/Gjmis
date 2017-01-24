<?php
$this->breadcrumbs=array(
	'Skuimages'=>array('index'),
	$model->idskuimages,
);

$this->menu=array(
	//array('label'=>'List Skuimages', 'url'=>array('index')),
	array('label'=>'Create Skuimages', 'url'=>array('create')),
	array('label'=>'Update Skuimages', 'url'=>array('update', 'id'=>$model->idskuimages)),
	array('label'=>'Delete Skuimages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskuimages),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skuimages', 'url'=>array('admin')),
);
?>

<h1>View Skuimages #<?php echo $model->idskuimages; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskuimages',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>$model->idsku0->skucode),
		array('name'=>'idclient','type'=>'raw','value'=>($model->idclient0)?$model->idclient0->name:NULL),
		'image',
		'imgalt',
		'cdate',
		'mdate',
		'type',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
	),
)); ?>
