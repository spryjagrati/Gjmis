<?php
$this->breadcrumbs=array(
	'Skucontents'=>array('index'),
	$model->name=>array('view','id'=>$model->idskucontent),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Skucontent', 'url'=>array('index')),
	array('label'=>'Create Skucontent', 'url'=>array('create')),
	array('label'=>'View Skucontent', 'url'=>array('view', 'id'=>$model->idskucontent)),
	array('label'=>'Manage Skucontent', 'url'=>array('admin')),
);
?>

<h1>Update Skucontent <?php echo $model->idskucontent; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>