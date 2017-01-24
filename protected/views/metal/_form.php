<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'metal-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'namevar'); ?>
		<?php echo $form->textField($model,'namevar',array('size'=>64,'maxlength'=>64,'class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'namevar'); ?>
	</div>


	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetalm'); ?>
		<?php echo $form->dropDownList($model,'idmetalm',ComSpry::getMasterMetals(),array('empty'=>'')); ?>
		<?php echo $form->error($model,'idmetalm'); ?>
		<?php echo $form->labelEx($model,'idmetalstamp',array('style'=>'width:10%')); ?>
		<?php echo $form->dropDownList($model,'idmetalstamp',ComSpry::getMetalStamps(),array('empty'=>'')); ?>
		<?php echo $form->error($model,'idmetalstamp'); ?>
		<?php echo $form->labelEx($model,'lossfactor',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'lossfactor',array('size'=>4,'maxlength'=>4,'class'=>'textInput','style'=>'width:8%;')); ?>
		<?php echo $form->error($model,'lossfactor'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'currentcost'); ?>
		<?php echo $form->textField($model,'currentcost',array('size'=>9,'maxlength'=>9,'class'=>'textInput','style'=>'width:10%;')); ?>
		<?php echo $form->error($model,'currentcost'); ?>
		<?php echo $form->labelEx($model,'chemcost',array('style'=>'width:15%')); ?>
		<?php echo $form->textField($model,'chemcost',array('size'=>5,'maxlength'=>5,'class'=>'textInput','style'=>'width:10%;')); ?>
		<?php echo $form->error($model,'chemcost'); ?>
	</div>
        <!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'prevcost'); ?>
		<?php echo CHtml::textField($model->getAttributeLabel('prevcost'), $model->prevcost, array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'prevcost'); ?>
	</div>
        
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>
        -->

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->