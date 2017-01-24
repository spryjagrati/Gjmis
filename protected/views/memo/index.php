<?php
$this->breadcrumbs=array(
	'Memos',
);

$this->menu=array(
	array('label'=>'Create Memo', 'url'=>array('create')),
	array('label'=>'Manage Memo', 'url'=>array('admin')),
);
?>

<h1>Memos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
