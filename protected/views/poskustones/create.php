<?php
$this->breadcrumbs=array(
	'Poskustones'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Poskustones', 'url'=>array('index')),
	array('label'=>'Manage Poskustones', 'url'=>array('admin')),
);
?>

<h1>Create Poskustones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>