<?php
$this->breadcrumbs=array(
	'Stones',
);

$this->menu=array(
	array('label'=>'Create Stone', 'url'=>array('create')),
	array('label'=>'Manage Stone', 'url'=>array('admin')),
);
?>

<h1>Stones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
