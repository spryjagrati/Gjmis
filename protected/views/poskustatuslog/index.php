<?php
$this->breadcrumbs=array(
	'Poskustatuslogs',
);

$this->menu=array(
	array('label'=>'Create Poskustatuslog', 'url'=>array('create')),
	array('label'=>'Manage Poskustatuslog', 'url'=>array('admin')),
);
?>

<h1>Poskustatuslogs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
