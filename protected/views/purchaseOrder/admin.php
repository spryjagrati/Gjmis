<?php
$this->breadcrumbs=array(
	'PurchaseOrder'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Po', 'url'=>array('po/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('po-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Purchase Orders</h1>

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
	'id'=>'po-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'idpo',
		array('name'=>'idclient','type'=>'raw','value'=>'$data->idclient0->name'),
		'dlvddate',
		'startdate',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		array('name'=>'idstatusm','type'=>'raw','value'=>'$data->idstatusm0->name'),
		'totamt',
            array('name'=>'idprocdept','type'=>'raw','value'=>'($data->idprocdept)?$data->idprocdept0->locname:NULL'),
		/*
		'instructions',
		*/
            array('type'=>'raw',
                'value'=>'CHtml::ajaxLink("$$",Yii::app()->createUrl("purchaseOrder/fetchCostDisplay",array("id"=>$data->idpo)),array(
                    "update"=>"#poCostDisplay",
                ));',
                'htmlOptions'=>array('style'=>'width:3%;'),
                ),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{maintain}{process}{reqs}{export}',
                    'buttons'=>array(
                        'maintain'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/maintain.gif',
                            'url'=>'Yii::app()->createUrl("purchaseOrder/maintain",array("id"=>$data->idpo))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                            'visible'=>'$data->idstatusm0->name=="Registered"',
                        ),
                        'process'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/process.gif',
                            'url'=>'Yii::app()->createUrl("purchaseOrder/process",array("id"=>$data->idpo))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                        ),
                        'reqs'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/reqs.gif',
                            'url'=>'Yii::app()->createUrl("purchaseOrder/requirements",array("id"=>$data->idpo))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                        ),
                         'export'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/export.png',
                            'url'=>'Yii::app()->createUrl("purchaseOrder/export",array("id"=>$data->idpo))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width:3%;'),
		),
	),
)); ?>

<h2><div id="poCostDisplay"></div></h2>