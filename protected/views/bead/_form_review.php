<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'beadreviews-form','action'=>$this->createUrl('bead/createReview/'.$model->idbeadsku),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
    	<span class="required"><?php echo Yii::app()->user->getFlash('beadreview',''); ?></span>
		<?php echo $form->errorSummary($model); ?>
	        <?php echo $form->hiddenField($model,'idbeadsku'); ?>
		
		<div class="ctrlHolder">
			<?php echo $form->labelEx($model, 'reviews', array('style' => 'width:10%')); ?>
			<?php echo $form->textArea($model, 'reviews', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>
		</div>  

		<div class="buttonHolder">
		<?php
		echo CHtml::ajaxSubmitButton('Save',array('bead/createReview', 'id'=>$model->idbeadsku),array('update'=>'#yw0_tab_5','complete' => 'function(){$.fn.yiiGridView.update("beadreviews-grid");}',),array('id'=>'review-create','class'=>'primaryAction', 'style'=>'width:20%'));
            ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->