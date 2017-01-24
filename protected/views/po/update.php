<?php
$this->breadcrumbs=array(
	'Pos'=>array('index'),
	$model->idpo=>array('view','id'=>$model->idpo),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Po', 'url'=>array('index')),
	array('label'=>'Create Po', 'url'=>array('create')),
	array('label'=>'View Po', 'url'=>array('view', 'id'=>$model->idpo)),
	array('label'=>'Manage Po', 'url'=>array('admin')),
);
?>

<h1>Update Po <?php echo $model->idpo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>