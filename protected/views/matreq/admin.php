<?php
$this->breadcrumbs=array(
	'Matreqs'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Matreq', 'url'=>array('index')),
	array('label'=>'Create Matreq', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('matreq-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Matreqs</h1>

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
	'id'=>'matreq-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		array('name'=>'idmatreq','header'=>'Id'),
		'idpo',
		array('name'=>'type','filter'=>$model->getReqTypes(),'htmlOptions'=>array('style'=>'width:5%;'),),
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'($data->idmetal0)?$data->idmetal0->namevar:NULL',
                'filter'=>ComSpry::getMetals()),
            array('name'=>'idstone','header'=>'Stone','type'=>'raw','value'=>'($data->idstone0)?$data->idstone0->namevar:NULL',
                'filter'=>ComSpry::getStones()),
            array('name'=>'idchemical','header'=>'Chemical','type'=>'raw','value'=>'($data->idchemical0)?$data->idchemical0->name:NULL',
                'filter'=>ComSpry::getChemicals()),
            array('name'=>'idfinding','header'=>'Finding','type'=>'raw','value'=>'($data->idfinding0)?$data->idfinding0->name:NULL',
                'filter'=>ComSpry::getFindings()),
            array('name'=>'idstatusm','header'=>'Status','type'=>'raw','value'=>'($data->idstatusm0)?$data->idstatusm0->name:NULL',
                'filter'=>ComSpry::getTypeStatusms('REQ')),
		//'cdate',
		'mdate',
		'sdate',
		//'edate',
		'estdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
            array('name'=>'reqby','type'=>'raw','value'=>'$data->reqby0->locname',
                'filter'=>ComSpry::getLocDepts()),
            array('name'=>'reqto','type'=>'raw','value'=>'$data->reqto0->locname',
                'filter'=>ComSpry::getLocDepts()),
		//'notes',
		'rqty',
		'fqty',
		//'qunit',
		array(
			'class'=>'CButtonColumn',
                    'buttons'=>array(
                        'update'=>array(
                            'visible'=>'$data->idstatusm0->name=="Registered"',
                        ),
                        'delete'=>array(
                            'visible'=>'$data->idstatusm0->name=="Registered"',
                        ),
                    ),
                    'htmlOptions'=>array(
                        'style'=>'width:3%;'
                    ),
		),
	),
)); ?>
