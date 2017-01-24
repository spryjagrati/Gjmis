<?php
$this->breadcrumbs=array(
	'Deptmetallogs'=>array('index'),
	$model->iddeptmetallog=>array('view','id'=>$model->iddeptmetallog),
	'StocksUpdate',
);

$this->menu=array(
	//array('label'=>'List Deptmetallog', 'url'=>array('index')),
	array('label'=>'Create Deptmetalstocks', 'url'=>array('stockscreate')),
	array('label'=>'Manage Deptmetalstocks', 'url'=>array('admin')),
);
?>

<h1>Update Dept Metal Stocks <?php echo $model->iddeptmetallog; ?></h1>

<?php echo $this->renderPartial('_stockformupdate', array('model'=>$model)); ?>