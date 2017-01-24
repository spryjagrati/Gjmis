<?php
$this->breadcrumbs=array(
	'Stonevouchers',
);

$this->menu=array(
	array('label'=>'Create Stonevoucher', 'url'=>array('create')),
	array('label'=>'Manage Stonevoucher', 'url'=>array('admin')),
);
?>

<h1>Stonevouchers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
