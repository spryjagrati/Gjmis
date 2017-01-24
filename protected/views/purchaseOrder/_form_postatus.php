<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'postatus-form','action'=>$this->createUrl('purchaseOrder/updatePoStatus/'.$model->idpo),
	'enableAjaxValidation'=>false,//'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('po',''); ?></span>
	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model,'idpo'); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idclient'); ?>
            <?php if($model->isNewRecord)
		echo $form->dropdownList($model,'idclient',ComSpry::getClients(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>''));
            else
                echo $form->dropdownList($model,'idclient',ComSpry::getClients(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'','disabled'=>'disabled'));
            ?>
		<?php echo $form->error($model,'idclient'); ?>
		<?php echo $form->labelEx($model,'idstatusm',array('style'=>'width:10%;')); ?>
		<?php echo $form->dropdownList($model,'idstatusm',ComSpry::getTransStatuses($model->idstatusm),array('class'=>'selectInput', 'style'=>'width:13%')); ?>
		<?php echo $form->error($model,'idstatusm'); ?>
		<?php echo $form->labelEx($model,'idprocdept',array('style'=>'width:10%')); ?>
		<?php if($model->idprocdept)
                    echo $form->dropdownList($model,'idprocdept',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput', 'style'=>'width:25%','disabled'=>'disabled'));
                else
                    echo $form->dropdownList($model,'idprocdept',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput', 'style'=>'width:25%'));
                ?>
		<?php echo $form->error($model,'idprocdept'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dlvddate'); ?>
		<?php echo $form->textField($model,'dlvddate',array('class'=>'textInput','style'=>'width:15%;','disabled'=>'disabled')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"dlvd_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Po_dlvddate',
                    'button'=>'dlvd_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'dlvddate'); ?>
		<?php echo $form->labelEx($model,'startdate',array('style'=>'width:10%;')); ?>
		<?php echo $form->textField($model,'startdate',array('class'=>'textInput','style'=>'width:15%;','disabled'=>'disabled')); ?>
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
                <?php echo CHtml::ajaxSubmitButton('Save',array('purchaseOrder/updatePoStatus/'.$model->idpo),array('update'=>'#yw0_tab_0','complete' => 'function(){$.fn.yiiGridView.update("postatuslog-grid");$.fn.yiiGridView.update("poskus-grid");}',),array('id'=>'postatus-update','class'=>'primaryAction', 'style'=>'width:20%'));?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->