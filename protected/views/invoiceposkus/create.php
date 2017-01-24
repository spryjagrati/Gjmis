<?php
$this->breadcrumbs=array(
	'Invoiceposkuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Invoiceposkus', 'url'=>array('index')),
	array('label'=>'Manage Invoiceposkus', 'url'=>array('admin')),
);
?>

<h1>Create Invoiceposkus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>