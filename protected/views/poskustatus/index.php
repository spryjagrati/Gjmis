<?php
$this->breadcrumbs=array(
	'Poskustatuses',
);

$this->menu=array(
	array('label'=>'Create Poskustatus', 'url'=>array('create')),
	array('label'=>'Manage Poskustatus', 'url'=>array('admin')),
);
?>

<h1>Poskustatuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
