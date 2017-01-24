<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skustones-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idstone',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstone'); ?>
		<?php echo $form->labelEx($model,'idsetting',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idsetting', ComSpry::getSettings(), array('class'=>'selectInput', 'style'=>'width:8%','empty'=>'')); ?>
		<?php echo $form->error($model,'idsetting'); ?>
		<?php echo $form->labelEx($model,'type',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%','empty'=>'')); ?>
		<?php echo $form->error($model,'type'); ?>

	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'pieces'); ?>
		<?php echo $form->textField($model,'pieces',array('size'=>2,'maxlength'=>2, 'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php echo $form->error($model,'pieces'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->