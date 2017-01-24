<?php
$this->breadcrumbs=array(
	'Findings'=>array('index'),
	$model->name=>array('view','id'=>$model->idfinding),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Finding', 'url'=>array('index')),
	array('label'=>'Create Finding', 'url'=>array('create')),
	array('label'=>'View Finding', 'url'=>array('view', 'id'=>$model->idfinding)),
	array('label'=>'Manage Finding', 'url'=>array('admin')),
);
?>

<h1>Update Finding <?php echo $model->idfinding; ?></h1>

<?php echo $this->renderPartial('_formupdate', array('model'=>$model)); ?>