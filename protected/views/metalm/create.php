<?php
$this->breadcrumbs=array(
	'Metalms'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Metalm', 'url'=>array('index')),
	array('label'=>'Manage Metalm', 'url'=>array('admin')),
);
?>

<h1>Create Master Metal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metalm-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idmetalm',
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
