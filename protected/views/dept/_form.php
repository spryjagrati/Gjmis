<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'dept-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idlocation'); ?>
		<?php echo $form->dropDownList($model,'idlocation',  ComSpry::getLocation(),array('empty'=>'')); ?>
		<?php echo $form->error($model,'idlocation'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',$model->getDeptTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->