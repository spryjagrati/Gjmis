<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
	<div class="ctrlHolder">
		<?php echo $form->label($model,'idcostadd'); ?>
		<?php echo $form->textField($model,'idcostadd'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',$model->getCaddTypes()); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idmetal'); ?>
		<?php echo $form->dropDownList($model,'idmetal',ComSpry::getMetals(),array('empty' => '')); ?>
	</div>
<!--
        <div class="ctrlHolder">
		<?php echo $form->label($model,'factormetal'); ?>
		<?php echo $form->textField($model,'factormetal',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idstone'); ?>
		<?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array('empty' => '')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'factorstone'); ?>
		<?php echo $form->textField($model,'factorstone',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idchemical'); ?>
		<?php echo $form->dropDownList($model,'idchemical',ComSpry::getChemicals(),array('empty' => '')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'factorchem'); ?>
		<?php echo $form->textField($model,'factorchem',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'idsetting'); ?>
		<?php echo $form->dropDownList($model,'idsetting',ComSpry::getSettings(),array('empty' => '')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'factorsetting'); ?>
		<?php echo $form->textField($model,'factorsetting',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'factornumsto'); ?>
		<?php echo $form->textField($model,'factornumsto',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'fixcost'); ?>
		<?php echo $form->textField($model,'fixcost',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'costformula'); ?>
		<?php echo $form->textField($model,'costformula',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'threscostformula'); ?>
		<?php echo $form->textField($model,'threscostformula',array('size'=>45,'maxlength'=>45)); ?>
	</div>
-->
	<div class="ctrlHolder">
		<?php echo $form->label($model,'cdate'); ?>
		<?php echo $form->textField($model,'cdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Costadd_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Costadd_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->label($model,'updby'); ?>
		<?php echo $form->dropDownList($model,'updby', ComSpry::getAllUserDropDownList()); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->