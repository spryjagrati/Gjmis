<?php
$this->breadcrumbs=array(
	'Poskustatuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Poskustatus', 'url'=>array('index')),
	array('label'=>'Create Poskustatus', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('poskustatus-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Poskustatuses</h1>

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
	'id'=>'poskustatus-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'idposkustatus',
		'idposku',
		'reqdqty',
		'processqty',
		'delqty',
		'idprocdept',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
                array('name'=>'idstatusm','type'=>'raw','value'=>'$data->idstatusm0->name'),
                'mdate',
		'rcvddate',
                /*
		'cdate',
		'dlvddate',
		*/
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view}',
		),
	),
)); ?>
