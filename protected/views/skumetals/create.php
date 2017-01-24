<?php
$this->breadcrumbs=array(
	'Skumetals'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Skumetals', 'url'=>array('index')),
	array('label'=>'Manage Skumetals', 'url'=>array('admin')),
);
?>

<h1>Create Skumetals</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>