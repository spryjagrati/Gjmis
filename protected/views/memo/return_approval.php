<?php
$this->breadcrumbs=array(
	'Memos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create Approval Memo', 'url'=>array('createapproval')),
        array('label'=>'Manage Approval Memos', 'url'=>array('approval')),
    
);
?>

<h1>Return Approval Memo</h1>

<?php echo $this->renderPartial('_returnform', array('model'=>$model, 'skumodel' => $skumodel)); ?>


<?php if($model->status == 3){ ?>
    <br><br>
    <h2>Return Skus</h2>
    <?php echo $this->renderPartial('_returnmemoskus', array('model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider)); ?>
    
<?php } ?>