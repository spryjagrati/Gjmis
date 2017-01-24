<?php
$this->breadcrumbs=array(
	'Metals',
);

$this->menu=array(
	array('label'=>'Create Metal', 'url'=>array('create')),
	array('label'=>'Manage Metal', 'url'=>array('admin')),
);
?>

<h1>Metals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
