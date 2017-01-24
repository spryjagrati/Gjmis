<?php
$this->breadcrumbs=array(
	'Clarities',
);

$this->menu=array(
	array('label'=>'Create Clarity', 'url'=>array('create')),
	array('label'=>'Manage Clarity', 'url'=>array('admin')),
);
?>

<h1>Clarities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
