<div class="uniForm">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'beadfindings-form','action'=>$this->createUrl('product/createFinding/'.$model->idbeadsku),
		'enableAjaxValidation'=>false,
	)); ?>
		<fieldset class="inlineLabels">
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		        <span class="required"><?php echo Yii::app()->user->getFlash('beadfinding',''); ?></span>
			<?php echo $form->errorSummary($model); ?>
		        <?php echo $form->hiddenField($model,'idbeadsku'); ?>
			<div class="ctrlHolder">
				<?php echo $form->labelEx($model,'idfinding'); ?>
				<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindings(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
			</div>
			<div class="ctrlHolder">
				<?php echo $form->labelEx($model,'qty'); ?>
				<?php echo $form->textField($model,'qty',array('size'=>3,'maxlength'=>3, 'class'=>'textInput', 'style'=>'width:5%')); ?>
			</div>
			<div class="buttonHolder">
				<?php
				echo CHtml::ajaxSubmitButton('Save',array('bead/createFinding', 'id'=>$model->idbeadsku),array('update'=>'#yw0_tab_3','complete' => 'function(){$.fn.yiiGridView.update("beadfindings-grid");}',),array('id'=>'finding-create','class'=>'primaryAction', 'style'=>'width:20%'));
		        ?>
	        </div>
		</fieldset>
	<?php $this->endWidget(); ?>
</div>