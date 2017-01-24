<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'metalcostlog-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->textField($model,'idmetal'); ?>
		<?php echo $form->error($model,'idmetal'); ?>
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
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->