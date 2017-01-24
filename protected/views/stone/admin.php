<?php
$this->breadcrumbs=array(
	'Stones'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Stone', 'url'=>array('index')),
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

$('.reset_selection').click(function(){
    $('input:checkbox[name=\"ids[]\"]:checked').each(function(){
             $('input:checkbox').removeAttr('checked');
    }); 
    $.ajax({
        'type':'post',
        'url': 'resetCookie',
        'success': function() {
            $.fn.yiiGridView.update('stone-grid');
        },
    });
});

$('.export').click(function(){
    var checked = $('input[name=\"ids[]\"]:checked').length > 0;
    if (!checked){
        alert('Please select atleast one SKU to export');
    }else{
        document.getElementById('checked-export').action='export';
        document.getElementById('checked-export').submit();
    }
       
});


function getCheckids(){
    selected_sku = new Array();
    $('input:checkbox[name=\"ids[]\"]:checked').each(function(){
            selected_sku.push($(this).val());
    }); 
    $.ajax({
        'type':'post',
        'url':'admin',
        'data':{selected_sku:selected_sku},
        'success': function(g) {
            $('input:checkbox[name=\"ids[]\"]:checked').each(function(){
                 this.checked = false;
            }); 
        },
    });
}

");
?>

<h1>Manage Stones</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<?php $stonetype = array('1'=>'Jewelry' , '2'=>'Beads')?>
</div><!-- search-form -->
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
        'id'=>'checked-export',
        'enableAjaxValidation'=>false,'layoutName'=>'qtip',
        'htmlOptions'=>array('enctype' => 'multipart/form-data')
));
?>
 <div id="message" style="display:none;"></div>
<?php 
  /* ---- SPry manish dec 31 2012 start-----*/
Yii::import('ext.LinkListPager.LinkListPager');
 /* ---- SPry manish dec 31 2012 End-----*/
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stone-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
      /* ---- SPry manish dec 31 2012 start-----*/
    'selectableRows' => 2,
   'pager'=>array(
    'class'=>'LinkListPager', 
    ),
    'beforeAjaxUpdate'=>'function(id,options){
        options.data={checkedIds:getCheckids()};
        return true;
    }',

   // 'ajaxUpdate'=>true,
    //'enablePagination' => true,

      /* ---- SPry manish dec 31 2012 End-----*/
	'columns'=>array(
		'idstone',
		'namevar',
		array('name'=>'idstonem','header'=>'StoneM','type'=>'raw','value'=>'$data->idstonem0->name','filter'=>ComSpry::getStonem()),
		array('name'=>'idshape','header'=>'Shape','type'=>'raw','value'=>'$data->idshape0->name','filter'=>ComSpry::getShapes()),
		//array('name'=>'idclarity','header'=>'Clarity','type'=>'raw','value'=>'$data->idclarity0->name','filter'=>ComSpry::getClarities()),
		array('name'=>'idstonesize','header'=>'Size','type'=>'raw','value'=>'$data->idstonesize0->size','filter'=>ComSpry::getStonesizes()),
		'color',
		'quality',
		'cut',
    'weight',
    array('name'=>'jewelry_type','header'=>'Type','type'=>'raw','value'=>'($data->jewelry_type == 1)?"Jewelry":"Beads"','filter'=>$stonetype),
		array('name'=>'curcost','header'=>'Price /Ct','value'=>'($data->weight!=0)?round($data->curcost/$data->weight,2):""'),
		'mdate',
    // array(
    //         'class'=>'CCheckBoxColumn',
    //         'header'=>'Review',
    //        // 'value'=>'$data->review',
    //         'id'=>'review',
    //         //'name'=>'review',
    //         'selectableRows'=>1,
    //         'checked'=>'($data->review==1)?1:0',
    //         'checkBoxHtmlOptions' => array( "ajax" =>
    //                     array("type"=>"POST", 
    //                             'beforeSend'=>'function(){
    //                                     var a = confirm("Are you sure?");
    //                                     if(a==false){
    //                                         return false;
    //                                     }
    //                                 }
    //                             ',
    //                            "url"=>CController::createUrl("stone/review"),
    //                             "data"=>"js:{'idstone':$(this).val()}",
    //                            "success"=>"function(data){
    //                                 if(data=='success'){
    //                                     $.fn.yiiGridView.update('stone-grid');
    //                                     $('#message').html('Action completed successfully!');
    //                                      $('#message').fadeIn().fadeOut(3000);
                                       
                                        
    //                                 }
    //                             }", 
    //                     ),
    
    //         )
    //   ),
        array(
            'class'=>'CCheckBoxColumn',
            'header'=>'CHECK',
            'id'=>'someChecks',
            'value'=>'$data->idstone',
            'checkBoxHtmlOptions' => array(
                'name' => 'ids[]',
            ),
            'checked'=>'$data->getChecked_admin($data->idstone);', 
        ),
               
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<div class="buttonHolder" style="float:right;">
    <?php echo CHtml::button('Reset Selection',array('name'=>'reset_selection','class'=>'reset_selection')); ?>
    <?php echo CHtml::button('Export Selection',array('name'=>'export','class'=>'export')); ?>
</div>

<?php $this->endWidget(); ?>
