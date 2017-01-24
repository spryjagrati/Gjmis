<h3>ZY export with SKU Names</h3>
<div class="uniForm">


<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'codeme-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
 <?php echo $form->errorSummary($model); ?>
	 <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>



	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skucode'); ?>
                <?php
                    $this->widget('ext.multicomplete.MultiComplete', array(
                    'model'=>$model,
                    'attribute'=>'skucode',
                    'name'=>'codeme',
                    'source'=>$query,
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                    'delay'=>300,
                    'minLength'=>2,
                    ),

                    'htmlOptions'=>array(
                    'style'=>'height:20px;'
                    ),
                ));?>

                <?php echo "Comma Separated"; ?>
		<?php echo $form->error($model,'skucode'); ?>
	</div>
	
<div class="buttonHolder">
		<?php echo CHtml::submitButton('Submit',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->