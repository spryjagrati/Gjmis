<?php
$this->breadcrumbs=array(
	'Findings'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Finding', 'url'=>array('index')),
	array('label'=>'Create Finding', 'url'=>array('create')),
	array('label'=>'Update Finding', 'url'=>array('update', 'id'=>$model->idfinding)),
	array('label'=>'Delete Finding', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idfinding),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Finding', 'url'=>array('admin')),
);
?>

<h1>View Finding #<?php echo $model->idfinding; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idfinding',
		'name',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>($model->idmetal0)?$model->idmetal0->namevar:NULL),
		'weight',
		'cost',
		'cdate',
		'mdate',
            'size',
            array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'descri',
            'supplier',
	),
)); ?>
