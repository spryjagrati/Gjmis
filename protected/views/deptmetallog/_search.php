<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'iddeptmetallog'); ?>
		<?php echo $form->textField($model,'iddeptmetallog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idmetal'); ?>
		<?php echo $form->textField($model,'idmetal'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'iddept'); ?>
		<?php echo $form->textField($model,'iddept'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cunit'); ?>
		<?php echo $form->textField($model,'cunit',array('size'=>16,'maxlength'=>16)); ?>
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