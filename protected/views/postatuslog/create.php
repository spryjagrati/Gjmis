<?php
$this->breadcrumbs=array(
	'Postatuslogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Postatuslog', 'url'=>array('index')),
	array('label'=>'Manage Postatuslog', 'url'=>array('admin')),
);
?>

<h1>Create Postatuslog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>