<?php
$this->breadcrumbs=array(
	'Metalcostlogs',
);

$this->menu=array(
	array('label'=>'Create Metalcostlog', 'url'=>array('create')),
	array('label'=>'Manage Metalcostlog', 'url'=>array('admin')),
);
?>

<h1>Metalcostlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
