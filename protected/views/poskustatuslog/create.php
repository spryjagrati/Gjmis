<?php
$this->breadcrumbs=array(
	'Poskustatuslogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Poskustatuslog', 'url'=>array('index')),
	array('label'=>'Manage Poskustatuslog', 'url'=>array('admin')),
);
?>

<h1>Create Poskustatuslog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>