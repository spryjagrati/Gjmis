<?php
$this->breadcrumbs=array(
	'Metals'=>array('index'),
	$model->idmetal,
);

$this->menu=array(
	//array('label'=>'List Metal', 'url'=>array('index')),
	array('label'=>'Create Metal', 'url'=>array('create')),
	array('label'=>'Update Metal', 'url'=>array('update', 'id'=>$model->idmetal)),
	array('label'=>'Delete Metal', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmetal),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Metal', 'url'=>array('admin')),
);
?>

<h1>View Metal #<?php echo $model->idmetal; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmetal',
            'namevar',
		//'idmetalm',
            array('name'=>'idmetalm','value'=>$model->idmetalm0->name),
		//'idmetalstamp',
            array('name'=>'idmetalstamp','value'=>$model->idmetalstamp0->name),
		'currentcost',
		'prevcost',
            'chemcost',
		'cdate',
		'mdate',
		//'updby',
            array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'lossfactor',
	),
)); ?>
