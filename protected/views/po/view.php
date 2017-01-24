<?php
$this->breadcrumbs=array(
	'Pos'=>array('index'),
	$model->idpo,
);

$this->menu=array(
	//array('label'=>'List Po', 'url'=>array('index')),
	//array('label'=>'Create Po', 'url'=>array('create')),
	array('label'=>'Update Po', 'url'=>array('update', 'id'=>$model->idpo)),
	array('label'=>'Delete Po', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idpo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Maintain POs', 'url'=>array('purchaseOrder/admin')),
        array('label'=>'Maintain this PO', 'url'=>array('purchaseOrder/maintain','id'=>$model->idpo)),
);
?>

<h1>View Po #<?php echo $model->idpo; ?></h1>
<span class="required"><?php echo Yii::app()->user->getFlash('postatuslog',''); ?></span>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idpo',
		array('name'=>'idclient','type'=>'raw','value'=>$model->idclient0->name),
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		array('name'=>'idstatusm','type'=>'raw','value'=>$model->idstatusm0->name),
		'dlvddate',
		'startdate',
		'totamt',
		'instructions',
	),
)); ?>
