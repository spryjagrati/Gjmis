<?php
$this->breadcrumbs=array(
	'Deptfindlogs'=>array('index'),
	$model->idtbl_deptfindlog=>array('view','id'=>$model->idtbl_deptfindlog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Deptfindlog', 'url'=>array('index')),
	array('label'=>'Create Deptfindlog', 'url'=>array('create')),
	array('label'=>'Manage Deptfindlog', 'url'=>array('admin')),
);
?>

<h1>Update Dept Finding Stocks <?php echo $model->idtbl_deptfindlog; ?></h1>

<?php echo $this->renderPartial('_stockformupdate', array('model'=>$model)); ?>