<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skuselmap-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idclient',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idclient',ComSpry::getClients(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idclient'); ?>
        </div>

	<div class="ctrlHolder">

		<?php echo $form->labelEx($model,'clientcode'); ?>
		<?php echo $form->textField($model,'clientcode',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:12%')); ?>
		<?php echo $form->error($model,'clientcode'); ?>

		<?php echo $form->labelEx($model,'csname',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'csname',array('size'=>45,'maxlength'=>45, 'class'=>'textInput', 'style'=>'width:25%')); ?>
		<?php echo $form->error($model,'csname'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->