<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="uniForm">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->label($model,'package_length'); ?>
		<?php echo $form->textField($model,'package_length',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->label($model,'package_height'); ?>
		<?php echo $form->textField($model,'package_height',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>

       <div class="ctrlHolder">
		<?php echo $form->label($model,'package_width'); ?>
		<?php echo $form->textField($model,'package_width',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->label($model,'dimension_unit'); ?>
		<?php echo $form->textField($model,'dimension_unit',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:50%')); ?>
	</div>
	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->