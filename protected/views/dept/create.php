<?php
$this->breadcrumbs=array(
	'Depts'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Dept', 'url'=>array('index')),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>Create Dept</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>