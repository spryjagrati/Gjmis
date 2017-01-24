<?php
$this->breadcrumbs=array(
	'Stonevouchers'=>array('index'),
	$model->idstonevoucher=>array('view','id'=>$model->idstonevoucher),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Stonevoucher', 'url'=>array('create')),
	array('label'=>'Manage Stonevoucher', 'url'=>array('admin')),
);
?>

<h1>Maintain Stonevoucher <?php echo $model->idstonevoucher; ?></h1>

<?php echo $this->renderPartial('_maintain', array('model'=>$model)); ?>