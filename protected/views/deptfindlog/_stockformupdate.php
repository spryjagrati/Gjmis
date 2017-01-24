<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'deptfindlog-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'iddept'); ?>
		<?php echo $form->dropDownList($model,'iddept',array('4'=>'Purchase'),array('class'=>'selectInput','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'iddept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idfinding'); ?>
		<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindings(),array('class'=>'selectInput',  'empty' => '','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'idfinding'); ?>
	</div>

<!--	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>-->
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty', array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'qty'); ?>
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

<!--	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo'); ?>
		<?php echo $form->error($model,'idpo'); ?>
	</div>-->

	

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->