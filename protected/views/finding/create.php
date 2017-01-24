<?php
$this->breadcrumbs=array(
	'Findings'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Finding', 'url'=>array('index')),
	array('label'=>'Manage Finding', 'url'=>array('admin')),
);
?>

<h1>Create Finding</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'finding-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idfinding',
		'name',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>($model->idmetal0)?$model->idmetal0->namevar:NULL),
		'weight',
		'cost',
		'mdate',
            'size',
		/*
		'cdate',
		'updby',
		'descri',
                'supplier',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
