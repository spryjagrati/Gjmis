<?php
$this->breadcrumbs=array(
	'Deptfindlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Deptfindlog', 'url'=>array('index')),
	array('label'=>'Manage Deptfindlog', 'url'=>array('admin')),
);
?>

<h1>Create Deptfindlog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>