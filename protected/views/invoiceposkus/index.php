<?php
$this->breadcrumbs=array(
	'Invoiceposkuses',
);

$this->menu=array(
	array('label'=>'Create Invoiceposkus', 'url'=>array('create')),
	array('label'=>'Manage Invoiceposkus', 'url'=>array('admin')),
);
?>

<h1>Invoiceposkuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
