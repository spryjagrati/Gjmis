<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstonevoucher'); ?>
		<?php echo $form->textField($model,'idstonevoucher'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'issuedto'); ?>
		<?php echo $form->textField($model,'issuedto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'issuedfrom'); ?>
		<?php echo $form->textField($model,'issuedfrom'); ?>
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
		<?php echo $form->label($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acknow'); ?>
		<?php echo $form->textField($model,'acknow'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->