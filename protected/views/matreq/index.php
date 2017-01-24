<?php
$this->breadcrumbs=array(
	'Matreqs',
);

$this->menu=array(
	array('label'=>'Create Matreq', 'url'=>array('create')),
	array('label'=>'Manage Matreq', 'url'=>array('admin')),
);
?>

<h1>Matreqs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
