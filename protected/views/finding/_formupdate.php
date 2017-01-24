<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'finding-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45,'disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('empty' => '')); ?>
		<?php echo $form->error($model,'idmetal'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9,'disabled'=>'disabled')); ?>
            <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">gms</p>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo CHtml::textField($model->getAttributeLabel('cost'), $model->cost, array('size'=>9,'disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'descri'); ?>
		<?php echo $form->textArea($model,'descri',array('cols'=>40,'rows'=>2,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'descri'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'supplier'); ?>
		<?php echo $form->textField($model,'supplier',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'supplier'); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'miracle'); ?>
		<?php echo $form->textField($model,'miracle',array('maxlength'=>7)); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">Only for Miracle Cap</p>
		<?php echo $form->error($model,'miracle'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->