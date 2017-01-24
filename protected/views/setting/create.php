<?php
$this->breadcrumbs=array(
	'Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Setting', 'url'=>array('index')),
	array('label'=>'Manage Setting', 'url'=>array('admin')),
);
?>

<h1>Create Setting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'setting-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idsetting',
		'name',
		'type',
		'setcost',
		'bagcost',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
