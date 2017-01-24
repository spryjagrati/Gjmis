<?php
$this->breadcrumbs=array(
	'Clientparams',
);

$this->menu=array(
	array('label'=>'Create Clientparams', 'url'=>array('create')),
	array('label'=>'Manage Clientparams', 'url'=>array('admin')),
);
?>

<h1>Clientparams</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
