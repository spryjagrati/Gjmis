<?php
$this->breadcrumbs=array(
	'Skufindings',
);

$this->menu=array(
	array('label'=>'Create Skufindings', 'url'=>array('create')),
	array('label'=>'Manage Skufindings', 'url'=>array('admin')),
);
?>

<h1>Skufindings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
