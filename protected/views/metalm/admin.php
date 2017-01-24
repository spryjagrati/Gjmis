<?php
$this->breadcrumbs=array(
	'Metalms'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Metalm', 'url'=>array('index')),
	array('label'=>'Create Metalm', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('metalm-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Master Metals</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->renderPartial('_rateform',array(
	'model'=>$model,
)); ?>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metalm-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'idmetalm',
		'name',
                'currentcost',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
