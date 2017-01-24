<?php 
Yii::app()->clientScript->registerScript('toggleselect', "
$('.shipvalues').on('keyup',function(){
    $('.shipvalues').each(function(){
        var e = $(this).val();
        var v = $(this).attr('data-value-max');
        if($.isNumeric(e) && e >= 0 && e <= parseInt(v)){
            $('#submitskus').prop('disabled', false);
        }else{
            $('#submitskus').prop('disabled','disabled');
            return false;
        }
    });
});
");
?>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'memo-skuform',
	'enableAjaxValidation'=>false,
));  ?>
  <fieldset class="inlineLabels">
       <?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
        <?php endif; ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoicesku-grid',
	'dataProvider'=>$dataprovider,
        'selectableRows'=>2,
	'columns'=>array(
                
               array(
                    'name'=>'SKU #',
                    'value'=>'$data->idsku0->skucode'
                ),
                 array(
                    'header'=>'Dept From',
                     'type'=>'raw',
                    'value'=>'"'.Chtml::encode($model->iddept->name).'"',
                ),
                array(
                    'name'=>'To',
                    'type'=>'raw',
                    'value'=>'"'.Chtml::encode($model->memoto).'"',
                ),
                array(
                        'name'=>'Available Qty',
                        'value'=>'$data->totqty - $data->qtyship'
                    ),
               
                
                array(
                        'name'=>'Qty to be shipped',
                        'type'=>'raw',
                        'value'=>'CHtml::textField("shipped[$data->idlocationstocks]",Memosku::getShippedqty('.$model->idmemo.',$data->idsku),array("style"=>"width:50px;", "data-value-max" => ($data->totqty - $data->qtyship) + Memosku::getShippedqty('.$model->idmemo.',$data->idsku), "id" => "$data->idlocationstocks"."id", "class"=>"shipvalues"))',
                        'htmlOptions'=>array("width"=>"50px"),
                    ),
                array(
                        'name'=>'idsku',
                         'type'=>'raw',
                        'value'=>'CHtml::textField("idsku",$data->idsku,array("style"=>"width:50px;"))',
                        'visible'=>false
                )
	),
)); ?>
      
        <div class="buttonHolder">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%', 'id'=>'submitskus')); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->