<?php
$this->breadcrumbs=array(
	'Poskuses',
);

$this->menu=array(
	array('label'=>'Create Poskus', 'url'=>array('create')),
	array('label'=>'Manage Poskus', 'url'=>array('admin')),
);
?>

<h1>Poskuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
