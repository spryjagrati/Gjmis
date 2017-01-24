<?php
$this->breadcrumbs=array(
	'Metals'=>array('index'),
	$model->idmetal=>array('view','id'=>$model->idmetal),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Metal', 'url'=>array('index')),
	array('label'=>'Create Metal', 'url'=>array('create')),
	array('label'=>'View Metal', 'url'=>array('view', 'id'=>$model->idmetal)),
	array('label'=>'Manage Metal', 'url'=>array('admin')),
);
?>

<h1>Update Metal <?php echo $model->idmetal; ?></h1>

<?php echo $this->renderPartial('_formupdate', array('model'=>$model)); ?>