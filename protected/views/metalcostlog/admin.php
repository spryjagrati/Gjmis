<?php
$this->breadcrumbs=array(
	'Metalcostlogs'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Metalcostlog', 'url'=>array('index')),
	array('label'=>'Create Metalcostlog', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('metalcostlog-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Metalcostlogs</h1>

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
	'id'=>'metalcostlog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
            array('name'=>'idmetalcostlog','header'=>'No.'),
		//'idmetal',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'$data->idmetal0->idmetalm0->name."-".$data->idmetal0->idmetalstamp0->name'),
		//'cdate',
		'mdate',
		'cost',
		'updby',
            array('name'=>'updby','header'=>'UpdBy','type'=>'raw','value'=>'$data->iduser0->username'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
