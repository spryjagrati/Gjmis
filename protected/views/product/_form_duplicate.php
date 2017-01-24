<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'sku-form-duplicate','action'=>$this->createUrl('product/duplicate/'.$model->idsku),
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($modelnew); ?>
	<?php if(Yii::app()->user->hasFlash('Error')):?>
            <div class="info">
                <?php echo Yii::app()->user->getFlash('Error'); ?>
            </div>
        <?php endif; ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($modelnew,'skucode'); ?>
            <?php if($modelnew->isNewRecord)
                        echo $form->textField($modelnew,'skucode',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%'));
                    else
                        echo $form->textField($modelnew,'skucode',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled'));
            ?>
		<?php echo $form->error($modelnew,'skucode'); ?>

            	<?php echo $form->labelEx($modelnew,'refpo'); ?>
		<?php echo $form->textField($modelnew,'refpo',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%', 'value'=>$model->refpo)); ?>
		<?php echo $form->error($modelnew,'refpo'); ?>

            	<?php echo $form->labelEx($modelnew,'tdnum'); ?>
		<?php echo $form->textField($modelnew,'tdnum',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%', 'value'=>$model->tdnum)); ?>
		<?php echo $form->error($modelnew,'tdnum'); ?>

              
	</div>

        
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($modelnew->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->