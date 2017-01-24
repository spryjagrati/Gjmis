<?php
$this->breadcrumbs=array(
	'Postatuslogs'=>array('index'),
	$model->idpostatuslog=>array('view','id'=>$model->idpostatuslog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Postatuslog', 'url'=>array('index')),
	array('label'=>'Create Postatuslog', 'url'=>array('create')),
	array('label'=>'View Postatuslog', 'url'=>array('view', 'id'=>$model->idpostatuslog)),
	array('label'=>'Manage Postatuslog', 'url'=>array('admin')),
);
?>

<h1>Update Postatuslog <?php echo $model->idpostatuslog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>