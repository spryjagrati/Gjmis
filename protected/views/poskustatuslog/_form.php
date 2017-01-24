<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'poskustatuslog-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idposku'); ?>
		<?php echo $form->textField($model,'idposku'); ?>
		<?php echo $form->error($model,'idposku'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reqdqty'); ?>
		<?php echo $form->textField($model,'reqdqty'); ?>
		<?php echo $form->error($model,'reqdqty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'processqty'); ?>
		<?php echo $form->textField($model,'processqty'); ?>
		<?php echo $form->error($model,'processqty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'delqty'); ?>
		<?php echo $form->textField($model,'delqty'); ?>
		<?php echo $form->error($model,'delqty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idprocdept'); ?>
		<?php echo $form->textField($model,'idprocdept'); ?>
		<?php echo $form->error($model,'idprocdept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'rcvddate'); ?>
		<?php echo $form->textField($model,'rcvddate'); ?>
		<?php echo $form->error($model,'rcvddate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dlvddate'); ?>
		<?php echo $form->textField($model,'dlvddate'); ?>
		<?php echo $form->error($model,'dlvddate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatusm'); ?>
		<?php echo $form->textField($model,'idstatusm'); ?>
		<?php echo $form->error($model,'idstatusm'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'descrip'); ?>
		<?php echo $form->textField($model,'descrip',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'descrip'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textField($model,'remark',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->