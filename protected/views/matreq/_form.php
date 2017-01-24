<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'matreq-form',
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',$model->getReqTypes(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idmetal'); ?>
		<?php echo $form->labelEx($model,'idstone',array('style'=>'width:10%')); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idstone'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idchemical'); ?>
		<?php echo $form->dropDownList($model,'idchemical',ComSpry::getChemicals(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idchemical'); ?>
		<?php echo $form->labelEx($model,'idfinding',array('style'=>'width:10%')); ?>
		<?php echo $form->dropDownList($model,'idfinding',ComSpry::getFindings(),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idfinding'); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstatusm'); ?>
		<?php echo $form->dropDownList($model,'idstatusm',ComSpry::getTypeStatusms('REQ'),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'idstatusm'); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php /*echo $form->labelEx($model,'sdate'); ?>
		<?php echo $form->textField($model,'sdate',array('class'=>'textInput','style'=>'width:12%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"sdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Matreq_sdate',
                    'button'=>'sdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'sdate'); ?>
		<?php echo $form->labelEx($model,'edate',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'edate',array('class'=>'textInput','style'=>'width:12%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"sedate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Matreq_edate',
                    'button'=>'sedate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'edate'); */?>
		<?php echo $form->labelEx($model,'estdate'); ?>
		<?php echo $form->textField($model,'estdate',array('class'=>'textInput','style'=>'width:12%;')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"estdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Matreq_estdate',
                    'button'=>'estdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->error($model,'estdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reqby'); ?>
		<?php echo $form->dropDownList($model,'reqby',ComSpry::getTypeLocDepts('m'),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'reqby'); ?>
		<?php echo $form->labelEx($model,'reqto',array('style'=>'width:10%')); ?>
		<?php echo $form->dropDownList($model,'reqto',ComSpry::getTypeLocDepts('p'),array('class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'reqto'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'rqty'); ?>
		<?php echo $form->textField($model,'rqty',array('class'=>'textInput','size'=>8,'maxlength'=>8,'style'=>'width:5%')); ?>
		<?php echo $form->error($model,'rqty'); ?>
		<?php echo $form->labelEx($model,'fqty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'fqty',array('class'=>'textInput','size'=>8,'maxlength'=>8,'style'=>'width:5%')); ?>
		<?php echo $form->error($model,'fqty'); ?>
		<?php echo $form->labelEx($model,'qunit',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'qunit',array('class'=>'textInput','size'=>8,'maxlength'=>8,'style'=>'width:5%')); ?>
		<?php echo $form->error($model,'qunit'); ?>
	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Create',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->