<?php
$this->breadcrumbs=array(
	'Poskuses'=>array('index'),
	$model->idposkus,
);

$this->menu=array(
	//array('label'=>'List Poskus', 'url'=>array('index')),
	array('label'=>'Create Poskus', 'url'=>array('create')),
	array('label'=>'Update Poskus', 'url'=>array('update', 'id'=>$model->idposkus)),
	array('label'=>'Delete Poskus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idposkus),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Poskus', 'url'=>array('admin')),
);
?>

<h1>View Poskus #<?php echo $model->idposkus; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idposkus',
		'idpo',
		array('name'=>'idsku','type'=>'raw','value'=>$model->idsku0->skucode),
		'qty',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		'totamt',
		//'stonevar',
		'reforder',
		'usnum',
		'descrip',
		'ext',
		'remark',
                'refno',
		'custsku',
		'appmetwt',
		'itemtype',
		'itemmetal',
		'metalstamp',
	),
)); ?>
