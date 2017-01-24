<?php
$this->breadcrumbs=array(
	'Matreqs'=>array('index'),
	$model->idmatreq=>array('view','id'=>$model->idmatreq),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Matreq', 'url'=>array('index')),
	array('label'=>'Create Matreq', 'url'=>array('create')),
	array('label'=>'View Matreq', 'url'=>array('view', 'id'=>$model->idmatreq)),
	array('label'=>'Manage Matreq', 'url'=>array('admin')),
);
?>

<h1>Update Matreq <?php echo $model->idmatreq; ?></h1>

<?php echo $this->renderPartial('_form_update', array('model'=>$model)); ?>