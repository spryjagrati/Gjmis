<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idsku'); ?>
		<?php echo $form->textField($model,'idsku',array('class'=>'textInput', 'style'=>'width:13%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'skucode'); ?>
		<?php echo $form->textField($model,'skucode',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
	</div>

        	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Sku_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
		<?php echo $form->label($model,'mdate',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'mdate',array('class'=>'textInput', 'style'=>'width:13%')); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer","style"=>"float:left")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Sku_mdate',
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
		<?php echo $form->labelEx($model,'leadtime'); ?>
		<?php echo $form->textField($model,'leadtime',array('size'=>2,'maxlength'=>2,'class'=>'textInput', 'style'=>'width:3%')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">days</p>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'parentsku'); ?>
		<?php echo $form->textField($model,'parentsku',array('class'=>'textInput', 'style'=>'width:33%')); ?>

		<?php echo $form->labelEx($model,'parentrel',array('style'=>'width:10%')); ?>
		<?php echo $form->dropdownList($model,'parentrel',$model->getRelTypes(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
        </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'taxcode'); ?>
		<?php echo $form->textField($model,'taxcode',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dimdia'); ?>
		<?php echo $form->textField($model,'dimdia',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'dimhei',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimhei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'dimwid',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimwid',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'dimlen',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimlen',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'dimunit',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
	</div>
<!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'totmetalwei'); ?>
		<?php echo $form->textField($model,'totmetalwei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'metweiunit',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'metweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'totstowei'); ?>
		<?php echo $form->textField($model,'totstowei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'stoweiunit',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'stoweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->labelEx($model,'numstones',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'numstones',array('size'=>2,'maxlength'=>2, 'class'=>'textInput', 'style'=>'width:8%')); ?>
	</div>
-->
	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->