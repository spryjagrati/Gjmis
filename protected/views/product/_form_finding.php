<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skufindings-form','action'=>$this->createUrl('product/createFinding/'.$model->idsku),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('skufinding',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idfinding'); ?>
		<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindings(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php //echo $form->error($model,'idfinding'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>3,'maxlength'=>3, 'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php //echo $form->error($model,'qty'); ?>
		<?php echo $form->labelEx($model,'name',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:20%')); ?>
		<?php //echo $form->error($model,'name'); ?>
	</div>

	<div class="buttonHolder">
		<?php
		echo CHtml::ajaxSubmitButton('Save',array('product/createFinding', 'id'=>$model->idsku),array('update'=>'#yw0_tab_4','complete' => 'function(){$.fn.yiiGridView.update("skufindings-grid");}',),array('id'=>'finding-create','class'=>'primaryAction', 'style'=>'width:20%'));
            ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
