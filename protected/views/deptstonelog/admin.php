<?php
$this->breadcrumbs=array(
	'Stonestocks'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Deptstonelog', 'url'=>array('index')),
	array('label'=>'Create Stonestocks', 'url'=>array('stockscreate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
function allFine(data) {
                // refresh your grid
                $.fn.yiiGridView.update('deptstonelog-grid');
        }
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('deptstonelog-grid', {
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


<h1>Manage Dept Stone Stocks</h1>

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

/*---Sprymanish changes dec 28 start----- */
Yii::import('ext.LinkListPager.LinkListPager');
/*---Sprymanish changes dec 28 end----- */
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'deptstonelog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'columns'=>array(
            array('name'=>'idstonestocks','header'=>'Id'),
            array('name'=>'iddept','value'=>'$data->iddept0->locname'),
            array('name'=>'idstone','value'=>'$data->idstone','header'=>'Id Stone'),
            array('name'=>'gemstone','value'=>'$data->idstone0->namevar'),
            /*---Sprymanish changes dec 28 start----- */
            array('name'=>'gem_shape','header'=>'Shape','value'=>'$data->idstone0->idshape0->name'),
		array('name'=>'gem_size','header'=>'Size','value'=>'$data->idstone0->idstonesize0->size'),
		array('name'=>'stonewt','header'=>'Ct. Wt.','value'=>'abs($data->stonewt)'),
            /*---Sprymanish changes dec 28 end----- */
	    array('name'=>'qty','header'=>'Quantity','value'=>'abs($data->qty)'),
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
//                       'htmlOptions'=>array(
//                                "ajax"=>array(
//                                           "type"=>"POST",
//                                           "url"=>Yii::app()->controller->createUrl("Deptstonelog/AjaxUpdategrid",array("id"=>$data->iddeptstonelog)), 
//                                          "success"=>"$('#deptstonelog-grid').yiiGridView.update('#deptstonelog-grid')",
//                                          "data"=>"js:{theIds : $.fn.yiiGridView.getChecked('deptstonelog-grid','check_box_ids').toString()}",
//                                         ),
//                        ),
                   ),

		 array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}{stocksupdate}',
                    'buttons'=>array(
                        'stocksupdate'=>array(
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
                            'url'=>'Yii::app()->createUrl("deptstonelog/stocksupdate",array("id"=>$data->idstonestocks))',
                            
                        ),
                        
                        
                    ),
                    'htmlOptions'=>array('style'=>'width:3%;'),
		),
	),
));


?>
<div id="for-link" style="float:right;">
<?php
   echo CHtml::ajaxLink('Update Grid',Yii::app()->createUrl('Deptstonelog/AjaxUpdategrid'),
        array(
           'type'=>'POST',
           'data'=>'js:{theIds : $.fn.yiiGridView.getChecked("deptstonelog-grid","check_box_ids").toString(),uncheckedIds:getUncheckeds()}',
           'success'=>"$('#deptstonelog-grid').yiiGridView.update('deptstonelog-grid')",
            'htmlOptions'=>array(
                                "style"=>'float:right;',
                        ),
        )
   );
?>
</div>
