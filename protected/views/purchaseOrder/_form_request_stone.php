<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stonereq-form','action'=>$this->createUrl('purchaseOrder/createRequest/'.$model->idpo),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('matreq',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idpo'); ?>
        <?php echo $form->hiddenField($model,'type'); ?>
        <?php echo $form->hiddenField($model,'qunit'); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstone'); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->labelEx($model,'rqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'rqty',array('class'=>'textInput','size'=>8,'maxlength'=>8,'style'=>'width:5%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reqby'); ?>
		<?php echo $form->dropDownList($model,'reqby',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->labelEx($model,'reqto',array('style'=>'width:10%')); ?>
		<?php echo $form->dropDownList($model,'reqto',ComSpry::getTypeLocDepts('p'),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::ajaxSubmitButton($model->isNewRecord?'Create':'Save',array('purchaseOrder/createRequest/'.$model->idpo),array('update'=>'#yw0_tab_1','complete' => 'function(){$.fn.yiiGridView.update("matreq-grid");}',),array('id'=>'matreqstone-create','class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->