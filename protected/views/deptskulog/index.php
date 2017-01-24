<?php
$this->breadcrumbs=array(
	'Deptskulogs',
);

$this->menu=array(
	array('label'=>'Create Deptskulog', 'url'=>array('create')),
	array('label'=>'Manage Deptskulog', 'url'=>array('admin')),
);
?>

<h1>Deptskulogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
