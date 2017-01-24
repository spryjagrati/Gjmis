<?php
/* @var $this AliasesController */
/* @var $model Aliases */

$this->breadcrumbs=array(
	'Aliases'=>array('create'),
	'Manage',
);

 
$this->menu=array(
	//array('label'=>'List Aliases', 'url'=>array('index')),
	array('label'=>'Create Aliases', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#aliases-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Aliases</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php 
	// $atarget = 12 ;$start = 699; $end = 700;
	// $url = Yii::app()->createUrl('aliases/changeAFields', array('atarget'=>$atarget,'start'=>$start,'end'=>$end));
	// echo "<br>";
 //    echo CHtml::link('Update Field', $url ,array('class'=>'button' ,'target'=>'_blank')); ?>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$values = array('0'=>'All') + ComSpry::getClients()
   ?>
   
<?php Yii::import('ext.LinkListPager.LinkListPager'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'aliases-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'pager'=>array(
            'class'=>'LinkListPager', 
          //  'pageSize'=>10,
            ),
	'columns'=>array(
        array('name'=>'aTarget','header'=>'aTarget','type'=>'raw',
        	'filter' => $values,
        	'value'=>function($data, $row) use($values
        ){return $values[$data->aTarget];},
                ),
            
		'aField',
		'initial',
		'alias',
        array(
	        'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
		),
	),
)); ?>
<h1 style="margin-bottom:-22px;">Dependent Aliases</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'deptaliases-grid',
	'dataProvider'=>$deptalias->search(),
	'filter'=>$deptalias,
	'pager'=>array(
            'class'=>'LinkListPager', 
          //  'pageSize'=>10,
            ),
	'columns'=>array(
           array('name'=>'target','header'=>'aTarget', 'type'=>'raw', 
               'filter' => CHtml::dropDownList('DependentAlias[target]',$deptalias->target,array('0'=>'All') + ComSpry::getClients()),
               'value'=>function($data, $row) use($values){
               	return $values[$data->idaliases0->aTarget];},
            ),
            array('name'=>'field','header'=>'Field', 'type'=>'raw', 'value'=>'$data->idaliases0->aField'),
            array('name'=>'primary', 'header'=>'Primary', 'type'=>'raw', 'value'=>'$data->idaliases0->initial'),
            array('name'=>'idaliases','header'=>'Alias', 'value'=>'$data->idaliases0->alias' ),
            array('name'=>'column', 'header'=>'Dependent Column', 'type'=>'raw'),
            array('name'=>'alias', 'header'=>'Dependent Alias', 'type'=>'raw'),
	),
));
        ?>
