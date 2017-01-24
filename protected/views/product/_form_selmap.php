<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'skuselmap-form','action'=>$this->createUrl('product/createAddon/'.$model->idsku),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('skuselmap',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idsku'); ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idclient'); ?>
		<?php echo $form->dropDownList($model,'idclient',ComSpry::getClients(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idclient'); ?>
        </div>

	<div class="ctrlHolder">

		<?php echo $form->labelEx($model,'clientcode'); ?>
		<?php echo $form->textField($model,'clientcode',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:12%')); ?>
		<?php echo $form->error($model,'clientcode'); ?>

		<?php echo $form->labelEx($model,'csname',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'csname',array('size'=>45,'maxlength'=>45, 'class'=>'textInput', 'style'=>'width:25%')); ?>
		<?php echo $form->error($model,'csname'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::ajaxSubmitButton($model->isNewRecord?'Create':'Save',array('product/createSelmap/'.$model->idsku),array('update'=>'#yw0_tab_6','complete' => 'function(){$.fn.yiiGridView.update("skuselmap-grid");}',),array('id'=>'selmap-create','class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->