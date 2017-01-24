<?php
$this->breadcrumbs=array(
	'Deptfindlogs'=>array('index'),
	'StocksCreate',
);

$this->menu=array(
	//array('label'=>'List Deptfindlog', 'url'=>array('index')),
	array('label'=>'Manage Deptfindstocks', 'url'=>array('admin')),
);
?>

<h1>Create Dept Finding Stocks</h1>

<?php echo $this->renderPartial('_stockform', array('model'=>$model)); ?>