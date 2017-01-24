<?php
$this->breadcrumbs=array(
	'Invoiceposkuses'=>array('index'),
	$model->idinvoiceposkus=>array('view','id'=>$model->idinvoiceposkus),
	'Update',
);

$this->menu=array(
	array('label'=>'List Invoiceposkus', 'url'=>array('index')),
	array('label'=>'Create Invoiceposkus', 'url'=>array('create')),
	array('label'=>'View Invoiceposkus', 'url'=>array('view', 'id'=>$model->idinvoiceposkus)),
	array('label'=>'Manage Invoiceposkus', 'url'=>array('admin')),
);
?>

<h1>Update Invoiceposkus <?php echo $model->idinvoiceposkus; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>