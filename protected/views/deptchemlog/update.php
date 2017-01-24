<?php
$this->breadcrumbs=array(
	'Deptchemlogs'=>array('index'),
	$model->iddeptchemlog=>array('view','id'=>$model->iddeptchemlog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Deptchemlog', 'url'=>array('index')),
	array('label'=>'Create Deptchemlog', 'url'=>array('create')),
	array('label'=>'View Deptchemlog', 'url'=>array('view', 'id'=>$model->iddeptchemlog)),
	array('label'=>'Manage Deptchemlog', 'url'=>array('admin')),
);
?>

<h1>Update Deptchemlog <?php echo $model->iddeptchemlog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>