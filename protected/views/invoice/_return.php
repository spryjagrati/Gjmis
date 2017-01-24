
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'invoice-returnform',
	'enableAjaxValidation'=>false,
)); ?>
  <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php  echo $form->errorSummary(array($model, $locationmodel)); ?>
       
	
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'retrn'); ?>
		<?php echo $form->dropdownlist($model,'retrn',array(1=>'Yes',0=>'No')); ?>
            <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">Once returned, then cannot be reverted.</p>
                
		<?php echo $form->error($model,'retrn'); ?>
	</div>
        <?php if($display == 1){ ?>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($locationmodel,'creditnum'); ?>
		<?php echo $form->textField($locationmodel,'creditnum', array("disabled"=>"disabled")); ?>
		<?php echo $form->error($locationmodel,'creditnum'); ?>
	</div>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($locationmodel,'duedate'); ?>
		<?php echo $form->textField($locationmodel,'duedate', array("disabled"=>"disabled")); ?>
		<?php echo $form->error($locationmodel,'duedate'); ?>
	</div>
       
        <div class="ctrlHolder">
		<?php echo $form->labelEx($locationmodel,'dcountry'); ?>
		<?php echo $form->textField($locationmodel,'dcountry', array("disabled"=>"disabled")); ?>
		<?php echo $form->error($locationmodel,'dcountry'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($locationmodel,'dstreet'); ?>
		<?php echo $form->textField($locationmodel,'dstreet', array("disabled"=>"disabled")); ?>
		<?php echo $form->error($locationmodel,'dstreet'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($locationmodel,'dpincode'); ?>
		<?php echo $form->textField($locationmodel,'dpincode', array("disabled"=>"disabled")); ?>
		<?php echo $form->error($locationmodel,'dpincode'); ?>
	</div>
         <div class="ctrlHolder">
		<label for="generate">Generate Credit Note</label>
		<?php echo CHtml::link('Generate',array('invoice/genCreditnote','id'=>$model->idinvoice)); ?>
	</div>
        <?php } ?>
    

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

