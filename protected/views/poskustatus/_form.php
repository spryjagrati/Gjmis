<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poskustatus-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idposku'); ?>
		<?php echo $form->textField($model,'idposku',array('size'=>6,'maxlength'=>6, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->error($model,'idposku'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reqdqty'); ?>
		<?php if($model->isNewRecord) 
                        echo $form->textField($model,'reqdqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%'));
                    else
                        echo $form->textField($model,'reqdqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%','disabled'=>'disabled'));
                ?>
		<?php echo $form->error($model,'reqdqty'); ?>
		<?php if(!$model->isNewRecord) {
                    echo $form->labelEx($model,'processqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'processqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'processqty'); ?>
		<?php echo $form->labelEx($model,'delqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'delqty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'delqty');
                    }
                ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idprocdept'); ?>
		<?php echo $form->dropdownList($model,'idprocdept',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->error($model,'idprocdept'); ?>
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
		<?php echo $form->error($model,'rcvddate'); ?>
		<?php if(!$model->isNewRecord) {
                    echo $form->labelEx($model,'dlvddate',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'dlvddate',array('class'=>'textInput','style'=>'width:15%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"dlvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Poskustatus_dlvddate',
                    'button'=>'dlvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'dlvddate');
                }
                ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatusm'); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTypeStatusms('ITEM'),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstatusm'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->