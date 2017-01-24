<?php
$this->breadcrumbs=array(
	'Costadds'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Costadd', 'url'=>array('index')),
	array('label'=>'Manage Costadd', 'url'=>array('admin')),
);
?>

<h1>Create Costadd</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'costadd-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		array('name'=>'idcostadd','header'=>'Id'),
		'type',
                'name',
		array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'($data->idmetal0)?$data->idmetal0->namevar:NULL'),
		//array('name'=>'idstone','header'=>'Stone','type'=>'raw','value'=>($model->idstone0)?$model->idstone0->namevar:NULL),
		//array('name'=>'idchemical','header'=>'Chemical','type'=>'raw','value'=>($model->idchemical0)?$model->idchemical0->name:NULL),
		//array('name'=>'idsetting','header'=>'Setting','type'=>'raw','value'=>($model->idsetting0)?$model->idsetting0->name:NULL),
		'fixcost',
		'factormetal',
		'costformula',
            'threscostformula',
		'mdate',
		/*
		array('name'=>'updby','header'=>'Updator'),
		'factorstone',
		'threscostformula',
		'factorchem',
		'factornumsto',
		'factorsetting',
		'cdate',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
