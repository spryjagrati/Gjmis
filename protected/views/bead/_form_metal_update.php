<div class="uniForm">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'beadmetal-form',
	'enableAjaxValidation'=>false,
	)); ?>
		<fieldset class="inlineLabels">
			<p class="note">Fields with <span class="required">*</span> are required.</p>
			 <span class="required"><?php echo Yii::app()->user->getFlash('beadmetal',''); ?></span>
			<?php echo $form->hiddenField($model,'idbeadsku'); ?>
			<div class="ctrlHolder">
				<?php echo $form->labelEx($model,'idmetal'); ?>
				<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput', 'style'=>'width:15%','empty'=>'')); ?>
			</div>
			<div class="ctrlHolder">
				<?php echo $form->labelEx($model,'weight',array('style'=>'width:10%')); ?>
				<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9,'class'=>'textInput','style'=>'width:10%')); ?>
			</div>
			<div class="buttonHolder">
				<?php
				 echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateMetalDialog',),array('id'=>'metal-update-'.$model->idbeadmetals,'class'=>'primaryAction', 'style'=>'width:20%'));
		        ?>  
			</div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>