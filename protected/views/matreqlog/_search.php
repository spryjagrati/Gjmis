<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idtbl_matreqlog'); ?>
		<?php echo $form->textField($model,'idtbl_matreqlog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idmatreq'); ?>
		<?php echo $form->textField($model,'idmatreq'); ?>
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
		<?php echo $form->label($model,'rqty'); ?>
		<?php echo $form->textField($model,'rqty',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fqty'); ?>
		<?php echo $form->textField($model,'fqty',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstatusm'); ?>
		<?php echo $form->textField($model,'idstatusm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->