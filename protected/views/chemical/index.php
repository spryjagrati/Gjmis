<?php
$this->breadcrumbs=array(
	'Chemicals',
);

$this->menu=array(
	array('label'=>'Create Chemical', 'url'=>array('create')),
	array('label'=>'Manage Chemical', 'url'=>array('admin')),
);
?>

<h1>Chemicals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
