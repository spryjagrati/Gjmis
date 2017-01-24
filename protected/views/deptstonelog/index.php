<?php
$this->breadcrumbs=array(
	'Deptstonelogs',
);

$this->menu=array(
	array('label'=>'Create Deptstonelog', 'url'=>array('create')),
	array('label'=>'Manage Deptstonelog', 'url'=>array('admin')),
);
?>

<h1>Deptstonelogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
