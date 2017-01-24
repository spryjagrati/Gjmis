<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skumetals-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idmetal'); ?>

		<?php echo $form->labelEx($model,'weight',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9,'class'=>'textInput','style'=>'width:5%')); ?>
		<?php echo $form->error($model,'weight'); ?>

            	<?php echo $form->labelEx($model,'lossfactor',array('style'=>'width:12%')); ?>
		<?php echo $form->textField($model,'lossfactor',array('size'=>4,'maxlength'=>4)); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">%</p>
                <?php echo $form->error($model,'lossfactor'); ?>
        </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'usage'); ?>
		<?php echo $form->textField($model,'usage',array('size'=>16,'maxlength'=>16,'class'=>'textInput','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'usage'); ?>
	</div>


	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->