<?php
$this->breadcrumbs=array(
	'Matreqs'=>array('index'),
	$model->idmatreq,
);

$this->menu=array(
	//array('label'=>'List Matreq', 'url'=>array('index')),
	array('label'=>'Create Matreq', 'url'=>array('create')),
	array('label'=>'Update Matreq', 'url'=>array('update', 'id'=>$model->idmatreq)),
	array('label'=>'Delete Matreq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idmatreq),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Matreq', 'url'=>array('admin')),
);
?>

<h1>View Matreq #<?php echo $model->idmatreq; ?></h1>
<span class="required"><?php echo Yii::app()->user->getFlash('matreqlog',''); ?></span>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idmatreq',
		'idpo',
		'type',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>($model->idmetal0)?$model->idmetal0->namevar:NULL),
            array('name'=>'idstone','header'=>'Stone','type'=>'raw','value'=>($model->idstone0)?$model->idstone0->namevar:NULL),
            array('name'=>'idchemical','header'=>'Chemical','type'=>'raw','value'=>($model->idchemical0)?$model->idchemical0->name:NULL),
            array('name'=>'idfinding','header'=>'Finding','type'=>'raw','value'=>($model->idfinding0)?$model->idfinding0->name:NULL),
            array('name'=>'idstatusm','header'=>'Status','type'=>'raw','value'=>($model->idstatusm0)?$model->idstatusm0->name:NULL),
		'cdate',
		'mdate',
		'sdate',
		'edate',
		'estdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
            array('name'=>'reqby','type'=>'raw','value'=>$model->reqby0->locname),
            array('name'=>'reqto','type'=>'raw','value'=>$model->reqto0->locname),
		'notes',
		'rqty',
		'fqty',
		'qunit',
	),
)); ?>
