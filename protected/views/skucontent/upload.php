<div class="uniForm">
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'deptskulog-form',
	'enableAjaxValidation'=>false,
  	'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
  )
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
	<?php if(Yii::app()->user->hasFlash('uploadfile')):?>
        <div class="info">
            <?php echo Yii::app()->user->getFlash('uploadfile'); ?>
        </div>
    <?php endif; ?>
	 <div class="ctrlHolder">
          <?php echo $form->labelEx($model,'inputfile', array('id'=>'inputfile')); ?>
          <?php echo $form->fileField($model,'inputfile'); ?>
          <?php echo $form->error($model,'inputfile'); ?>
        </div>
     

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
</div>