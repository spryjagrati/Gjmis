<?php
$this->breadcrumbs=array(
	'Findings'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Finding', 'url'=>array('index')),
	array('label'=>'Create Finding', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('finding-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Findings</h1>

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
	'id'=>'finding-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'idfinding',
		'name',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'($data->idmetal0)?$data->idmetal0->namevar:NULL','filter'=>ComSpry::getMetals()),
		'weight',
		'cost',
		'mdate',
                'size',
		array(            
                    'name'=>'stocks',
                    'type'=>'raw', //because of using html-code <br/>
                    //call the controller method gridProduct for each row
                    'value'=>array($this,'gridFindingStocks'), 
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
