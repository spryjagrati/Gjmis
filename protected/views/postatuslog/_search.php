<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idpostatuslog'); ?>
		<?php echo $form->textField($model,'idpostatuslog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstatusm'); ?>
		<?php echo $form->textField($model,'idstatusm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instructions'); ?>
		<?php echo $form->textField($model,'instructions',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->