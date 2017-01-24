<?php
$this->breadcrumbs=array(
	'Stonestocks'=>array('index'),
	$model->idstonestocks=>array('view','id'=>$model->idstonestocks),
	'StocksUpdate',
);

$this->menu=array(
	//array('label'=>'List Deptstonelog', 'url'=>array('index')),
	array('label'=>'Create Stonestocks', 'url'=>array('stockscreate')),
	array('label'=>'Manage Stonestocks', 'url'=>array('admin')),
);
?>

<h1>Update Dept Stone Stocks <?php echo $model->idstonestocks; ?></h1>

<?php echo $this->renderPartial('_stocksformupdate', array('model'=>$model)); ?>