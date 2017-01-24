<?php
$this->breadcrumbs=array(
	'Depts'=>array('index'),
	$model->name=>array('view','id'=>$model->iddept),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Dept', 'url'=>array('index')),
	array('label'=>'Create Dept', 'url'=>array('create')),
	array('label'=>'View Dept', 'url'=>array('view', 'id'=>$model->iddept)),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>Update Dept <?php echo $model->iddept; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>