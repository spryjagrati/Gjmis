<?php
$this->breadcrumbs=array(
	'Stonems',
);

$this->menu=array(
	array('label'=>'Create Stonem', 'url'=>array('create')),
	array('label'=>'Manage Stonem', 'url'=>array('admin')),
);
?>

<h1>Master stones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
