<?php
$this->breadcrumbs=array(
	'Skus'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Sku', 'url'=>array('index')),
	array('label'=>'Manage Only Sku', 'url'=>array('admin')),
	array('label'=>'Maintain SKUs', 'url'=>array('product/admin')),
);
?>

<h1>Create Duplicate Sku</h1>

<?php echo $this->renderPartial('_form_duplicate', array('model'=>$model,'modelnew'=>$modelnew )); ?>