<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'costadd-form','layoutName'=>'qtip',
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',$model->getCaddTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'textInput','size'=>128,'maxlength'=>128,'style'=>'width:20%')); ?>
		<?php echo $form->error($model,'name'); ?>
		<?php echo $form->labelEx($model,'fixcost',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'fixcost',array('class'=>'textInput','size'=>6,'maxlength'=>6,'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'fixcost'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idmetal'); ?>
		<?php echo $form->labelEx($model,'factormetal',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'factormetal',array('class'=>'textInput','size'=>4,'maxlength'=>4,'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'factormetal'); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstone'); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array('empty' => '')); ?>
		<?php echo $form->error($model,'idstone'); ?>
	</div>

		<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'factorstone'); ?>
		<?php echo $form->textField($model,'factorstone',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'factorstone'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idchemical'); ?>
		<?php echo $form->dropDownList($model,'idchemical',ComSpry::getChemicals(),array('empty' => '')); ?>
		<?php echo $form->error($model,'idchemical'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'factorchem'); ?>
		<?php echo $form->textField($model,'factorchem',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'factorchem'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsetting'); ?>
		<?php echo $form->dropDownList($model,'idsetting',ComSpry::getSettings(),array('empty' => '')); ?>
		<?php echo $form->error($model,'idsetting'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'factorsetting'); ?>
		<?php echo $form->textField($model,'factorsetting',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'factorsetting'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'factornumsto'); ?>
		<?php echo $form->textField($model,'factornumsto',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'factornumsto'); ?>
	</div>
-->

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'costformula'); ?>
		<?php echo $form->textField($model,'costformula',array('class'=>'textInput','size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'costformula'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'threscostformula'); ?>
		<?php echo $form->textField($model,'threscostformula',array('class'=>'textInput','size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'threscostformula'); ?>
	</div>
<!--
	<div class="ctrlHolder">
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
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>
-->
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
   
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->