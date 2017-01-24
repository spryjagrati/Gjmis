<?php
$this->breadcrumbs=array(
	'Shapes',
);

$this->menu=array(
	array('label'=>'Create Shape', 'url'=>array('create')),
	array('label'=>'Manage Shape', 'url'=>array('admin')),
);
?>

<h1>Shapes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
