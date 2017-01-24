<?php
$this->breadcrumbs=array(
	'Stones'=>array('index'),
	$model->idstone=>array('view','id'=>$model->idstone),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Stone', 'url'=>array('create')),
	array('label'=>'View Stone', 'url'=>array('view', 'id'=>$model->idstone)),
	array('label'=>'Manage Stone', 'url'=>array('admin')),
);
?>

<h1>Update Stone <?php echo $model->idstone; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'priceopt'=>$priceopt,'cost_price'=>$cost_price)); ?> 

<br>
<div id="message"></div>
<label>STONE VERIFIED</label>


