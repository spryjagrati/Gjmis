<?php
$this->breadcrumbs=array(
	'Skustones'=>array('index'),
	$model->idskustones=>array('view','id'=>$model->idskustones),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Skustones', 'url'=>array('index')),
	array('label'=>'Create Skustones', 'url'=>array('create')),
	array('label'=>'View Skustones', 'url'=>array('view', 'id'=>$model->idskustones)),
	array('label'=>'Manage Skustones', 'url'=>array('admin')),
);
?>

<h1>Update Skustones <?php echo $model->idskustones; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>