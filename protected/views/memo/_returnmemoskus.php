<?php 
Yii::app()->clientScript->registerScript('returnskus', "
$('.returnvalues').on('keyup',function(){
    $('.returnvalues').each(function(){
        var e = $(this).val();
        var v = $(this).attr('data-value-max');
        if($.isNumeric(e) && e >= 0 && e <= v){
            $('#returnskus').prop('disabled', false);
        }else{
            $('#returnskus').prop('disabled','disabled');
            return false;
        }
    });
});
");
?>

<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'returnmemo-skuform',
	'enableAjaxValidation'=>false,
)); ?>
  <fieldset class="inlineLabels">
       <?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
        <?php endif; ?>
      
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'returninvoicesku-grid',
	'dataProvider'=>$dataprovider,
        'selectableRows'=>2,
	'columns'=>array(
                
               array(
                    'name'=>'ID SKU',
                    'value'=>'$data->idsku'
                ),
                array(
                    'name'=>'SKU #',
                    'value'=>'$data->idsku0->skucode'
                ),
                
               array(            
                    'header'=>'Total Qty',
                    'type'=>'raw', 
                    //'value'=>array($this,'gridSkuStocks'), 
                    'value'=>'$data->totalstocks()', 
                ),
                array(
                        'header'=>'Shipped Qty',
                        'type'=>'raw',
                        'value'=>'$data->qty',
                    ),
                array(
                        'name'=>'Returned Qty',
                        'type'=>'raw',
                        'value'=>'CHtml::textField("memosku[$data->idmemosku]",Memosku::getReturnmemo($data->idmemosku)->qty,array("style"=>"width:50px;",  "class"=>"returnvalues", "id" => "$data->idmemosku"."id", "data-value-max" => $data->qty))',
                        'htmlOptions'=>array("width"=>"50px"),
                    ),
                
                
	),
)); ?>
        <div class="buttonHolder">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%', 'id'=>'returnskus')); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->