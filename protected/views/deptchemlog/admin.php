<?php
$this->breadcrumbs=array(
	'Deptchemlogs'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Deptchemlog', 'url'=>array('index')),
	array('label'=>'Create Deptchemstocks', 'url'=>array('createstocks')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('deptchemlog-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('getUnchecked', "
       function getUncheckeds(){
            var unch = [];
            $('[name^=check_box_id]').not(':checked,[name$=all]').each(function(){unch.push($(this).val());});
            return unch.toString();
       }
       "
);

?>



<h1>Manage Dept Chem Stocks</h1>

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
	'id'=>'deptchemlog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            array('name'=>'iddeptchemlog','header'=>'id'),
            array('name'=>'iddept','value'=>'$data->iddept0->locname'),
            array('name'=>'idchemical','value'=>'$data->idchemical0->name'),
		'qty',
            'cunit',
		'cdate',
		'mdate',
                'idpo',
            array('name'=>'refrcvd','value'=>'($data->refrcvd)?$data->refrcvd0->locname:NULL'),
            array('name'=>'refsent','value'=>'($data->refsent)?$data->refsent0->locname:NULL'),
            array('name'=>'updby','value'=>'$data->iduser0->username'),
             array(
                       'class'=>'CCheckBoxColumn',
                       'id'=>'check_box_ids',
                       'checked'=>'($data->acknow == 1)?true:false;',
                       'selectableRows'=>2,
                       'header'=>'Confirm',
                   ),

            array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}{stocksupdate}',
                    'buttons'=>array(
                        'stocksupdate'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'assets/d758dbc5/gridview/update.png',
                            'url'=>'Yii::app()->createUrl("deptchemlog/stocksupdate",array("id"=>$data->iddeptchemlog))',
                            
                        ),
                        
                    ),
                    'htmlOptions'=>array('style'=>'width:3%;'),
		),
	),
)); 
?>
<div id="for-link" style="float:right;">
<?php
   echo CHtml::ajaxLink('Update Grid',Yii::app()->createUrl('Deptchemlog/AjaxUpdategrid'),
        array(
           'type'=>'POST',
           'data'=>'js:{theIds : $.fn.yiiGridView.getChecked("deptchemlog-grid","check_box_ids").toString(),uncheckedIds:getUncheckeds()}',
           'success'=>"$('#deptchemlog-grid').yiiGridView.update('deptchemlog-grid')",
            'htmlOptions'=>array(
                                "style"=>'float:right;',
                        ),
        )
   );
?>
</div>






