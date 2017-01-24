<?php
$this->breadcrumbs=array(
	'Matreqlogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Matreqlog', 'url'=>array('index')),
	array('label'=>'Manage Matreqlog', 'url'=>array('admin')),
);
?>

<h1>Create Matreqlog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>