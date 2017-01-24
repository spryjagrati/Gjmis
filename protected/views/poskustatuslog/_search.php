<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idposkustatuslog'); ?>
		<?php echo $form->textField($model,'idposkustatuslog'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idposku'); ?>
		<?php echo $form->textField($model,'idposku'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reqdqty'); ?>
		<?php echo $form->textField($model,'reqdqty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'processqty'); ?>
		<?php echo $form->textField($model,'processqty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delqty'); ?>
		<?php echo $form->textField($model,'delqty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idprocdept'); ?>
		<?php echo $form->textField($model,'idprocdept'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcvddate'); ?>
		<?php echo $form->textField($model,'rcvddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dlvddate'); ?>
		<?php echo $form->textField($model,'dlvddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idstatusm'); ?>
		<?php echo $form->textField($model,'idstatusm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descrip'); ?>
		<?php echo $form->textField($model,'descrip',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remark'); ?>
		<?php echo $form->textField($model,'remark',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->