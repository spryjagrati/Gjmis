<div class="uniForm">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'beadmetal-form','action'=>$this->createUrl('bead/createMetal/'.$model->idbeadsku),
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
			<div class="buttonHolder">
		        <?php
				echo CHtml::ajaxSubmitButton('Save',array('bead/createMetal', 'id'=>$model->idbeadsku),array('update'=>'#yw0_tab_1','complete' => 'function(){$.fn.yiiGridView.update("beadmetals-grid");}',),array('id'=>'metal-create','class'=>'primaryAction', 'style'=>'width:20%'));
		        ?> 
			</div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>