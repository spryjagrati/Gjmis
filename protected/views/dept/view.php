<?php
$this->breadcrumbs=array(
	'Depts'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'List Dept', 'url'=>array('index')),
	array('label'=>'Create Dept', 'url'=>array('create')),
	array('label'=>'Update Dept', 'url'=>array('update', 'id'=>$model->iddept)),
	array('label'=>'Delete Dept', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->iddept),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>View Dept #<?php echo $model->iddept; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'iddept',
		'name',
		'location',
		//'type',
            array('name'=>'type','header'=>'Type','type'=>'raw','value'=>$model->getDeptTypeLabel($model->type)),
	),
)); ?>
