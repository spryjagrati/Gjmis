<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'locations-form',
	'enableAjaxValidation'=>false,
)); ?>
 <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?php echo $form->textArea($model,'desc',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Create',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>

    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->