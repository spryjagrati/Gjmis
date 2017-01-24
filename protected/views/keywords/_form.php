<?php
/* @var $this KeywordsController */
/* @var $model Keywords */
/* @var $form CActiveForm */
?>
<div class="uniForm">
    <?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
            'id'=>'keywords-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
    )); ?>
    <fieldset class="inlineLabels">

    

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>
            <?php if(Yii::app()->user->hasFlash('message')){?>
                <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('message');?></div>
            <?php } ?>
            <div class="ctrlHolder">
                    <?php echo $form->labelEx($model,'keyword'); ?>
                    <?php echo $form->textField($model,'keyword',array('size'=>30,'maxlength'=>64)); ?>
                    <?php echo $form->error($model,'keyword'); ?>
            </div>

            <div class="buttonHolder">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
            </div>

    
    </fieldset>
    <?php $this->endWidget(); ?>

</div>