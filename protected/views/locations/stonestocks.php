<?php
$this->breadcrumbs=array(
	'Stones'=>array('index'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create Stone', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stone-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Stones</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stone-grid',
	'dataProvider'=>$dataprovider,
	'columns'=>array(
		'namevar',
		'size',
		'color',
		'quality',
		'cut',
                'weight',
                'curcost',
		//array('name'=>'curcost','header'=>'Price /Ct','value'=>'($data->weight!=0)?round($data->curcost/$data->weight,2):""'),
		
                    array(            
                        'name'=>'stocks',
                        'type'=>'raw', //because of using html-code <br/>
                        //call the controller method gridProduct for each row
                        'value'=>array($this,'gridStoneStocks'), 
                    ),
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>
