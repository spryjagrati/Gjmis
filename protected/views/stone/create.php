<?php
$this->breadcrumbs=array(
	'Stones'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Stone', 'url'=>array('index')),
	array('label'=>'Manage Stone', 'url'=>array('admin')),
);
?>

<h1>Create Stone</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'priceopt'=>$priceopt)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stone-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idstone',
		'namevar',
		array('name'=>'idstonem','header'=>'StoneM','type'=>'raw','value'=>'$data->idstonem0->name','filter'=>ComSpry::getStonem()),
		array('name'=>'idshape','header'=>'Shape','type'=>'raw','value'=>'$data->idshape0->name','filter'=>ComSpry::getShapes()),
		//array('name'=>'idclarity','header'=>'Clarity','type'=>'raw','value'=>'$data->idclarity0->name','filter'=>ComSpry::getClarities()),
		array('name'=>'idstonesize','header'=>'Size','type'=>'raw','value'=>'$data->idstonesize0->size','filter'=>ComSpry::getStonesizes()),
		'color',
		'quality',
		'cut',
        'weight',
		//array('name'=>'curcost','header'=>'Price /Pc'),
        array('name'=>'curcost','header'=>'Price /Ct','value'=>'($data->weight!=0)?round($data->curcost/$data->weight,2):""'),
		'mdate',
		/*
		'type',
		'scountry',
		'creatmeth',
		'treatmeth',
		'cdate',
		'updby',
		'prevcost',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
