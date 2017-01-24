<?php
$this->breadcrumbs=array(
	'Deptskulogs'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Deptskulog', 'url'=>array('index')),
	array('label'=>'Manage Stocks', 'url'=>array('admin')),
	array('label'=>'Upload Stocks', 'url'=>array('uploadStocks')),
);
?>

<h1>Create Stocks</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>


<?php 
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sku-grid',
	'dataProvider'=>$modelsku->search(),
	'filter'=>$modelsku,
	'columns'=>array(
		'idsku',
		'skucode',
                'tdnum',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'refpo',
		'totmetalwei',
		'totstowei',
		'numstones',
	),
    'pager'=>array
        (
        'class'=>'LinkListPager',
        'maxButtonCount'=>6,
        'header'=>''
        )
)); ?>