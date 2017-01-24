<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
<!--
        <div class="ctrlHolder">
		<?php echo $form->label($model,'idstone'); ?>
		<?php echo $form->textField($model,'idstone'); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->label($model,'namevar'); ?>
		<?php echo $form->textField($model,'namevar',array('size'=>60,'maxlength'=>64,'class'=>'textInput')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idstonem'); ?>
		<?php echo $form->dropDownList($model,'idstonem',ComSpry::getStonem(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idstonesize'); ?>
		<?php echo $form->dropDownList($model,'idstonesize',ComSpry::getStonesizes(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idshape'); ?>
		<?php echo $form->dropDownList($model,'idshape',ComSpry::getShapes(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idclarity'); ?>
		<?php echo $form->dropDownList($model,'idclarity',ComSpry::getClarities(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'color'); ?>
		<?php echo $form->textField($model,'color',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'scountry'); ?>
		<?php echo $form->textField($model,'scountry',array('size'=>32,'maxlength'=>64)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cut'); ?>
		<?php echo $form->textField($model,'cut',array('size'=>16,'maxlength'=>16)); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>16,'maxlength'=>16)); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->label($model,'quality'); ?>
		<?php echo $form->textField($model,'quality',array('size'=>16,'maxlength'=>16)); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->label($model,'creatmeth'); ?>
		<?php echo $form->textField($model,'creatmeth',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'treatmeth'); ?>
		<?php echo $form->textField($model,'treatmeth',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Stone_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby', ComSpry::getAllUserDropDownList(),array('empty'=>'')); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->label($model,'curcost'); ?>
		<?php echo $form->textField($model,'curcost',array('size'=>9,'maxlength'=>9)); ?>
	</div>
      
	<div class="ctrlHolder">
		<?php echo $form->label($model,'prevcost'); ?>
		<?php echo $form->textField($model,'prevcost',array('size'=>9,'maxlength'=>9)); ?>
	</div>
-->
	<div class="ctrlHolder buttons">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->
