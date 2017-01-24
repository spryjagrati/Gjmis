<?php
$this->breadcrumbs=array(
	'Stonems'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Stonem', 'url'=>array('index')),
	array('label'=>'Create Stonem', 'url'=>array('create')),
	array('label'=>'Update Stonem', 'url'=>array('update', 'id'=>$model->idstonem)),
	array('label'=>'Delete Stonem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstonem),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stonem', 'url'=>array('admin')),
);
?>

<h1>View Stonem #<?php echo $model->idstonem; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstonem',
		'name',
            'type',
            'scountry',
            'creatmeth',
            'treatmeth',
	),
)); ?>
