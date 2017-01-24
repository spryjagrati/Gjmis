<?php
$this->breadcrumbs=array(
	'Skuimages'=>array('index'),
	$model->idskuimages=>array('view','id'=>$model->idskuimages),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Skuimages', 'url'=>array('index')),
	array('label'=>'Create Skuimages', 'url'=>array('create')),
	array('label'=>'View Skuimages', 'url'=>array('view', 'id'=>$model->idskuimages)),
	array('label'=>'Manage Skuimages', 'url'=>array('admin')),
);
?>

<h1>Update Skuimages <?php echo $model->idskuimages; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>