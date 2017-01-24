<?php
$this->breadcrumbs=array(
	'Metalcostlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Metalcostlog', 'url'=>array('index')),
	array('label'=>'Manage Metalcostlog', 'url'=>array('admin')),
);
?>

<h1>Create Metalcostlog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>