<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php //echo $form->label($model,'idsku'); ?>
		<?php //echo $form->textField($model,'idsku',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->label($model,'idstone',array('style'=>'width:8%')); ?>
		<?php //echo $form->dropDownList($model,'idstone',ComSpry::getStones(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php //echo $form->label($model,'idsetting',array('style'=>'width:8%')); ?>
		<?php //echo $form->dropDownList($model,'idsetting', ComSpry::getSettings(), array('class'=>'selectInput', 'style'=>'width:8%','empty'=>'')); ?>
		<?php //echo $form->label($model,'type',array('style'=>'width:8%')); ?>
		<?php //echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%','empty'=>'')); ?>
		
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'pieces'); ?>
		<?php echo $form->textField($model,'pieces',array('size'=>2,'maxlength'=>2, 'class'=>'textInput', 'style'=>'width:3%')); ?>
        </div>

	<div class="ctrlHolder">
		<?php //echo $form->label($model,'cdate'); ?>
		<?php //echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php //echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php //$this->widget('application.extensions.calendar.SCalendar',
//                array(
//                    'inputField'=>'Skustones_cdate',
//                    'button'=>'cdate_button',
//                    'ifFormat'=>'%Y-%m-%d',
//                ));
            ?>
		<?php //echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php //echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php //$this->widget('application.extensions.calendar.SCalendar',
//                array(
//                    'inputField'=>'Skustones_mdate',
//                    'button'=>'mdate_button',
//                    'ifFormat'=>'%Y-%m-%d',
//                ));
            ?>
		<?php echo $form->label($model,'updby',array('style'=>'width:13%')); ?>
		<?php echo $form->dropDownList($model,'updby',  ComSpry::getAllUserDropDownList(),array('class'=>'textInput', 'style'=>'width:13%','empty'=>'')); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idsku'); ?>
		<?php echo $form->dropDownList($model,'idsku',ComSpry::getSku(), array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php echo $form->error($model,'idsku'); ?>
		<?php echo $form->labelEx($model,'idstone',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStonesList(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'')); ?>
		<?php echo $form->error($model,'idstone'); ?>
		<?php echo $form->labelEx($model,'idsetting',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'idsetting', ComSpry::getSettingsList(), array('class'=>'selectInput', 'style'=>'width:8%','empty'=>'')); ?>
		<?php echo $form->error($model,'idsetting'); ?>
		<?php echo $form->labelEx($model,'type',array('style'=>'width:8%')); ?>
		<?php echo $form->dropDownList($model,'type',$model->getTypes(),array('class'=>'selectInput', 'style'=>'width:10%','empty'=>'')); ?>
		<?php echo $form->error($model,'type'); ?>

	</div>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->