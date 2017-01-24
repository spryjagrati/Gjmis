<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->dropDownList($model,'idsku',ComSpry::getSku(), array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php //echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'idfinding',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindingslist(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:2%')); ?>
		<?php //echo $form->labelEx($model,'name',array('style'=>'width:8%')); ?>
		<?php //echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:20%')); ?>
	</div>


	<div class="ctrlHolder">
		<?php //echo $form->label($model,'cdate'); ?>
		<?php //echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php //echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php //$this->widget('application.extensions.calendar.SCalendar',
//                array(
//                    'inputField'=>'Skufindings_cdate',
//                    'button'=>'cdate_button',
//                    'ifFormat'=>'%Y-%m-%d',
//                ));
            ?>
		<?php echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Skufindings_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'updby',array('style'=>'width:13%')); ?>
		<?php echo $form->dropDownList($model,'updby',  ComSpry::getAllUserDropDownList(),array('class'=>'textInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->