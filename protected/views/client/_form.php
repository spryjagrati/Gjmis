<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
  <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45, 'class'=>'textInput','style'=>'width:23%')); ?>
		<?php echo $form->error($model,'name'); ?>
		<?php echo $form->labelEx($model,'commission',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'commission',array('size'=>4,'maxlength'=>4, 'class'=>'textInput','style'=>'width:8%')); ?>
		<?php echo $form->error($model,'commission'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45, 'class'=>'textInput','style'=>'width:33%')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'imgfolder'); ?>
		<?php echo $form->textField($model,'imgfolder',array('size'=>4,'maxlength'=>4, 'class'=>'textInput','style'=>'width:13%')); ?>
		<?php echo $form->error($model,'imgfolder'); ?>
		<?php echo $form->labelEx($model,'stimagesize',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'stimagesize',array('size'=>16,'maxlength'=>16, 'class'=>'textInput','style'=>'width:13%')); ?>
		<?php echo $form->error($model,'stimagesize'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->