
<div class="uniForm">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bead-form',
		'enableAjaxValidation'=>false,
	)); ?>
		<fieldset class="inlineLabels">
			<p class="note">Fields with <span class="required">*</span> are required.</p>
			<span class="required"><?php echo Yii::app()->user->getFlash('bead',''); ?></span>
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
        		<?php echo $form->labelEx($model,'size'); ?>
				<?php echo $form->textField($model,'size',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?> 

        		<?php echo $form->labelEx($model,'totmetalwei'); ?>
				<?php echo $form->textField($model,'totmetalwei',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%')); ?>
				<p class="formHint" style="width:3%; display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">gms</p>
				
        	</div>
        	<div class="ctrlHolder">
        		<?php echo $form->labelEx($model,'totstowei'); ?>
				<?php echo $form->textField($model,'totstowei',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled')); ?>
				<p class="formHint" style="width:3%; display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">ct</p>
        	</div>
        	<div class="buttonHolder">
		        <?php echo CHtml::ajaxSubmitButton('Save',array('bead/updateBead', 'id'=>$model->idbeadsku),array('update'=>'#yw0_tab_0','complete' => 'function(){$.fn.yiiGridView.update("skumetals-grid");}',),array('id'=>'bead-update','class'=>'primaryAction', 'style'=>'width:20%'));?>
			</div> 
			
		</fieldset>
	<?php $this->endWidget(); ?>
</div>