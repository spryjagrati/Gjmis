<?php
$this->breadcrumbs=array(
	'Deptmetallogs',
);

$this->menu=array(
	array('label'=>'Create Deptmetallog', 'url'=>array('create')),
	array('label'=>'Manage Deptmetallog', 'url'=>array('admin')),
);
?>

<h1>Deptmetallogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
