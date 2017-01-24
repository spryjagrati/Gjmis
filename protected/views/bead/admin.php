<?php
/* @var $this BeadController */
/* @var $model Bead */

$this->breadcrumbs=array(
	'Beads'=>array('index'),
	'Manage',
);


$this->menu=array(
	array('label'=>'Create Bead', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bead-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

$('.export').click(function(){
    var checked = $('input[name=\"ids[]\"]:checked').length > 0;
    if (!checked)
    {       
        alert('Please select atleast one SKU to export');
    }else{
        document.getElementById('checked-export').action='export';
        document.getElementById('checked-export').submit();
    }
       
});
");
?>

<h1>Manage Beads</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
        'id'=>'checked-export',
        'enableAjaxValidation'=>false,'layoutName'=>'qtip',
        'htmlOptions'=>array('enctype' => 'multipart/form-data')
));
?>
<fieldset class="inlineLabels">
    <div id="message" style="display:none;"></div>
    <?php 
    Yii::import('ext.LinkListPager.LinkListPager');
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'bead-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'selectableRows' => 2,
		'pager'=>array(
            'class'=>'LinkListPager', 
          //  'pageSize'=>10,
         ),
		'columns'=>array(
			'idbeadsku',
			'beadskucode',
			'grosswt',
			'totmetalwei',
			'totstowei',
			'numstones',
			array(
	            'class'=>'CCheckBoxColumn',
	            'header'=>'CHECK',
	            'value'=>'$data->idbeadsku',
	            'checkBoxHtmlOptions' => array(
	            	'name' => 'ids[]',
	            ),                                     
	        ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}',
	            'buttons'=>array(
	                'update'=>array(
	                    'url'=>'Yii::app()->createUrl("bead/maintain",array("id"=>$data->idbeadsku))',
	                ),
	            ),
	            'htmlOptions'=>array('style'=>'width:3%;'),
			),
		),
	)); 
?>
<div class="buttonHolder" style="float:right;">
    <?php echo CHtml::button('Export',array('name'=>'export','class'=>'export')); ?>
</div>
</fieldset>
<?php $this->endWidget(); ?>















