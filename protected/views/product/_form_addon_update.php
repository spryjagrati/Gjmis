<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skuaddon-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('updateAddon',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idcostaddon'); ?>
		<?php echo $form->dropDownList($model,'idcostaddon',ComSpry::getCostadds(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php //echo $form->error($model,'idcostaddon'); ?>
		<?php //echo $form->labelEx($model,'qty',array('style'=>'width:8%')); ?>
		<?php //echo $form->textField($model,'qty',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php //echo $form->error($model,'qty'); ?>
	</div>

	<div class="buttonHolder">
            <?php
		echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateAddonDialog'),array('id'=>'addon-update-'.$model->idskuaddon,'class'=>'primaryAction', 'style'=>'width:20%'));
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