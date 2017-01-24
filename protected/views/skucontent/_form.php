<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'skucontent-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
                <?php echo $form->textField($model,'idsku',array('class'=>'textInput','style'=>'width:8%;')); ?>
		<?php //echo $form->textField($model,'idsku',array('class'=>'textInput','style'=>'width:8%','disabled'=>'disabled')); ?>
                <?php echo $form->error($model,'idsku'); ?>

		<?php echo $form->labelEx($model,'brand',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'brand',array('size'=>8,'maxlength'=>8, 'class'=>'textInput','style'=>'width:13%')); ?>
		<?php echo $form->error($model,'brand'); ?>
                <?php echo $form->labelEx($model,'type',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'type',array('size'=>16,'maxlength'=>16, 'class'=>'textInput','style'=>'width:13%')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45, 'class'=>'textInput')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'descr'); ?>
		<?php echo $form->textField($model,'descr',array('size'=>60,'maxlength'=>256, 'class'=>'textInput')); ?>
		<?php echo $form->error($model,'descr'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'usedfor'); ?>
		<?php echo $form->textArea($model,'usedfor',array('rows'=>4,'cols'=>40,'maxlength'=>256, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                <?php echo $form->error($model,'usedfor'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'attributedata'); ?>
		<?php echo $form->textArea($model,'attributedata',array('rows'=>4,'cols'=>40,'maxlength'=>256, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                <?php echo $form->error($model,'attributedata'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'targetusers'); ?>
		<?php echo $form->textArea($model,'targetusers',array('rows'=>4,'cols'=>40,'maxlength'=>256, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                <?php echo $form->error($model,'targetusers'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'searchterms'); ?>
		<?php echo $form->textArea($model,'searchterms',array('rows'=>4,'cols'=>40,'maxlength'=>256, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                <?php echo $form->error($model,'searchterms'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'resizable'); ?>
		<?php echo $form->dropDownList($model,'resizable',$model->getResOpts(),array('size'=>1,'maxlength'=>1, 'class'=>'selectInput', 'style'=>'width:5%','empty'=>'')); ?>
		<?php echo $form->error($model,'resizable'); ?>

		<?php echo $form->labelEx($model,'sizelowrange',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'sizelowrange',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'sizelowrange'); ?>

		<?php echo $form->labelEx($model,'sizeupprange',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'sizeupprange',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'sizeupprange'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'chaintype'); ?>
		<?php echo $form->textField($model,'chaintype',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'chaintype'); ?>

		<?php echo $form->labelEx($model,'clasptype',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'clasptype',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'clasptype'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'backfinding'); ?>
		<?php echo $form->textField($model,'backfinding',array('size'=>45,'maxlength'=>45, 'class'=>'textInput')); ?>
		<?php echo $form->error($model,'backfinding'); ?>
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