<?php
$this->breadcrumbs=array(
	'Costadds'=>array('index'),
	$model->name=>array('view','id'=>$model->idcostadd),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Costadd', 'url'=>array('index')),
	array('label'=>'Create Costadd', 'url'=>array('create')),
	array('label'=>'View Costadd', 'url'=>array('view', 'id'=>$model->idcostadd)),
	array('label'=>'Manage Costadd', 'url'=>array('admin')),
);
?>

<h1>Update Costadd <?php echo $model->idcostadd; ?></h1>

<?php echo $this->renderPartial('_formupdate', array('model'=>$model)); ?>