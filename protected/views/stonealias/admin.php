<?php
/* @var $this StonealiasController */
/* @var $model Stonealias */

$this->breadcrumbs=array(
	'Stonealiases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Stonealias', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#stonealias-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php 
$sheets = array(0=>'',1 => 'Amazon_Sheet', 2 => 'HT_Sheet', 3 => 'QB_Sheet', 4 =>'ZY_Sheet',5 =>'GKW_Sheet',6 =>'TH_Sheet',7 =>'QOV_Sheet',8 =>'QJC_Sheet',9 =>'JZ_Sheet');
$properties = array(1 => 'Color',2 => 'Birthstone', 3 =>'Treatment');

   ?>

<h1>Manage Stonealiases</h1>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonealias-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
       array('name'=>'idstonem','header'=>'Stonem','type'=>'raw',  'value' => '$data->getstone($data->idstonem)', 'filter'=>ComSpry::getStonem()),
		array('name'=>'export','header'=>'export','type'=>'raw','value'=>function($data, $row) use($sheets
        ){return $sheets[$data->export];}, 'filter' => $sheets,
                ),
		array('name'=>'idproperty','header'=>'Property','type'=>'raw','value'=>function($data, $row) use($properties
        ){return $properties[$data->idproperty];}, 'filter' => $properties,
                ),
		'alias',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
        ?>
