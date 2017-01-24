<?php
$this->breadcrumbs=array(
	'Metalcostlogs'=>array('index'),
	$model->idmetalcostlog=>array('view','id'=>$model->idmetalcostlog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Metalcostlog', 'url'=>array('index')),
	array('label'=>'Create Metalcostlog', 'url'=>array('create')),
	array('label'=>'View Metalcostlog', 'url'=>array('view', 'id'=>$model->idmetalcostlog)),
	array('label'=>'Manage Metalcostlog', 'url'=>array('admin')),
);
?>

<h1>Update Metalcostlog <?php echo $model->idmetalcostlog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>