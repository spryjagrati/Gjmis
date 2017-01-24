<?php 
Yii::app()->clientScript->registerScript('toggleselect', "
$('#Memo_iddptfrom').on('change',function(){
    $.ajax({
                type: 'POST',
                url: './UpdateAjax',
                data: {dept: $(this).val()},
                dataType: 'html',
                success: function(data){ $('span#updatemutli').replaceWith(data) },
    });
});
");
?>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'approvalmemo-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
      <fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, $skumodel); ?>
        <?php if($model->isNewRecord){?>
            <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'iddptfrom'); ?>
		<?php echo $form->dropDownList($model,'iddptfrom',ComSpry::getLocationsdeptfrom(),array('class'=>'textInput')); ?>
		<?php echo $form->error($model,'iddptfrom'); ?>
            </div>

            <div class="ctrlHolder">
                    <?php echo $form->labelEx($model,'memoto'); ?>
                    <?php echo $form->textField($model,'memoto', array('class'=>'textInput')); ?>
                    <?php echo $form->error($model,'memoto'); ?>
            </div>
        
            <div class="ctrlHolder">
                    <?php echo $form->labelEx($model,'remark'); ?>
                    <?php echo $form->textArea($model,'remark',array('rows'=>2,'cols' => 40,'maxlength'=>512,'class'=>'textInput', 'style' => 'height: 7em;')); ?>
                    <?php echo $form->error($model,'remark'); ?>
            </div>

            <div class="ctrlHolder">
                    <?php echo $form->labelEx($skumodel,'idsku'); ?>
                    <span id="updatemutli">
                        <?php 
                            $this->renderPartial('_ajaxmultiContent', array('skumodel'=>$skumodel, 'dept' => $dept));
                        ?>
                    </span>
                    <?php echo "Comma Separated"; ?>
                    <?php echo $form->error($skumodel,'idsku'); ?>
            </div>
        <?php }else{ ?>
            <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'iddptfrom'); ?>
		<?php echo $form->dropDownList($model,'iddptfrom',ComSpry::getLocationsdeptfrom(),array('class'=>'textInput', 'empty' => '', 'disabled'=>'disabled')); ?>
            </div>

            <div class="ctrlHolder">
                    <?php echo $form->labelEx($model,'memoto'); ?>
                    <?php echo $form->textField($model,'memoto', array('class'=>'textInput', 'disabled'=>'disabled')); ?>
            </div>
        
            <div class="ctrlHolder">
                    <?php echo $form->labelEx($model,'remark'); ?>
                    <?php echo $form->textArea($model,'remark',array('rows'=>2,'cols' => 40,'maxlength'=>512,'class'=>'textInput', 'style' => 'height: 7em;')); ?>
            </div>

            <div class="ctrlHolder">
                    <?php echo $form->labelEx($skumodel,'idsku'); ?>
                    <?php echo $form->textField($skumodel,'idsku', array('class'=>'textInput', 'disabled'=>'disabled', 'value' => Memosku::getskus($model->idmemo, 2))); ?>
                    <?php echo "Comma Separated"; ?>
            </div>
        <?php } ?>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetalm'); ?>
		<?php echo $form->dropDownList($model, 'idmetalm', ComSpry::getMasterMetals(), array('class'=>'textInput', 'empty' => '')); ?>
		<?php echo $form->error($model,'idmetalm'); ?>
	</div>
        
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Memo::getStatus(1), array('class'=>'textInput')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->