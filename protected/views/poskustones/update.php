<?php
$this->breadcrumbs=array(
	'Poskustones'=>array('index'),
	$model->idtbl_poskustones=>array('view','id'=>$model->idtbl_poskustones),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Poskustones', 'url'=>array('index')),
	array('label'=>'Create Poskustones', 'url'=>array('create')),
	array('label'=>'View Poskustones', 'url'=>array('view', 'id'=>$model->idtbl_poskustones)),
	array('label'=>'Manage Poskustones', 'url'=>array('admin')),
);
?>

<h1>Update Poskustones <?php echo $model->idtbl_poskustones; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>