<?php
$this->breadcrumbs=array(
	'Skuaddons'=>array('index'),
	$model->idskuaddon=>array('view','id'=>$model->idskuaddon),
	'Update',
);

$this->menu=array(
	array('label'=>'List Skuaddon', 'url'=>array('index')),
	array('label'=>'Create Skuaddon', 'url'=>array('create')),
	array('label'=>'View Skuaddon', 'url'=>array('view', 'id'=>$model->idskuaddon)),
	array('label'=>'Manage Skuaddon', 'url'=>array('admin')),
);
?>

<h1>Update Skuaddon <?php echo $model->idskuaddon; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>