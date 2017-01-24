<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstonestocks'); ?>
		<?php echo $form->textField($model,'idstonestocks'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iddept'); ?>
		<?php echo $form->textField($model,'iddept'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstone'); ?>
		<?php echo $form->textField($model,'idstone'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
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
		<?php echo $form->label($model,'refrcvd'); ?>
		<?php echo $form->textField($model,'refrcvd'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'refsent'); ?>
		<?php echo $form->textField($model,'refsent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->