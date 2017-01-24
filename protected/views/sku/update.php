<?php
$this->breadcrumbs=array(
	'Skus'=>array('index'),
	$model->idsku=>array('view','id'=>$model->idsku),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Sku', 'url'=>array('index')),
	array('label'=>'Create Sku', 'url'=>array('create')),
	array('label'=>'View Sku', 'url'=>array('view', 'id'=>$model->idsku)),
	array('label'=>'Manage Sku', 'url'=>array('admin')),
);
?>

<h1>Update Sku <?php echo $model->idsku; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>