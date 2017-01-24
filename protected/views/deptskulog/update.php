<?php
$this->breadcrumbs=array(
	'Deptskulogs'=>array('index'),
	$model->iddeptskulog=>array('view','id'=>$model->iddeptskulog),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Stocks', 'url'=>array('create')),
	array('label'=>'Manage Stocks', 'url'=>array('admin')),
);
?>

<h1>Update Stocks <?php echo $model->iddeptskulog; ?></h1>
<input type="hidden" name="val_sku" id="val_sku" value="<?php echo $model->idsku0->skucode;?>"/>
<input type="hidden" name="id_sku" id="id_sku" value="<?php echo $model->idsku ;?>"/>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
