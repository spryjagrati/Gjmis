<?php
$this->breadcrumbs=array(
	'Costadds',
);

$this->menu=array(
	array('label'=>'Create Costadd', 'url'=>array('create')),
	array('label'=>'Manage Costadd', 'url'=>array('admin')),
);
?>

<h1>Costadds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
