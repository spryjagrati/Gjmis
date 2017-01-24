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

<h1>Create Approval Memo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept)); ?>