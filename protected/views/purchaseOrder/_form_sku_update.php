<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posku-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idpo'); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'qty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'qty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'qty'); ?>
		<?php echo $form->labelEx($model,'totamt',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'totamt',array('size'=>9,'maxlength'=>9, 'class'=>'textInput', 'style'=>'width:10%')); ?>
            <p style="display:inline-block"><?php echo $suggprice; ?></p>
		<?php echo $form->error($model,'totamt'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reforder'); ?>
		<?php echo $form->textField($model,'reforder',array('size'=>10,'maxlength'=>10, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->error($model,'reforder'); ?>
		<?php echo $form->labelEx($model,'usnum',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'usnum',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'usnum'); ?>
		<?php echo $form->labelEx($model,'ext',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'ext',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'ext'); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refno'); ?>
                <?php echo $form->textField($model,'refno',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'refno'); ?>
		<?php echo $form->labelEx($model,'custsku',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'custsku',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'custsku'); ?>
		<?php echo $form->labelEx($model,'appmetwt',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'appmetwt',array('size'=>9,'maxlength'=>9, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'appmetwt'); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'itemtype'); ?>
		<?php echo $form->textField($model,'itemtype',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'itemtype'); ?>
		<?php echo $form->labelEx($model,'itemmetal',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'itemmetal',array('size'=>32,'maxlength'=>32, 'class'=>'textInput', 'style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'itemmetal'); ?>
		<?php echo $form->labelEx($model,'metalstamp',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'metalstamp',array('size'=>32,'maxlength'=>32, 'class'=>'textInput', 'style'=>'width:15%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'metalstamp'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'descrip'); ?>
		<?php echo $form->textArea($model,'descrip',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'descrip'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textArea($model,'remark',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::ajaxSubmitButton('Save','',array('update'=>'#updateItemDialog'),array('id'=>'item-update-'.$model->idposkus,'class'=>'primaryAction', 'style'=>'width:20%')); ?>
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