<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoiceposkus-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idinvoice'); ?>
		<?php echo $form->textField($model,'idinvoice'); ?>
		<?php echo $form->error($model,'idinvoice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idposkus'); ?>
		<?php echo $form->textField($model,'idposkus'); ?>
		<?php echo $form->error($model,'idposkus'); ?>
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
		<?php echo $form->labelEx($model,'activ'); ?>
		<?php echo $form->textField($model,'activ',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'activ'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->