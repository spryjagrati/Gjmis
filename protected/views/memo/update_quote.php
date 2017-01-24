<?php
$this->breadcrumbs=array(
	'Memos'=>array('index'),
	$model->idmemo=>array('view','id'=>$model->idmemo),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Quote', 'url'=>array('createquote')),
        array('label'=>'Manage Quotes', 'url'=>array('quote')),
    
);
?>

<h1>Update Quote <?php echo $model->idmemo; ?></h1>

<?php echo $this->renderPartial('_formquote', array('model'=>$model, 'skumodel' => $skumodel)); ?>

<br><br>
<h2>Add/Update Skus to Quote</h2>
<?php echo $this->renderPartial('_memoskus', array('model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider)); ?>