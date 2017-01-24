<?php
$this->breadcrumbs=array(
	'Costadds'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Costadd', 'url'=>array('index')),
	array('label'=>'Create Costadd', 'url'=>array('create')),
	array('label'=>'Update Costadd', 'url'=>array('update', 'id'=>$model->idcostadd)),
	array('label'=>'Delete Costadd', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcostadd),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Costadd', 'url'=>array('admin')),
);
?>

<h1>View Costadd #<?php echo $model->idcostadd; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idcostadd',
		'type',
		'name',
		array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>($model->idmetal0)?$model->idmetal0->namevar:NULL),
		'factormetal',
		//array('name'=>'idstone','header'=>'Stone','type'=>'raw','value'=>($model->idstone0)?$model->idstone0->namevar:NULL),
		//'factorstone',
		//array('name'=>'idchemical','header'=>'Chemical','type'=>'raw','value'=>($model->idchemical0)?$model->idchemical0->name:NULL),
		//'factorchem',
		//array('name'=>'idsetting','header'=>'Setting','type'=>'raw','value'=>($model->idsetting0)?$model->idsetting0->name:NULL),
		//'factorsetting',
		//'factornumsto',
		'fixcost',
		'costformula',
		'threscostformula',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
	),
)); ?>
