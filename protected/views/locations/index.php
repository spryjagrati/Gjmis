<?php
$this->breadcrumbs=array(
	'Locations',
);

$this->menu=array(
	array('label'=>'Manage Locations', 'url'=>array('admin')),
);
?>

<h1>Locations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>