<?php
$this->breadcrumbs=array(
	'Skufindings'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Skufindings', 'url'=>array('index')),
	array('label'=>'Create Skufindings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('skufindings-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Skufindings</h1>

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
	'id'=>'skufindings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'idskufindings',
		array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idsku0->skucode'),
		array('name'=>'idfinding','type'=>'raw','value'=>'$data->idfinding0->name'),
		'qty',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
                /*
		'updby',
		'cdate',
		'name',
		*/
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view}',
		),
	),
)); ?>