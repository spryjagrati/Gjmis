<?php
$this->breadcrumbs=array(
	'Chemicals'=>array('index'),
	$model->name=>array('view','id'=>$model->idchemical),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Chemical', 'url'=>array('index')),
	array('label'=>'Create Chemical', 'url'=>array('create')),
	array('label'=>'View Chemical', 'url'=>array('view', 'id'=>$model->idchemical)),
	array('label'=>'Manage Chemical', 'url'=>array('admin')),
);
?>

<h1>Update Chemical <?php echo $model->idchemical; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>