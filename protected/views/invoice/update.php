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

<h1>Update Invoice <?php echo $model->idinvoice; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'loc_model'=> $loc_model, 'pos'=>$pos, 'skus'=>$skus)); ?>

<h2>Add Skus to Invoice</h2>
<?php 
    echo $this->renderPartial('_extskuform', array('po_data'=>$po_data,'activinposkus'=>$activinposkus,'model'=>$model));  
  ?>
