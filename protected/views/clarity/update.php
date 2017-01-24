<?php
$this->breadcrumbs=array(
	'Clarities'=>array('index'),
	$model->name=>array('view','id'=>$model->idclarity),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Clarity', 'url'=>array('index')),
	array('label'=>'Create Clarity', 'url'=>array('create')),
	array('label'=>'View Clarity', 'url'=>array('view', 'id'=>$model->idclarity)),
	array('label'=>'Manage Clarity', 'url'=>array('admin')),
);
?>

<h1>Update Clarity <?php echo $model->idclarity; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>