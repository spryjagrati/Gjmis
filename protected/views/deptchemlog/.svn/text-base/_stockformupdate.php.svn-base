<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'deptstockchem-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idchemical'); ?>
		<?php echo $form->dropDownList($model,'idchemical',ComSpry::getChemicals(),array('class'=>'selectInput','empty' => '','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'idchemical'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'iddept'); ?>
		<?php echo $form->dropDownList($model,'iddept',array('4'=>'Purchase'),array('class'=>'selectInput','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'iddept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>9,'maxlength'=>9, array('style'=>'width:20%'))); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cunit'); ?>
		<?php echo $form->textField($model,'cunit',array('size'=>16,'maxlength'=>16,'disabled'=>'disabled', 'style'=>'width:20%')); ?>
		<?php echo $form->error($model,'cunit'); ?>
	</div>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refrcvd'); ?>
		<?php echo $form->dropDownList($model,'refrcvd',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'refrcvd'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refsent'); ?>
		<?php echo $form->dropDownList($model,'refsent',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'refsent'); ?>
	</div>
	
	

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->