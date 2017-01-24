<?php
$this->breadcrumbs=array(
	'Clientparams'=>array('index'),
	$model->name=>array('view','id'=>$model->idclientparams),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Clientparams', 'url'=>array('index')),
	array('label'=>'Create Clientparams', 'url'=>array('create')),
	array('label'=>'View Clientparams', 'url'=>array('view', 'id'=>$model->idclientparams)),
	array('label'=>'Manage Clientparams', 'url'=>array('admin')),
);
?>

<h1>Update Clientparams <?php echo $model->idclientparams; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>