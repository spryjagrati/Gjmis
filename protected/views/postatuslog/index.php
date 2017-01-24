<?php
$this->breadcrumbs=array(
	'Postatuslogs',
);

$this->menu=array(
	array('label'=>'Create Postatuslog', 'url'=>array('create')),
	array('label'=>'Manage Postatuslog', 'url'=>array('admin')),
);
?>

<h1>Postatuslogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
