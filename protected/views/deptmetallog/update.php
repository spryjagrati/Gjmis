<?php
$this->breadcrumbs=array(
	'Deptmetallogs'=>array('index'),
	$model->iddeptmetallog=>array('view','id'=>$model->iddeptmetallog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Deptmetallog', 'url'=>array('index')),
	array('label'=>'Create Deptmetallog', 'url'=>array('create')),
	array('label'=>'View Deptmetallog', 'url'=>array('view', 'id'=>$model->iddeptmetallog)),
	array('label'=>'Manage Deptmetallog', 'url'=>array('admin')),
);
?>

<h1>Update Deptmetallog <?php echo $model->iddeptmetallog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>