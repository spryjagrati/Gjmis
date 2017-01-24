<?php
$this->breadcrumbs=array(
	'Stonecostlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Stonecostlog', 'url'=>array('index')),
	array('label'=>'Manage Stonecostlog', 'url'=>array('admin')),
);
?>

<h1>Create Stonecostlog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>