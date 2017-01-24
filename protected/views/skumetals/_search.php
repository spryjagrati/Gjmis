<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idskumetals'); ?>
		<?php echo $form->textField($model,'idskumetals'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->dropDownList($model,'idsku',ComSpry::getSku(), array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php //echo $form->textField($model,'idsku',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetalList(),array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>

		<?php echo $form->labelEx($model,'weight',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'weight',array('size'=>9,'maxlength'=>9,'class'=>'textInput','style'=>'width:5%')); ?>

            	<?php //echo $form->labelEx($model,'lossfactor',array('style'=>'width:12%')); ?>
		<?php //echo $form->textField($model,'lossfactor',array('size'=>4,'maxlength'=>4)); ?>
		<!--<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">%</p>-->
        </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'usage'); ?>
		<?php echo $form->textField($model,'usage',array('size'=>16,'maxlength'=>16,'class'=>'textInput','style'=>'width:20%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php //echo $form->label($model,'cdate'); ?>
		<?php //echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php //echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php //$this->widget('application.extensions.calendar.SCalendar',
//                array(
//                    'inputField'=>'Skumetals_cdate',
//                    'button'=>'cdate_button',
//                    'ifFormat'=>'%Y-%m-%d',
//                ));
            ?>
		<?php //echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php //echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php //$this->widget('application.extensions.calendar.SCalendar',
//                array(
//                    'inputField'=>'Skumetals_mdate',
//                    'button'=>'mdate_button',
//                    'ifFormat'=>'%Y-%m-%d',
//                ));
            ?>
		<?php //echo $form->label($model,'updby',array('style'=>'width:13%')); ?>
		<?php // $form->dropDownList($model,'updby',  ComSpry::getAllUserDropDownList(),array('class'=>'textInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->