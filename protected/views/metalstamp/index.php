<?php
$this->breadcrumbs=array(
	'Metalstamps',
);

$this->menu=array(
	array('label'=>'Create Metalstamp', 'url'=>array('create')),
	array('label'=>'Manage Metalstamp', 'url'=>array('admin')),
);
?>

<h1>Metalstamps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
