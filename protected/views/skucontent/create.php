<?php
$this->breadcrumbs=array(
	'Skucontents'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Skucontent', 'url'=>array('index')),
	array('label'=>'Manage Skucontent', 'url'=>array('admin')),
);
?>

<h1>Create Skucontent</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>