<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poskustatus-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo',array('size'=>6,'maxlength'=>6, 'class'=>'textInput', 'style'=>'width:15%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'idpo'); ?>
		<?php echo $form->labelEx($model,'idsku',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'qty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'qty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($modelstatus,'reqdqty'); ?>
		<?php echo $form->textField($modelstatus,'reqdqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:5%','disabled'=>'disabled')); ?>
		<?php echo $form->error($modelstatus,'reqdqty'); ?>
		<?php echo $form->labelEx($modelstatus,'processqty',array('style'=>'width:20%')); ?>
		<?php echo $form->textField($modelstatus,'processqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:5%')); ?>
		<?php echo $form->error($modelstatus,'processqty'); ?>
		<?php echo $form->labelEx($modelstatus,'delqty',array('style'=>'width:20%')); ?>
		<?php echo $form->textField($modelstatus,'delqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:5%')); ?>
		<?php echo $form->error($modelstatus,'delqty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($modelstatus,'idstatusm'); ?>
		<?php echo $form->dropdownList($modelstatus,'idstatusm',ComSpry::getTransStatuses($model->poskustatus->idstatusm),array('class'=>'selectInput', 'style'=>'width:20%')); ?>
		<?php echo $form->error($modelstatus,'idstatusm'); ?>
		<?php echo $form->labelEx($modelstatus,'idprocdept',array('style'=>'width:10%')); ?>
		<?php echo $form->dropdownList($modelstatus,'idprocdept',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput', 'style'=>'width:25%','disabled'=>'disabled')); ?>
		<?php echo $form->error($modelstatus,'idprocdept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'descrip'); ?>
		<?php echo $form->textArea($model,'descrip',array('rows'=>2,'cols'=>60,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'descrip'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textArea($model,'remark',array('rows'=>2,'cols'=>60,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateItemStatusDialog'),array('id'=>'itemstatus-update-'.$model->idposkus,'class'=>'primaryAction', 'style'=>'width:20%')); ?>
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