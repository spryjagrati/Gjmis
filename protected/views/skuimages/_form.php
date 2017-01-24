<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skuimages-form','htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idclient',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idclient',ComSpry::getClients(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idclient'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image',array('size'=>60)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'imgalt'); ?>
		<?php echo $form->textField($model,'imgalt',array('size'=>60,'maxlength'=>60, 'class'=>'textInput', 'style'=>'width:30%')); ?>
		<?php echo $form->error($model,'imgalt'); ?>
                <?php echo $form->labelEx($model,'type',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%','empty'=>'')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
        
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->