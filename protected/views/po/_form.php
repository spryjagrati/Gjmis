<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'po-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip',
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idclient'); ?>
            <?php if($model->isNewRecord)
		echo $form->dropdownList($model,'idclient',ComSpry::getClients(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>''));
            else
                echo $form->dropdownList($model,'idclient',ComSpry::getClients(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'','disabled'=>'disabled'));
            ?>
		<?php echo $form->error($model,'idclient'); ?>
		<?php if(!$model->isNewRecord){
                    echo $form->labelEx($model,'idstatusm',array('style'=>'width:10%;')); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTypeStatusms('PO'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstatusm');
                }?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dlvddate'); ?>
		<?php echo $form->textField($model,'dlvddate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"dlvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_dlvddate',
                    'button'=>'dlvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'dlvddate'); ?>
		<?php echo $form->labelEx($model,'startdate'); ?>
		<?php echo $form->textField($model,'startdate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"start_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_startdate',
                    'button'=>'start_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'startdate'); ?>
	</div>
<?php if(!$model->isNewRecord){ ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'totamt'); ?>
		<?php echo $form->textField($model,'totamt',array('size'=>9,'maxlength'=>9, 'class'=>'textInput','style'=>'width:8%;','disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'totamt'); ?>
	</div>
<?php } ?>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'instructions'); ?>
		<?php echo $form->textArea($model,'instructions',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'instructions'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->