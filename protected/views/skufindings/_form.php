<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skufindings-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idfinding',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindings(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idfinding'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:2%')); ?>
		<?php echo $form->error($model,'qty'); ?>
		<?php echo $form->labelEx($model,'name',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:20%')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->