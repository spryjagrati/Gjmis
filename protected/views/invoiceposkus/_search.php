<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idinvoiceposkus'); ?>
		<?php echo $form->textField($model,'idinvoiceposkus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idinvoice'); ?>
		<?php echo $form->textField($model,'idinvoice'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idposkus'); ?>
		<?php echo $form->textField($model,'idposkus'); ?>
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
		<?php echo $form->label($model,'activ'); ?>
		<?php echo $form->textField($model,'activ',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->