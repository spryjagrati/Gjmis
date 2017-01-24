<?php
$this->breadcrumbs=array(
	'Metals'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Metal', 'url'=>array('index')),
	array('label'=>'Manage Metal', 'url'=>array('admin')),
);
?>

<h1>Create Metal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metal-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idmetal',
            'namevar',
            array('name'=>'idmetalm','header'=>'MetalM','type'=>'raw','value'=>'$data->idmetalm0->name','filter'=>ComSpry::getMasterMetals()),
		//'idmetalm',
            array('name'=>'idmetalstamp','header'=>'Stamp','type'=>'raw','value'=>'$data->idmetalstamp0->name','filter'=>ComSpry::getMetalStamps()),
		//'idmetalstamp',
		'currentcost',
		'prevcost',
            'chemcost',
		'mdate',
		/*
		'cdate',
		'updby',
		'lossfactor',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
