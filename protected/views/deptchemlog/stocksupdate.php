<?php
$this->breadcrumbs=array(
	'Deptchemlogs'=>array('index'),
	$model->iddeptchemlog=>array('view','id'=>$model->iddeptchemlog),
	'StocksUpdate',
);

$this->menu=array(
	//array('label'=>'List Deptchemlog', 'url'=>array('index')),
	array('label'=>'Create Deptchemstocks', 'url'=>array('createstocks')),
	array('label'=>'Manage Deptchemstocks', 'url'=>array('admin')),
);
?>

<h1>Update Dept Chemical Stocks <?php echo $model->iddeptchemlog; ?></h1>

<?php echo $this->renderPartial('_stockformupdate', array('model'=>$model)); ?>