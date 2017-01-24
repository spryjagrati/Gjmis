<?php
$this->breadcrumbs=array(
	'Metalstamps'=>array('index'),
	$model->name=>array('view','id'=>$model->idmetalstamp),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Metalstamp', 'url'=>array('index')),
	array('label'=>'Create Metalstamp', 'url'=>array('create')),
	array('label'=>'View Metalstamp', 'url'=>array('view', 'id'=>$model->idmetalstamp)),
	array('label'=>'Manage Metalstamp', 'url'=>array('admin')),
);
?>

<h1>Update Metalstamp <?php echo $model->idmetalstamp; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>