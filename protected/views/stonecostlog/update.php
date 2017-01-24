<?php
$this->breadcrumbs=array(
	'Stonecostlogs'=>array('index'),
	$model->idstonecostlog=>array('view','id'=>$model->idstonecostlog),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Stonecostlog', 'url'=>array('index')),
	array('label'=>'Create Stonecostlog', 'url'=>array('create')),
	array('label'=>'View Stonecostlog', 'url'=>array('view', 'id'=>$model->idstonecostlog)),
	array('label'=>'Manage Stonecostlog', 'url'=>array('admin')),
);
?>

<h1>Update Stonecostlog <?php echo $model->idstonecostlog; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>