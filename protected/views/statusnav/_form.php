<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'statusnav-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatusf'); ?>
		<?php echo $form->dropDownList($model,'idstatusf', ComSpry::getTypenameStatusms(), array('class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstatusf'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatust'); ?>
		<?php echo $form->dropDownList($model,'idstatust', ComSpry::getTypenameStatusms(), array('class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstatust'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->