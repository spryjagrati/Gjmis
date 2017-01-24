<?php
$this->breadcrumbs=array(
	'Poskustatuslogs'=>array('index'),
	$model->idposkustatuslog=>array('view','id'=>$model->idposkustatuslog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Poskustatuslog', 'url'=>array('index')),
	array('label'=>'Create Poskustatuslog', 'url'=>array('create')),
	array('label'=>'View Poskustatuslog', 'url'=>array('view', 'id'=>$model->idposkustatuslog)),
	array('label'=>'Manage Poskustatuslog', 'url'=>array('admin')),
);
?>

<h1>Update Poskustatuslog <?php echo $model->idposkustatuslog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>