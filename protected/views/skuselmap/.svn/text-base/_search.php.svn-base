<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
<!--	<div class="row">
		<?php echo $form->label($model,'idskuselmap'); ?>
		<?php echo $form->textField($model,'idskuselmap'); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idclient',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idclient',ComSpry::getClients(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idclient'); ?>
		<?php echo $form->labelEx($model,'clientcode',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'clientcode',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:12%')); ?>
		<?php echo $form->error($model,'clientcode'); ?>
        </div>

<!--	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'csname',array('style'=>'width:8%')); ?>
		<?php echo $form->textField($model,'csname',array('size'=>45,'maxlength'=>45, 'class'=>'textInput', 'style'=>'width:25%')); ?>
		<?php echo $form->error($model,'csname'); ?>
	</div> -->

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->