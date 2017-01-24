<?php
$this->breadcrumbs=array(
	'Deptchemlogs',
);

$this->menu=array(
	array('label'=>'Create Deptchemlog', 'url'=>array('create')),
	array('label'=>'Manage Deptchemlog', 'url'=>array('admin')),
);
?>

<h1>Deptchemlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
