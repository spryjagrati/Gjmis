<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idmetal'); ?>
		<?php echo $form->textField($model,'idmetal'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'namevar'); ?>
		<?php echo $form->textField($model,'namevar',array('size'=>64,'maxlength'=>64)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idmetalm'); ?>
		<?php echo $form->dropDownList($model,'idmetalm',ComSpry::getMasterMetals(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idmetalstamp'); ?>
		<?php echo $form->dropDownList($model,'idmetalstamp',ComSpry::getMetalStamps(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'currentcost'); ?>
		<?php echo $form->textField($model,'currentcost',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'prevcost'); ?>
		<?php echo $form->textField($model,'prevcost',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Metal_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                    /*'ifFormat'=>'%Y-%m-%d %H:%M:%S',
                    'showsTime'=>true,*/
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Metal_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby', ComSpry::getAllUserDropDownList(),array('empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'lossfactor'); ?>
		<?php echo $form->textField($model,'lossfactor',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'chemcost'); ?>
		<?php echo $form->textField($model,'chemcost',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->