<style>
    /**
    Change the below width and height to get desired thumb image (sudhanshu)
    */
    .imagethumb img{
   width: 50px;
  height: 50px;
}
</style>
<?php if(!Yii::app()->request->isAjaxRequest)
{
    ?>
<script >
 window.load=function(){alert("<?php Sku::model()->removeCookie('save-selection-admin'); ?>");}
</script>
        <?php
}?>
<?php
$this->breadcrumbs=array(
	'Skus'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Sku', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('#skufindingdrop').hide();
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sku-grid', {
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
$('.save_selection').click(function(){
    var checked = $('input[name=\"ids[]\"]:checked').length > 0;
    selected_sku = new Array();
    if (!checked){       
        alert('Please select atleast one SKU to save');
    }else{
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
});

$('#Sku_type').change(function(){
    var select = $('#Sku_type').val();
    if(select == 'Earrings'){
        $('#skufindingdrop').show();
    }else{
        $('#Sku_finding').val('');
        $('#skufindingdrop').hide();  
    } 
});");
?>

<h1>Manage Skus</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php   
    $start = 1; $end = 45;
    $url = Yii::app()->createUrl('product/getTotalCost', array('start'=>$start, 'end'=>$end));        
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php echo "<br>";
    echo CHtml::link('Upload Cost', $url ,array('class'=>'button' ,'target'=>'_blank')); ?>
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
	'id'=>'sku-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'selectableRows' => 2,
        'pager'=>array(
            'class'=>'LinkListPager', 
          //  'pageSize'=>10,
            ),

	'columns'=>array(

        'idsku',
		'skucode',
        array('type'=>'raw','value'=>'$data->metals[0]->namevar','name'=>'sku_metals',),
		'grosswt',
		array('name'=>'sku_size','type'=>'raw','value'=>'$data->skucontent->size'),
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		// 'refpo',
		array('type'=>'raw','value'=>'number_format($data->totmetalwei,"2",".","")','name'=>'totmetalwei',),
		array('type'=>'raw','value'=>'number_format($data->totstowei,"2",".","")','name'=>'totstowei',),
        array('type'=>'raw','value' => '$data->getgemwt($data->idsku)','name'=>'gemwt','filter'=>false,),
        array('type'=>'raw','value' => '$data->getdiawt($data->idsku)','name'=>'diawt','filter'=>false,),
		'numstones',        
        array('header'=>'image',
            'type'=>'Image',
            'value'=>array($this,'gridskuimages'),
            'htmlOptions'=>array('class'=>'imagethumb'), 
        ),
        array(
            'class'=>'CCheckBoxColumn',
            'header'=>'Review',
           // 'value'=>'$data->review',
            'id'=>'review',
            //'name'=>'review',
            'selectableRows'=>1,
            'checked'=>'($data->review==1)?1:0',
            'checkBoxHtmlOptions' => array( "ajax" =>
                array("type"=>"POST", 
                        'beforeSend'=>'function(){
                                var a = confirm("Are you sure?");
                                if(a==false){
                                    return false;
                                }
                            }
                        ',
                       "url"=>CController::createUrl("product/review"),
                        "data"=>"js:{'idsku':$(this).val()}",
                       "success"=>"function(data){
                            if(data=='success'){
                                $.fn.yiiGridView.update('sku-grid');
                                $('#message').html('Action completed successfully!');
                                 $('#message').fadeIn().fadeOut(3000);
                               
                                
                            }
                        }", 
                ),
                
                        )
        ),
        array(
            'type'=>'raw',
            'value'=>'CHtml::link(
            	"$$","",array(
            		"onClick"=>CHtml::ajax(
            		array(
            			"url"=>Yii::app()->createUrl("product/fetchCostDisplay",array("id"=>$data->idsku)),
            			"update"=>"#skuCostDisplay"
            		)),
            		"style"=>"cursor:pointer;"
            	)
			)'
		),
        array(
            'class'=>'CCheckBoxColumn',
            'header'=>'CHEK',
            'value'=>'$data->idsku',
            'checkBoxHtmlOptions' => array(
            'name' => 'ids[]',),
            'checked'=>'$data->getChecked_admin($data->idsku);',                                        
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("product/maintain",array("id"=>$data->idsku))',
                ),
            ),
            'htmlOptions'=>array('style'=>'width:3%;'),
		),
        array(
	        'class'=>'CButtonColumn',
            'template'=>'{duplicate}',
            'buttons'=>array(
                'duplicate'=>array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/duplicate.png',
                    'url'=>'Yii::app()->createUrl("product/duplicate",array("id"=>$data->idsku))',
                ),
            ),
            'htmlOptions'=>array('style'=>'width:3%;'),
		),
            
           
	),
   
)); ?>
<div class="buttonHolder" style="float:right;">
        <?php echo CHtml::button('Save selection',array('name'=>'save_selection','class'=>'save_selection')); ?>    
        <?php echo CHtml::button('Export',array('name'=>'export','class'=>'export')); ?>
</div>
<h2><div id="skuCostDisplay"></div></h2>
</fieldset>
<?php $this->endWidget(); ?>
