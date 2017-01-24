<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'bead-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
    	<p class="note">Fields with <span class="required">*</span> are required.</p>
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->hiddenField($model,'idbeadsku'); ?>
        	<div class="ctrlHolder">
        		<?php echo $form->labelEx($model,'beadskucode'); ?>
        		<?php if($model->isNewRecord)
                        echo $form->textField($model,'beadskucode',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:13%'));
                    else
                        echo $form->textField($model,'beadskucode',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled'));
           		?>
           		<?php echo $form->error($model,'beadskucode'); ?>

           		<?php echo $form->labelEx($model,'type'); ?>
				<?php echo $form->dropDownList($model,'type', $model->getTypes(),array('class'=>'selectInput', 'empty' => '', 'style'=>'width:15%')); ?>
				<?php echo $form->error($model,'type'); ?>

				<?php echo $form->labelEx($model,'sub_category'); ?>
				<?php echo $form->dropDownList($model,'sub_category', $model->getsubtypes(),array('class'=>'selectInput', 'empty' => '', 'style'=>'width:15%')); ?>
				<?php echo $form->error($model,'sub_category'); ?>
        	</div>
        	<div class="ctrlHolder">
        		<?php echo $form->labelEx($model,'grosswt'); ?>
				<?php echo $form->textField($model,'grosswt',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?>

				<?php echo $form->labelEx($model,'magnetwt'); ?>
				<?php echo $form->textField($model,'magnetwt',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?>
        	</div>

        	<div class="ctrlHolder">
        		<?php echo $form->labelEx($model,'totmetalwei'); ?>
				<?php echo $form->textField($model,'totmetalwei',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?>
                <?php echo $form->error($model,'totmetalwei'); ?>

				<?php echo $form->labelEx($model,'size'); ?>
				<?php echo $form->textField($model,'size',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?>
        	</div>
        	<div class="buttonHolder">
        		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save' , array('id'=>'bead-create','class'=>'primaryAction', 'style'=>'width:20%') ); ?>
			</div> 
    </fieldset>
<?php $this->endWidget(); ?>

</div>


















