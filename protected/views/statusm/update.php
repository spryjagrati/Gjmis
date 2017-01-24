<?php
$this->breadcrumbs=array(
	'Statusms'=>array('index'),
	$model->name=>array('view','id'=>$model->idstatusm),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Statusm', 'url'=>array('index')),
	array('label'=>'Create Statusm', 'url'=>array('create')),
	array('label'=>'View Statusm', 'url'=>array('view', 'id'=>$model->idstatusm)),
	array('label'=>'Manage Statusm', 'url'=>array('admin')),
);
?>

<h1>Update Statusm <?php echo $model->idstatusm; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>