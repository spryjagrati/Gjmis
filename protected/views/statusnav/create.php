<?php
$this->breadcrumbs=array(
	'Statusnavs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Statusnav', 'url'=>array('index')),
	array('label'=>'Manage Statusnav', 'url'=>array('admin')),
);
?>

<h1>Create Statusnav</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>