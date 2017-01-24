<?php
$this->breadcrumbs=array(
	'Memos'=>array('index'),
	$model->idmemo=>array('view','id'=>$model->idmemo),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Approval Memo', 'url'=>array('createapproval')),
        array('label'=>'Manage Approval Memos', 'url'=>array('approval')),
    
);
?>

<h1>Update Memo <?php echo $model->idmemo; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'skumodel' => $skumodel)); ?>

<br><br>
<h2>Add/Update Skus to Memo</h2>
<?php echo $this->renderPartial('_memoskus', array('model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider)); ?>