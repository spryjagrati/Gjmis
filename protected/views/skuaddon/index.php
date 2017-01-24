<?php
$this->breadcrumbs=array(
	'Skuaddons',
);

$this->menu=array(
	array('label'=>'Create Skuaddon', 'url'=>array('create')),
	array('label'=>'Manage Skuaddon', 'url'=>array('admin')),
);
?>

<h1>Skuaddons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
