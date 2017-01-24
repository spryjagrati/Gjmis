<?php
$this->breadcrumbs=array(
	'Pos',
);

$this->menu=array(
	array('label'=>'Create Po', 'url'=>array('create')),
	array('label'=>'Manage Po', 'url'=>array('admin')),
);
?>

<h1>Pos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
