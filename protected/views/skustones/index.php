<?php
$this->breadcrumbs=array(
	'Skustones',
);

$this->menu=array(
	array('label'=>'Create Skustones', 'url'=>array('create')),
	array('label'=>'Manage Skustones', 'url'=>array('admin')),
);
?>

<h1>Skustones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
