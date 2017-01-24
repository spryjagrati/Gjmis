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

<h1>Create Quote</h1>

<?php echo $this->renderPartial('_formquote', array('model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept)); ?>