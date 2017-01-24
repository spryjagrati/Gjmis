<?php
$this->breadcrumbs=array(
	'Stonesizes',
);

$this->menu=array(
	array('label'=>'Create Stonesize', 'url'=>array('create')),
	array('label'=>'Manage Stonesize', 'url'=>array('admin')),
);
?>

<h1>Stonesizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
