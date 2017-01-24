<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skumetals-form','action'=>$this->createUrl('product/createMetal/'.$model->idsku),
	'enableAjaxValidation'=>false,//'layoutName'=>'qtip'
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('skumetal',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php //echo $form->error($model,'idmetal'); ?>
<!--
		<?php echo $form->labelEx($model,'weight',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9,'class'=>'textInput','style'=>'width:5%')); ?>
            <p class="formHint" style="display:inline-block; position:relative; padding-left:0%; margin-left:1%; margin-right:2%">gms</p>
		<?php //echo $form->error($model,'weight'); ?>
-->
        </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'usage'); ?>
		<?php echo $form->textField($model,'usage',array('size'=>16,'maxlength'=>16,'class'=>'textInput','style'=>'width:20%')); ?>
		<?php //echo $form->error($model,'usage'); ?>
            	<?php echo $form->labelEx($model,'lossfactor',array('style'=>'width:12%')); ?>
		<?php echo $form->textField($model,'lossfactor',array('size'=>4,'maxlength'=>4,'value'=>'0.00')); ?>
		<p class="formHint" style="width:3%; display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">%</p>
                <?php //echo $form->error($model,'lossfactor'); ?>
	</div>


	<div class="buttonHolder">
            <?php
		echo CHtml::ajaxSubmitButton($model->isNewRecord?'Create':'Save',array('product/createMetal', 'id'=>$model->idsku),array('update'=>'#yw0_tab_0','complete' => 'function(){$.fn.yiiGridView.update("skumetals-grid");}',),array('id'=>'metal-create','class'=>'primaryAction', 'style'=>'width:20%'));
            ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
