<?php
$this->breadcrumbs=array(
	'Metalms',
);

$this->menu=array(
	array('label'=>'Create Metalm', 'url'=>array('create')),
	array('label'=>'Manage Metalm', 'url'=>array('admin')),
);
?>

<h1>master Metals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
