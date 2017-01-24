<?php
/* @var $this StonealiasController */
/* @var $model Stonealias */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstone_alias'); ?>
		<?php echo $form->textField($model,'idstone_alias'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'idstonem'); ?>
		<?php// echo $form->textField($model,'idstonem'); ?>
	</div> 

	<div class="row">
		<?php echo $form->label($model,'export'); ?>
		<?php echo $form->textField($model,'export'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idproperty'); ?>
		<?php echo $form->textField($model,'idproperty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->