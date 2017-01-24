<?php
$this->breadcrumbs=array(
	'Deptchemlogs'=>array('index'),
	'Stocks',
);

$this->menu=array(
	array('label'=>'Manage Deptchemlog', 'url'=>array('admin')),
);
?>

<h1>Create Dept Chemical Stocks</h1>

<?php echo $this->renderPartial('_stockform', array('model'=>$model)); ?>