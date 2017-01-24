<?php
$this->breadcrumbs=array(
	'Matreqlogs',
);

$this->menu=array(
	array('label'=>'Create Matreqlog', 'url'=>array('create')),
	array('label'=>'Manage Matreqlog', 'url'=>array('admin')),
);
?>

<h1>Matreqlogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
