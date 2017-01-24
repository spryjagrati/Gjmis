<?php
$this->breadcrumbs=array(
	'Deptmetallogs'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Deptmetallog', 'url'=>array('index')),
	array('label'=>'Manage Deptmetallog', 'url'=>array('admin')),
);
?>

<h1>Create Deptmetallog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>