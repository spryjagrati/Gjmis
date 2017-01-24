<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idposkus'); ?>
		<?php echo $form->textField($model,'idposkus',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->label($model,'idpo',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'idpo',array('size'=>6,'maxlength'=>6, 'class'=>'textInput', 'style'=>'width:15%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->label($model,'qty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'qty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->label($model,'totamt',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'totamt',array('size'=>9,'maxlength'=>9, 'class'=>'textInput', 'style'=>'width:10%','disabled'=>'disabled')); ?>
	</div>
        
	<div class="ctrlHolder">
		<?php echo $form->label($model,'reforder'); ?>
		<?php echo $form->textField($model,'reforder',array('size'=>10,'maxlength'=>10, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->label($model,'usnum',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'usnum',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->label($model,'ext',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'ext',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'descrip'); ?>
		<?php echo $form->textArea($model,'descrip',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'remark'); ?>
		<?php echo $form->textArea($model,'remark',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Posku_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Posku_mdate',
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
		<?php echo $form->label($model,'refno'); ?>
		<?php echo $form->textField($model,'refno',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->label($model,'custsku',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'custsku',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->label($model,'itemtype',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'itemtype',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:10%')); ?>
	</div>


	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->