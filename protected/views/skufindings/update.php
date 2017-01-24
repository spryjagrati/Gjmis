<?php
$this->breadcrumbs=array(
	'Skufindings'=>array('index'),
	$model->name=>array('view','id'=>$model->idskufindings),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Skufindings', 'url'=>array('index')),
	array('label'=>'Create Skufindings', 'url'=>array('create')),
	array('label'=>'View Skufindings', 'url'=>array('view', 'id'=>$model->idskufindings)),
	array('label'=>'Manage Skufindings', 'url'=>array('admin')),
);
?>

<h1>Update Skufindings <?php echo $model->idskufindings; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>