<?php
$this->breadcrumbs=array(
	'Poskustatuses'=>array('index'),
	$model->idposkustatus,
);

$this->menu=array(
	//array('label'=>'List Poskustatus', 'url'=>array('index')),
	array('label'=>'Create Poskustatus', 'url'=>array('create')),
	array('label'=>'Update Poskustatus', 'url'=>array('update', 'id'=>$model->idposkustatus)),
	array('label'=>'Delete Poskustatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idposkustatus),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Poskustatus', 'url'=>array('admin')),
);
?>

<h1>View Poskustatus #<?php echo $model->idposkustatus; ?></h1>
<span class="required"><?php echo Yii::app()->user->getFlash('poskustatuslog',''); ?></span>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idposkustatus',
		'idposku',
		'reqdqty',
		'processqty',
		'delqty',
		array('name'=>'idprocdept','type'=>'raw','value'=>$model->idprocdept0->locname),
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'rcvddate',
		'dlvddate',
		array('name'=>'idstatusm','type'=>'raw','value'=>$model->idstatusm0->name),
	),
)); ?>
