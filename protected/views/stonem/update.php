<?php
$this->breadcrumbs=array(
	'Stonems'=>array('index'),
	$model->name=>array('view','id'=>$model->idstonem),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Stonem', 'url'=>array('index')),
	array('label'=>'Create Stonem', 'url'=>array('create')),
	array('label'=>'View Stonem', 'url'=>array('view', 'id'=>$model->idstonem)),
	array('label'=>'Manage Stonem', 'url'=>array('admin')),
);
?>

<h1>Update Master Stones <?php echo $model->idstonem; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>