<?php
$this->breadcrumbs=array(
	'Deptfindlogs',
);

$this->menu=array(
	array('label'=>'Create Deptfindlog', 'url'=>array('stockscreate')),
	array('label'=>'Manage Deptfindlog', 'url'=>array('admin')),
);
?>

<h1>Deptfindlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
