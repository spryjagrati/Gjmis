
<h3> SKU export with SKU IDs</h3>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skuexport-form-export-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

        <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skuid'); ?>
		<?php echo $form->textField($model,'skuid'); ?> Comma Separated
		<?php echo $form->error($model,'skuid'); ?>
	</div>



	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idclient'); ?>
		<?php echo $form->dropDownList($model,'idclient',(ComSpry::getClients())+array('0'=>'SelectAll'), array('class'=>'selectInput', 'style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idclient'); ?>
	</div>


	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Submit',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>

	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->

