<?php
$this->breadcrumbs=array(
	'Skuimages'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Skuimages', 'url'=>array('index')),
	array('label'=>'Manage Skuimages', 'url'=>array('admin')),
);
?>

<h1>Create Skuimages</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>