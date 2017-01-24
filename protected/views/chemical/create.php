<?php
$this->breadcrumbs=array(
	'Chemicals'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Chemical', 'url'=>array('index')),
	array('label'=>'Manage Chemical', 'url'=>array('admin')),
);
?>

<h1>Create Chemical</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chemical-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idchemical',
		'name',
		'weiunit',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
