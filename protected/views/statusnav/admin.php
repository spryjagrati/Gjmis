<?php
$this->breadcrumbs=array(
	'Statusnavs'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Statusnav', 'url'=>array('index')),
	array('label'=>'Create Statusnav', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('statusnav-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Statusnavs</h1>

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
	'id'=>'statusnav-grid',
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'idstatusnav',
            array('name'=>'type','type'=>'raw','value'=>'$data->idstatusf0->type'),
		array('name'=>'idstatusf','type'=>'raw','value'=>'$data->idstatusf0->name'),
		array('name'=>'idstatust','type'=>'raw','value'=>'$data->idstatust0->name'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
