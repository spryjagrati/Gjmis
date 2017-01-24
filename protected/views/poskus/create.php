<?php
$this->breadcrumbs=array(
	'Poskuses'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Poskus', 'url'=>array('index')),
	array('label'=>'Manage Poskus', 'url'=>array('admin')),
);
?>

<h1>Create Poskus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>