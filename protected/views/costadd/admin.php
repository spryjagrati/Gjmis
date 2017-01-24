<?php
$this->breadcrumbs=array(
	'Costadds'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Costadd', 'url'=>array('index')),
	array('label'=>'Create Costadd', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('costadd-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Costadds</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'costadd-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		array('name'=>'idcostadd','header'=>'Id'),
		array('name'=>'type','filter'=>$model->getCaddTypes()),
                'name',
		array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'($data->idmetal0)?$data->idmetal0->namevar:NULL','filter'=>ComSpry::getMetals()),
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
