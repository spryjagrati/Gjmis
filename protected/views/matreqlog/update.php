<?php
$this->breadcrumbs=array(
	'Matreqlogs'=>array('index'),
	$model->idtbl_matreqlog=>array('view','id'=>$model->idtbl_matreqlog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Matreqlog', 'url'=>array('index')),
	array('label'=>'Create Matreqlog', 'url'=>array('create')),
	array('label'=>'View Matreqlog', 'url'=>array('view', 'id'=>$model->idtbl_matreqlog)),
	array('label'=>'Manage Matreqlog', 'url'=>array('admin')),
);
?>

<h1>Update Matreqlog <?php echo $model->idtbl_matreqlog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>