<?php
$this->breadcrumbs=array(
	'Skuaddons'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Skuaddon', 'url'=>array('index')),
	array('label'=>'Manage Skuaddon', 'url'=>array('admin')),
);
?>

<h1>Create Skuaddon</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>