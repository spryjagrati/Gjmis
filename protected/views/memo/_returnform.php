<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'approvalreturnmemo-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
      <fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, $skumodel); ?>

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
        
            <?php if($model->type == 2){ ?>
                <div class="ctrlHolder">
                        <?php echo $form->labelEx($model,'idmetalm'); ?>
                        <?php echo $form->dropDownList($model, 'idmetalm', ComSpry::getMasterMetals(), array('class'=>'textInput', 'empty' => '')); ?>
                        <?php echo $form->error($model,'idmetalm'); ?>
                </div>
            <?php }?>
        
            <div class="ctrlHolder">
                    <label class="required" for="Memo_status">Return <span class="required">*</span></label>
                    <?php echo $form->dropDownList($model, 'status', array(3 => "true", 1 => "false"), array('class'=>'textInput')); ?>
                    <?php echo $form->error($model,'status'); ?>
            </div>

            <div class="buttonHolder">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
            </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->