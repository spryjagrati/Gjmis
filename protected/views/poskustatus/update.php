<?php
$this->breadcrumbs=array(
	'Poskustatuses'=>array('index'),
	$model->idposkustatus=>array('view','id'=>$model->idposkustatus),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Poskustatus', 'url'=>array('index')),
	array('label'=>'Create Poskustatus', 'url'=>array('create')),
	array('label'=>'View Poskustatus', 'url'=>array('view', 'id'=>$model->idposkustatus)),
	array('label'=>'Manage Poskustatus', 'url'=>array('admin')),
);
?>

<h1>Update Poskustatus <?php echo $model->idposkustatus; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>