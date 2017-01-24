<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poskustones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idposku'); ?>
		<?php echo $form->textField($model,'idposku'); ?>
		<?php echo $form->error($model,'idposku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idskustone'); ?>
		<?php echo $form->textField($model,'idskustone'); ?>
		<?php echo $form->error($model,'idskustone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idstone'); ?>
		<?php echo $form->textField($model,'idstone'); ?>
		<?php echo $form->error($model,'idstone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->