<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skuaddon-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>7,'maxlength'=>7, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idcostaddon',array('style'=>'width:15%')); ?>
		<?php echo $form->dropDownList($model,'idcostaddon',ComSpry::getCostadds(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idcostaddon'); ?>
		<?php echo $form->labelEx($model,'qty',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'qty',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->