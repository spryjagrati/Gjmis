<?php
$this->breadcrumbs=array(
	'Poskustones',
);

$this->menu=array(
	array('label'=>'Create Poskustones', 'url'=>array('create')),
	array('label'=>'Manage Poskustones', 'url'=>array('admin')),
);
?>

<h1>Poskustones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
