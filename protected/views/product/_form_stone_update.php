<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skustones-form',
	'enableAjaxValidation'=>false,//'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('updateStone',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstone'); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(), array('class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
		<?php //echo $form->error($model,'idstone'); ?>
		<?php echo $form->labelEx($model,'idsetting',array('style'=>'width:20%')); ?>
		<?php echo $form->dropDownList($model,'idsetting', ComSpry::getSettings(), array('class'=>'selectInput', 'style'=>'width:12%','empty'=>'')); ?>
		<?php //echo $form->error($model,'idsetting'); ?>

	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'pieces'); ?>
		<?php echo $form->textField($model,'pieces',array('size'=>3,'maxlength'=>3, 'class'=>'textInput', 'style'=>'width:4%')); ?>
		<?php //echo $form->error($model,'pieces'); ?>
		<?php echo $form->labelEx($model,'type',array('style'=>'width:20%')); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:15%','empty'=>'')); ?>
		<?php //echo $form->error($model,'type'); ?>
	</div>
        
         <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reviews',array('style'=>'width:10%')); ?>
		<?php echo $form->textArea($model,'reviews',array('rows'=>4,'cols'=>40,'maxlength'=>255, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		
	</div>

	<div class="buttonHolder">
            <?php
		echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateStoneDialog'),array('id'=>'stone-update-'.$model->idskustones,'class'=>'primaryAction', 'style'=>'width:20%'));
            ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
<?php

Yii::app()->clientScript->scriptMap=array(
         //scripts that you don't need inside this view
        'jquery.js'=>false,
    'jquery-ui.min.js'=>false,
);

?>
</div><!-- form -->