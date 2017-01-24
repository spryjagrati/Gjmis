<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'sku-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($modelmetal); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skucode'); ?>
            <?php if($model->isNewRecord)
                        echo $form->textField($model,'skucode',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%'));
                    else
                        echo $form->textField($model,'skucode',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled'));
            ?>
		<?php echo $form->error($model,'skucode'); ?>

            	<?php echo $form->labelEx($model,'refpo'); ?>
		<?php echo $form->textField($model,'refpo',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'refpo'); ?>

            	<?php echo $form->labelEx($model,'tdnum'); ?>
		<?php echo $form->textField($model,'tdnum',array('size'=>120,'maxlength'=>120,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'tdnum'); ?>
           

              
	</div>

        <div class="ctrlHolder">

              <?php echo $form->labelEx($modelcontent,'type'); ?>
		<?php echo $form->dropDownList($modelcontent,'type', $modelcontent->getTypes(),array('class'=>'selectInput', 'empty' => '', 'style'=>'width:20%')); ?>
		<?php echo $form->error($modelcontent,'type'); ?>

          
                 <?php echo $form->labelEx($model,'sub_category',array('style'=>'width:20%')); ?>
		<?php echo $form->dropDownList($model,'sub_category', $model->getTypes(), array('class'=>'selectInput', 'empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'sub_category'); ?>           
           </div>
               <div class="ctrlHolder">


      
		<?php echo $form->labelEx($modelmetal,'idmetal'); ?>
		<?php echo $form->dropDownList($modelmetal,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput', 'style'=>'width:20%')); ?>
		<?php echo $form->error($modelmetal,'idmetal'); ?>
       </div>
           

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
