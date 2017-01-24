<?php
/* @var $this BeadController */
/* @var $model Bead */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idbeadsku'); ?>
		<?php echo $form->textField($model,'idbeadsku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'beadskucode'); ?>
		<?php echo $form->textField($model,'beadskucode',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dimhei'); ?>
		<?php echo $form->textField($model,'dimhei',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dimwid'); ?>
		<?php echo $form->textField($model,'dimwid',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dimlen'); ?>
		<?php echo $form->textField($model,'dimlen',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grosswt'); ?>
		<?php echo $form->textField($model,'grosswt',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'totmetalwei'); ?>
		<?php echo $form->textField($model,'totmetalwei',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'totstowei'); ?>
		<?php echo $form->textField($model,'totstowei',array('size'=>7,'maxlength'=>7)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numstones'); ?>
		<?php echo $form->textField($model,'numstones'); ?>
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