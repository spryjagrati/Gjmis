<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idposkustatus'); ?>
		<?php echo $form->textField($model,'idposkustatus',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->label($model,'idposku',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'idposku',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reqdqty'); ?>
		<?php echo $form->textField($model,'reqdqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'reqdqty'); ?>
		<?php echo $form->labelEx($model,'processqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'processqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'processqty'); ?>
		<?php echo $form->labelEx($model,'delqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'delqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'delqty'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idprocdept'); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Poskustatus_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Poskustatus_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby',  ComSpry::getAllUserDropDownList(),array('class'=>'textInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'rcvddate'); ?>
		<?php echo $form->textField($model,'rcvddate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"rcvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Poskustatus_rcvddate',
                    'button'=>'rcvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->labelEx($model,'dlvddate',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'dlvddate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"dlvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Poskustatus_dlvddate',
                    'button'=>'dlvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatusm'); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTypeStatusms('ITEM'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->