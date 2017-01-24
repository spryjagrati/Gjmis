<?php
$this->breadcrumbs=array(
	'Skufindings'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Skufindings', 'url'=>array('index')),
	array('label'=>'Manage Skufindings', 'url'=>array('admin')),
);
?>

<h1>Create Skufindings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>