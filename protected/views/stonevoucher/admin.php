<?php
$this->breadcrumbs=array(
	'Stonevouchers'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Stonevoucher', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stonevoucher-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Stonevouchers</h1>

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
	'id'=>'stonevoucher-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
                'idstonevoucher',
		array('name'=>'issuedto','type'=>'raw','value'=>'$data->iddept0->name."-".$data->iddept0->idlocation0->name'),
		array('name'=>'issuedfrom','type'=>'raw','value'=>'$data->iddept1->name."-".$data->iddept1->idlocation0->name'),
		'cdate',
		'mdate',
		'code',
		/*
		'acknow',
		*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{maintain}{delete}',
                         'buttons'=>array(
                            'maintain'=>array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/maintain.gif',
                                'url'=>'Yii::app()->createUrl("stonevoucher/maintain",array("id"=>$data->idstonevoucher))',
                            ),
                        ),
		),
	),
)); ?>