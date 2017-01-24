<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'sku-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skucode'); ?>
            <?php if($model->isNewRecord)
                        echo $form->textField($model,'skucode',array('size'=>128,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:13%'));
                    else
                        echo $form->textField($model,'skucode',array('size'=>128,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled'));
            ?>
		<?php echo $form->error($model,'skucode'); ?>

		<?php echo $form->labelEx($model,'refpo',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'refpo',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'refpo'); ?>
	</div>
        
	<!-- <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'leadtime'); ?>
		<?php echo $form->textField($model,'leadtime',array('size'=>2,'maxlength'=>2,'class'=>'textInput', 'style'=>'width:3%')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">days</p>
                <?php echo $form->error($model,'leadtime'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'parentsku'); ?>
		<?php echo $form->textField($model,'parentsku',array('class'=>'textInput', 'style'=>'width:33%')); ?>
		<?php echo $form->error($model,'parentsku'); ?>

		<?php echo $form->labelEx($model,'parentrel',array('style'=>'width:10%')); ?>
		<?php echo $form->dropdownList($model,'parentrel',$model->getRelTypes(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->error($model,'parentrel'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'taxcode'); ?>
		<?php echo $form->textField($model,'taxcode',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'taxcode'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dimdia'); ?>
		<?php echo $form->textField($model,'dimdia',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'dimdia'); ?>
		<?php echo $form->labelEx($model,'dimhei',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimhei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'dimhei'); ?>
		<?php echo $form->labelEx($model,'dimwid',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimwid',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'dimwid'); ?>
		<?php echo $form->labelEx($model,'dimlen',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimlen',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'dimlen'); ?>
                <?php echo $form->labelEx($model,'dimunit',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'dimunit'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'totmetalwei'); ?>
		<?php echo $form->textField($model,'totmetalwei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'totmetalwei'); ?>
		<?php //echo $form->labelEx($model,'metweiunit',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'metweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'metweiunit'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'totstowei'); ?>
		<?php echo $form->textField($model,'totstowei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'totstowei'); ?>
		<?php //echo $form->labelEx($model,'stoweiunit',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'stoweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'stoweiunit'); ?>
		<?php echo $form->labelEx($model,'numstones',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'numstones',array('size'=>2,'maxlength'=>2, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'numstones'); ?>
	</div> -->

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->