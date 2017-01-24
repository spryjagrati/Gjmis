<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idtbl_poskustones'); ?>
		<?php echo $form->textField($model,'idtbl_poskustones'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idposku'); ?>
		<?php echo $form->textField($model,'idposku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idskustone'); ?>
		<?php echo $form->textField($model,'idskustone'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstone'); ?>
		<?php echo $form->textField($model,'idstone'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->