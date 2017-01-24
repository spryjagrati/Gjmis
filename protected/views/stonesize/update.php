<?php
$this->breadcrumbs=array(
	'Stonesizes'=>array('index'),
	$model->idstonesize=>array('view','id'=>$model->idstonesize),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Stonesize', 'url'=>array('index')),
	array('label'=>'Create Stonesize', 'url'=>array('create')),
	array('label'=>'View Stonesize', 'url'=>array('view', 'id'=>$model->idstonesize)),
	array('label'=>'Manage Stonesize', 'url'=>array('admin')),
);
?>

<h1>Update Stonesize <?php echo $model->idstonesize; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>