<?php
$this->breadcrumbs=array(
	'Deptskulogs'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Deptskulog', 'url'=>array('index')),
	array('label'=>'Create Stocks', 'url'=>array('create')),
	array('label'=>'Upload Stocks', 'url'=>array('uploadStocks')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('deptskulog-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sku Stocks and their Movement</h1>

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
	'id'=>'deptskulog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
                array('name'=>'iddept','type'=>'raw','value'=>'Department','value'=>'$data->iddept0->idlocation0->name."-".$data->iddept0->name'),
		array('name'=>'idsku','header'=>'SKU#','type'=>'raw','value'=>'$data->idsku0->skucode'),
                'po_num',
		array('name'=>'pricepp','header'=>'Pricepp','type'=>'raw','value'=>'$data->pricepp'),
                array('name'=>'refsent','header'=>'Skus Sent to','type'=>'raw','value'=>'Dept::getDeptname($data->refsent)'),
                array('name'=>'refrcvd','header'=>'Skus Received from','type'=>'raw','value'=>'Dept::getDeptname($data->refrcvd)'),
		array('name'=>'qty','header'=>'Total Quantity','type'=>'raw','value'=>'abs($data->qty)'),
		'mdate',
		/*
		'mdate',
		'updby',
		'refrcvd',
		'refsent',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
