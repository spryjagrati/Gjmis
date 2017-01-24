<?php
$this->breadcrumbs=array(
	'Deptmetallogs'=>array('index'),
	'Stocks',
);

$this->menu=array(
	//array('label'=>'List Deptmetallog', 'url'=>array('index')),
	array('label'=>'Manage Deptmetallog', 'url'=>array('admin')),
);
?>

<h1>Create Dept Metal Stocks</h1>

<?php echo $this->renderPartial('_stockform', array('model'=>$model)); ?>