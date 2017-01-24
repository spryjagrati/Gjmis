<?php
$this->breadcrumbs=array(
	'Stonems'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Stonem', 'url'=>array('index')),
	array('label'=>'Manage Stonem', 'url'=>array('admin')),
);
?>

<h1>Create Master Stones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonem-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idstonem',
		'name',
            'type',
            'scountry',
            'creatmeth',
            'treatmeth',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
