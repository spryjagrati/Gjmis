<?php
$this->breadcrumbs=array(
	'Poskustatuses'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Poskustatus', 'url'=>array('index')),
	array('label'=>'Manage Poskustatus', 'url'=>array('admin')),
);
?>

<h1>Create Poskustatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>