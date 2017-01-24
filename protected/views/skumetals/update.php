<?php
$this->breadcrumbs=array(
	'Skumetals'=>array('index'),
	$model->idskumetals=>array('view','id'=>$model->idskumetals),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Skumetals', 'url'=>array('index')),
	array('label'=>'Create Skumetals', 'url'=>array('create')),
	array('label'=>'View Skumetals', 'url'=>array('view', 'id'=>$model->idskumetals)),
	array('label'=>'Manage Skumetals', 'url'=>array('admin')),
);
?>

<h1>Update Skumetals <?php echo $model->idskumetals; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>