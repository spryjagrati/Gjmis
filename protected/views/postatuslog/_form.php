<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'postatuslog-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo'); ?>
		<?php echo $form->error($model,'idpo'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'idstatusm'); ?>
		<?php echo $form->textField($model,'idstatusm'); ?>
		<?php echo $form->error($model,'idstatusm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'instructions'); ?>
		<?php echo $form->textField($model,'instructions',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'instructions'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->