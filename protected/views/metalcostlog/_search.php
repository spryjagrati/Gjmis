<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idmetalcostlog'); ?>
		<?php echo $form->textField($model,'idmetalcostlog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('empty' => '')); ?>
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
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby', ComSpry::getAllUserDropDownList(),array('empty' => '')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->