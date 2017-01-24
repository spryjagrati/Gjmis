<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'setting-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
 <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'setcost'); ?>
		<?php echo $form->textField($model,'setcost',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'setcost'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'bagcost'); ?>
		<?php echo $form->textField($model,'bagcost',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'bagcost'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->