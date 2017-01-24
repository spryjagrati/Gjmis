<?php
$this->breadcrumbs=array(
	'Statusms'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Statusm', 'url'=>array('index')),
	array('label'=>'Manage Statusm', 'url'=>array('admin')),
);
?>

<h1>Create Statusm</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>