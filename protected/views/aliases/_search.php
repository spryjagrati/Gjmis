<?php
/* @var $this AliasesController */
/* @var $model Aliases */
/* @var $form CActiveForm */
?>

<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
<!--	<div class="ctrlHolder">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>-->

	<div class="ctrlHolder">
		<?php echo $form->label($model,'aTarget'); ?>
		<?php echo $form->textField($model,'aTarget',array('size'=>60,'maxlength'=>64, 'class'=>'textInput','style'=>'width:25%;')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'aField'); ?>
		<?php echo $form->textField($model,'aField',array('size'=>60,'maxlength'=>64, 'class'=>'textInput','style'=>'width:25%;')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'initial'); ?>
		<?php echo $form->textField($model,'initial',array('size'=>60,'maxlength'=>64, 'class'=>'textInput','style'=>'width:25%;')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>64, 'class'=>'textInput','style'=>'width:25%;')); ?>
	</div>

	<div class="buttonHolder buttons">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
        
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->