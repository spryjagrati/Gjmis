<?php
$this->breadcrumbs=array(
	'Statusnavs',
);

$this->menu=array(
	array('label'=>'Create Statusnav', 'url'=>array('create')),
	array('label'=>'Manage Statusnav', 'url'=>array('admin')),
);
?>

<h1>Statusnavs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
