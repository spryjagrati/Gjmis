<h3>TH export with SKU IDs</h3>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'codemei-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

        <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skuid'); ?>
		<?php echo $form->textField($model,'skuid'); ?> Comma Separated
		<?php echo $form->error($model,'skuid'); ?>
                <?php echo Chtml::hiddenField('type',1,array('id' => 'download_type')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Submit',array('class'=>'primaryAction', 'style'=>'width:20%', 'onclick' => '$("#download_type").val(1);')); ?><?php echo CHtml::submitButton('Download Images',array('class'=>'primaryAction', 'style'=>'margin-left:10px;', 'onclick' => '$("#download_type").val(2);')); ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
