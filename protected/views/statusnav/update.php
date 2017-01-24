<?php
$this->breadcrumbs=array(
	'Statusnavs'=>array('index'),
	$model->idstatusnav=>array('view','id'=>$model->idstatusnav),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Statusnav', 'url'=>array('index')),
	array('label'=>'Create Statusnav', 'url'=>array('create')),
	array('label'=>'View Statusnav', 'url'=>array('view', 'id'=>$model->idstatusnav)),
	array('label'=>'Manage Statusnav', 'url'=>array('admin')),
);
?>

<h1>Update Statusnav <?php echo $model->idstatusnav; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>