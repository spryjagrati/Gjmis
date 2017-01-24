<?php
$this->breadcrumbs=array(
	'Skumetals'=>array('index'),
	$model->idskumetals,
);

$this->menu=array(
	//array('label'=>'List Skumetals', 'url'=>array('index')),
	array('label'=>'Create Skumetals', 'url'=>array('create')),
	array('label'=>'Update Skumetals', 'url'=>array('update', 'id'=>$model->idskumetals)),
	array('label'=>'Delete Skumetals', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idskumetals),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Skumetals', 'url'=>array('admin')),
);
?>

<h1>View Skumetals #<?php echo $model->idskumetals; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idskumetals',
		array('name'=>'idsku','type'=>'raw','value'=>$model->idsku0->skucode),
		array('name'=>'idmetal','type'=>'raw','value'=>$model->idmetal0->namevar),
		'weight',
		'usage',
		'lossfactor',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
	),
)); ?>
