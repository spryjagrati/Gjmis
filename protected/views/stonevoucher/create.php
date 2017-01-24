<?php
$this->breadcrumbs=array(
	'Stonevouchers'=>array('index'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Stonevoucher', 'url'=>array('admin')),
);
?>

<h1>Create Stonevoucher</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>