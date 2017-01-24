<?php
$this->breadcrumbs=array(
	'Poskuses'=>array('index'),
	$model->idposkus=>array('view','id'=>$model->idposkus),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Poskus', 'url'=>array('index')),
	array('label'=>'Create Poskus', 'url'=>array('create')),
	array('label'=>'View Poskus', 'url'=>array('view', 'id'=>$model->idposkus)),
	array('label'=>'Manage Poskus', 'url'=>array('admin')),
);
?>

<h1>Update Poskus <?php echo $model->idposkus; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>