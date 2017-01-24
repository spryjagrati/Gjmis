<?php
$this->breadcrumbs=array(
	'Findings',
);

$this->menu=array(
	array('label'=>'Create Finding', 'url'=>array('create')),
	array('label'=>'Manage Finding', 'url'=>array('admin')),
);
?>

<h1>Findings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
