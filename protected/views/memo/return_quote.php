<?php
$this->breadcrumbs=array(
	'Memos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create Quote', 'url'=>array('createquote')),
        array('label'=>'Manage Quotes', 'url'=>array('quote')),
    
);
?>

<h1>Return Quote</h1>

<?php echo $this->renderPartial('_returnform', array('model'=>$model, 'skumodel' => $skumodel)); ?>


<?php if($model->status == 3){ ?>
    <br><br>
    <h2>Return Skus</h2>
    <?php echo $this->renderPartial('_returnmemoskus', array('model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider)); ?>
    
<?php } ?>