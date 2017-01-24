<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstatusnav'); ?>
		<?php echo $form->textField($model,'idstatusnav'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstatusf'); ?>
		<?php echo $form->dropDownList($model,'idstatusf', ComSpry::getTypenameStatusms(), array('class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstatust'); ?>
		<?php echo $form->dropDownList($model,'idstatust', ComSpry::getTypenameStatusms(), array('class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->