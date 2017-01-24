<?php
$this->breadcrumbs=array(
	'Clientparams'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Clientparams', 'url'=>array('index')),
	array('label'=>'Manage Clientparams', 'url'=>array('admin')),
);
?>

<h1>Create Clientparams</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientparams-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		array('name'=>'idclientparams','header'=>'id'),
		array('name'=>'idclient','header'=>'Client','value'=>'$data->idclient0->name'),
		'name',
		'defaultval',
		'formula',
		'type',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
