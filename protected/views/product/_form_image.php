<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skuimages-form','htmlOptions'=>array('enctype'=>'multipart/form-data'),'action'=>$this->createUrl('product/createImage/'.$model->idsku),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>
	
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
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
        
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord?'Create':'Save',array('id'=>'image-create','class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->