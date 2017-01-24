<?php
$this->breadcrumbs=array(
	'Skuimages',
);

$this->menu=array(
	array('label'=>'Create Skuimages', 'url'=>array('create')),
	array('label'=>'Manage Skuimages', 'url'=>array('admin')),
);
?>

<h1>Skuimages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
