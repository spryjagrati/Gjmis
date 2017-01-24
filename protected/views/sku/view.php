<?php
$this->breadcrumbs=array(
	'Skus'=>array('index'),
	$model->idsku,
);

$this->menu=array(
	//array('label'=>'List Sku', 'url'=>array('index')),
	array('label'=>'Create Sku', 'url'=>array('create')),
	array('label'=>'Update Sku', 'url'=>array('update', 'id'=>$model->idsku)),
	array('label'=>'Delete Sku', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idsku),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sku', 'url'=>array('admin')),
    array('label'=>'Create content', 'url'=>array('skucontent/create','idsku'=>$model->idsku)),
);
?>

<h1>View Sku #<?php echo $model->idsku; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idsku',
		'skucode',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'leadtime',
		'refpo',
		'parentsku',
		'parentrel',
		'taxcode',
		'dimunit',
		'dimdia',
		'dimhei',
		'dimwid',
		'dimlen',
		'totmetalwei',
		'metweiunit',
		'totstowei',
		'stoweiunit',
		'numstones',
	),
)); ?>
