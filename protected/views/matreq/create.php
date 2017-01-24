<?php
$this->breadcrumbs=array(
	'Matreqs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Matreq', 'url'=>array('index')),
	array('label'=>'Manage Matreq', 'url'=>array('admin')),
);
?>

<h1>Create Matreq</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>