<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->idinvoice=>array('view','id'=>$model->idinvoice),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Invoice', 'url'=>array('index')),
	array('label'=>'Create Invoice', 'url'=>array('create')),
	array('label'=>'Export Invoice', 'url'=>array('invoiceexport', 'id'=>$model->idinvoice)),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);
?>

<h1>Return Invoice <?php echo $model->idinvoice; ?></h1>

<?php echo $this->renderPartial('_return', array('model'=>$model, 'locationmodel'=>$locationmodel, 'display'=>$display)); ?>

<?php 
      if($model->retrn ==1 ){
          echo $this->renderPartial('_returnskuform', array('model'=>$model, 'locationmodel'=>$locationmodel, 'display'=>$display, 'poskus'=>$poskus)); 
      }
?>
