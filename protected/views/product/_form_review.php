<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skureviews-form','action'=>$this->createUrl('product/createReview/'.$model->idsku),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
    	<span class="required"><?php echo Yii::app()->user->getFlash('skureview',''); ?></span>
		<?php echo $form->errorSummary($model); ?>
	        <?php echo $form->hiddenField($model,'idsku'); ?>
		
		<div class="ctrlHolder">
			<?php echo $form->labelEx($model, 'reviews', array('style' => 'width:10%')); ?>
			<?php echo $form->textArea($model, 'reviews', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>
		</div>  

		<div class="buttonHolder">
		<?php
		echo CHtml::ajaxSubmitButton('Save',array('product/createReview', 'id'=>$model->idsku),array('update'=>'#yw0_tab_8','complete' => 'function(){$.fn.yiiGridView.update("skureviews-grid");}',),array('id'=>'review-create','class'=>'primaryAction', 'style'=>'width:20%'));
            ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->