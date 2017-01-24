<?php
$this->breadcrumbs=array(
	'Metalms'=>array('index'),
	$model->name=>array('view','id'=>$model->idmetalm),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Metalm', 'url'=>array('index')),
	array('label'=>'Create Metalm', 'url'=>array('create')),
	array('label'=>'View Metalm', 'url'=>array('view', 'id'=>$model->idmetalm)),
	array('label'=>'Manage Metalm', 'url'=>array('admin')),
);
?>

<h1>Update Metalm <?php echo $model->idmetalm; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>