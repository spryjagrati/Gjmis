<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stonem-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'name'); ?>
		<?php echo $form->labelEx($model,'type',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%','empty'=>'')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>



	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'creatmeth'); ?>
		<?php echo $form->textField($model,'creatmeth',array('size'=>64,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:11%'));  ?>
		<?php echo $form->error($model,'creatmeth'); ?>
		<?php echo $form->labelEx($model,'treatmeth',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'treatmeth',array('size'=>64,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:11%')); ?>
		<?php echo $form->error($model,'treatmeth'); ?>
		<?php echo $form->labelEx($model,'scountry',array('style'=>'width:15%')); ?>
		<?php echo $form->textField($model,'scountry',array('size'=>32,'maxlength'=>32, 'class'=>'textInput', 'style'=>'width:11%')); ?>
		<?php echo $form->error($model,'scountry'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
