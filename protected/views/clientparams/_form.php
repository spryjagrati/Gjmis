<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'clientparams-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
  <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idclient'); ?>
		<?php echo $form->dropDownList($model,'idclient',ComSpry::getClients()); ?>
		<?php echo $form->error($model,'idclient'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'defaultval'); ?>
		<?php echo $form->textField($model,'defaultval',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
		<?php echo $form->error($model,'defaultval'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'formula'); ?>
		<?php echo $form->textField($model,'formula',array('size'=>60,'maxlength'=>64,'class'=>'textInput', 'style'=>'width:23%')); ?>
		<?php echo $form->error($model,'formula'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>1,'maxlength'=>1,'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->