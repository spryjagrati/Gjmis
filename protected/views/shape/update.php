<?php
$this->breadcrumbs=array(
	'Shapes'=>array('index'),
	$model->name=>array('view','id'=>$model->idshape),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Shape', 'url'=>array('index')),
	array('label'=>'Create Shape', 'url'=>array('create')),
	array('label'=>'View Shape', 'url'=>array('view', 'id'=>$model->idshape)),
	array('label'=>'Manage Shape', 'url'=>array('admin')),
);
?>

<h1>Update Shape <?php echo $model->idshape; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>