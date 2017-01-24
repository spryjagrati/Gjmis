<?php
$this->breadcrumbs=array(
	'Stonecostlogs',
);

$this->menu=array(
	array('label'=>'Create Stonecostlog', 'url'=>array('create')),
	array('label'=>'Manage Stonecostlog', 'url'=>array('admin')),
);
?>

<h1>Stonecostlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
