<?php
$this->breadcrumbs=array(
	'Depts',
);

$this->menu=array(
	array('label'=>'Create Dept', 'url'=>array('create')),
	array('label'=>'Manage Dept', 'url'=>array('admin')),
);
?>

<h1>Depts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
