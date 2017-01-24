<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stonevoucher-form',
	'enableAjaxValidation'=>false,
)); ?>
 <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <?php if($model->isNewRecord){ ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'issuedto'); ?>
		<?php echo $form->dropDownList($model,'issuedto',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'issuedto'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'issuedfrom'); ?>
		<?php echo $form->dropDownList($model,'issuedfrom',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'issuedfrom'); ?>
	</div>
        <?php }else{ ?>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'issuedto'); ?>
		<?php echo $form->dropDownList($model,'issuedto',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'issuedto'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'issuedfrom'); ?>
		<?php echo $form->dropDownList($model,'issuedfrom',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:20%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'issuedfrom'); ?>
	</div>
       
        
        
        <?php } ?>
        
<!--	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
		<?php echo $form->error($model,'cdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'acknow'); ?>
		<?php echo $form->textField($model,'acknow'); ?>
		<?php echo $form->error($model,'acknow'); ?>
	</div>-->

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->