<?php
$this->breadcrumbs=array(
	'Metals'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Metal', 'url'=>array('index')),
	array('label'=>'Create Metal', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('metal-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Metals</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metal-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
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
		array(            
                    'name'=>'stocks',
                    'type'=>'raw', //because of using html-code <br/>
                    //call the controller method gridProduct for each row
                    'value'=>array($this,'gridMetalStocks'), 
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
