<?php
$this->breadcrumbs=array(
	'Deptstonelogs'=>array('index'),
	'StocksCreate',
);

$this->menu=array(
	//array('label'=>'List Deptstonelog', 'url'=>array('index')),
	array('label'=>'Manage Deptstonestocks', 'url'=>array('admin')),
);
?>

<h1>Create Dept Stone Stocks</h1>

<?php echo $this->renderPartial('_stockform', array('model'=>$model)); ?>