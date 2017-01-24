<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'deptstonelog-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>
        
        <?php if(Yii::app()->user->hasFlash('error')):?>
            <div class="info" style="color:red" >
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php endif; ?>
        
        <?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'iddept'); ?>
		<?php echo $form->dropDownList($model,'iddept',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'iddept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstone'); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idstone'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'Total Stone Wt'); ?>
		<?php echo $form->textField($model,'stonewt', array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'stonewt'); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo'); ?>
		<?php echo $form->error($model,'idpo'); ?>
	</div>-->

<!--	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>-->

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refrcvd'); ?>
		<?php echo $form->dropDownList($model,'refrcvd',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'refrcvd'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refsent'); ?>
		<?php echo $form->dropDownList($model,'refsent',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'refsent'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textField($model,'remark', array('style'=>'width:20%')); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	
		</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->