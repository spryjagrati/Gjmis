<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idfinding'); ?>
		<?php echo $form->textField($model,'idfinding'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('empty' => '')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>9,'maxlength'=>9)); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Finding_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>
-->
	<div class="row">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Finding_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby', ComSpry::getAllUserDropDownList()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descri'); ?>
		<?php echo $form->textField($model,'descri',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>8,'maxlength'=>8)); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier'); ?>
		<?php echo $form->textField($model,'supplier',array('size'=>45,'maxlength'=>45)); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'miracle'); ?>
		<?php echo $form->textField($model,'miracle',array('size'=>7,'maxlength'=>7)); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->