<?php
$this->breadcrumbs=array(
	'Skucontents',
);

$this->menu=array(
	array('label'=>'Create Skucontent', 'url'=>array('create')),
	array('label'=>'Manage Skucontent', 'url'=>array('admin')),
);
?>

<h1>Skucontents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
