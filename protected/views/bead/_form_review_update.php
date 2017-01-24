<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'beadreviews-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	
    	<span class="required"><?php echo Yii::app()->user->getFlash('updateReview',''); ?></span>
		<?php echo $form->errorSummary($model); ?>
	        <?php echo $form->hiddenField($model,'idbeadsku'); ?>
		<div class="ctrlHolder">
			<?php echo $form->labelEx($model, 'reviews', array('style' => 'width:10%')); ?>
			<?php echo $form->textArea($model, 'reviews', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>
		</div>  
		<div class="buttonHolder">
            <?php
			echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateReviewDialog',),array('id'=>'review-update-'.$model->idbeadreview,'class'=>'primaryAction', 'style'=>'width:20%'));
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