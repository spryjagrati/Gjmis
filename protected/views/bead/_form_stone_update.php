
<div class="uniForm">
    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'beadstones-form',
	'enableAjaxValidation'=>false,
	)); ?>
    	<fieldset class="inlineLabels">
	        <p class="note">Fields with <span class="required">*</span> are required.</p>
	        <span class="required"><?php echo Yii::app()->user->getFlash('beadstone', ''); ?></span>
	            <?php echo $form->errorSummary($model); ?>
	            <?php echo $form->hiddenField($model, 'idbeadsku'); ?>
	        <div class="ctrlHolder">
	            <?php echo $form->labelEx($model, 'idstone', array('style' => 'width:10%')); ?>
	            <?php echo $form->dropDownList($model,'idstone',ComSpry::getBeadStones(), array ( 'class'=>'selectInput', 'style'=>'width:25%','empty'=>'')); ?>
          
	            <?php echo $form->labelEx($model, 'idsetting', array('style' => 'width:12%')); ?>
	            <?php echo $form->dropDownList($model, 'idsetting', ComSpry::getSettings(), array('class' => 'drop', 'empty' => '')); ?>
	        </div>
	       
			<div class="ctrlHolder">
	            <?php echo $form->labelEx($model, 'lgsize', array('style' => 'width:10%')); ?>
	            <?php echo $form->textField($model, 'lgsize', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:14%')); ?>
	            <?php echo $form->labelEx($model, 'smsize', array('style' => 'width:13%')); ?>
	            <?php echo $form->textField($model, 'smsize', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:14%')); ?>
	            <?php echo $form->labelEx($model, 'pieces', array('style' => 'width:10%')); ?>
				<?php echo $form->textField($model, 'pieces', array('size' => 3, 'maxlength' => 3, 'class' => 'textInput', 'style' => 'width:5%')); ?>
            </div>

            <div class="ctrlHolder">
				<?php echo $form->labelEx($model, 'remark', array('style' => 'width:10%')); ?>
				<?php echo $form->textArea($model, 'remark', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>
        	</div>

	        <div class="buttonHolder">
				<?php
				 echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateStoneDialog',),array('id'=>'stone-update-'.$model->idbeadstones,'class'=>'primaryAction', 'style'=>'width:20%'));
		        ?>  
			</div>
	    </fieldset>
    <?php $this->endWidget(); ?>
</div>
