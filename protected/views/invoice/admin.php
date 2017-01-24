<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Invoice', 'url'=>array('index')),
	array('label'=>'Create Invoice', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('invoice-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<h1>Manage Invoices</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<br />
<?php if(Yii::app()->user->hasFlash('error')):?>
    <div style="color:red;">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>
<br />
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">

</div><!-- search-form -->
<?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
<?php endif; ?>
<?php 
Yii::import('ext.LinkListPager.LinkListPager');

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->searchInvoices(),
	'filter'=>$model,
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
		'invoice_num',
                'createdby',
		array('name'=>'idlocation','type'=>'raw','value'=>'$data->iddept0->idlocation0->name'),
		array('header'=>'locationuser','type'=>'raw','value'=>'$data->locusers[0]->username'),
		'cdate',
		'mdate',
                array('header'=>'Total Skus','value'=>array($this,'gridTotalSkus')),
                array('header'=>'Total Amount','value'=>'$data->getTotalPrice()'),
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
                array('name'=>'activ','type'=>'raw','value'=>'($data->activ == 0)?"False":"True";','filter'=>array(1=>"True",0=>"False")),
                array('name'=>'ship','type'=>'raw','value'=>'($data->ship == 0)?"False":"True";','filter'=>array(1=>"True",0=>"False")),
                array('name'=>'retrn','type'=>'raw','value'=>'($data->retrn == 0)?"False":"True";','filter'=>array(1=>"True",0=>"False")),
		array('header'=>'Return Date', 'value'=>'$data->idlocationinvoice0->duedate'),
                array(
			'class'=>'CButtonColumn',
                    'template'=>'{update}{export}{return}{delete}',
                    'buttons'=>array(
                        'update',
                         'export'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/export.png',
                            'url'=>'Yii::app()->createUrl("invoice/externalInvoice",array("id"=>$data->idinvoice))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                        ),
                        'return'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/return.png',
                            'url'=>'Yii::app()->createUrl("invoice/returnInvoice",array("id"=>$data->idinvoice))',
                            'options'=>array('style'=>'display:inline-block;margin:5px;'),
                        ),
                    ),
                    'htmlOptions'=>array('style'=>'width:13%;'),
		),
	),
)); 
?>
