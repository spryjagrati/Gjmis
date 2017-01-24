<?php
$this->breadcrumbs=array(
	'Skustones'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Skustones', 'url'=>array('index')),
	array('label'=>'Manage Skustones', 'url'=>array('admin')),
);
?>

<h1>Create Skustones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>