<?php
$this->breadcrumbs=array(
	'Skumetals',
);

$this->menu=array(
	array('label'=>'Create Skumetals', 'url'=>array('create')),
	array('label'=>'Manage Skumetals', 'url'=>array('admin')),
);
?>

<h1>Skumetals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
