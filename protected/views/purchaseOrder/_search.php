<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo',array('class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php echo $form->labelEx($model,'idclient',array('style'=>'width:10%;')); ?>
		<?php echo $form->dropdownList($model,'idclient',ComSpry::getClients(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->labelEx($model,'idstatusm',array('style'=>'width:10%;')); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTypeStatusms('PO'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby',  ComSpry::getAllUserDropDownList(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->label($model,'totamt',array('style'=>'width:10%;')); ?>
		<?php echo $form->textField($model,'totamt',array('size'=>9,'maxlength'=>9, 'class'=>'textInput')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'dlvddate'); ?>
		<?php echo $form->textField($model,'dlvddate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"dlvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_dlvddate',
                    'button'=>'dlvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'startdate',array('style'=>'width:10%;')); ?>
		<?php echo $form->textField($model,'startdate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"start_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_startdate',
                    'button'=>'start_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'instructions'); ?>
		<?php echo $form->textArea($model,'instructions',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->