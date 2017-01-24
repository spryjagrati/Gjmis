<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'beadimages-form','htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
    	<p class="note">Fields with <span class="required">*</span> are required.</p>
		<?php echo $form->errorSummary($model); ?>
	        <?php echo $form->hiddenField($model,'idbeadsku'); ?>

	    <div class="ctrlHolder">
			<?php echo $form->labelEx($model,'image'); ?>
			<?php echo $form->fileField($model,'image',array('size'=>60)); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
		<div class="ctrlHolder">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:13%')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
        
		<div class="buttonHolder">
			<?php echo CHtml::submitButton('Save','',array('id'=>'image-update-'.$model->idbeadimages,'class'=>'primaryAction', 'style'=>'width:20%')); ?>
		</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->