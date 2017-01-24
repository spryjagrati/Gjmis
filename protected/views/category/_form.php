<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	 $("#parent").change(function() {
        var id = this.value;
        //alert(id);
       if(id != '')
           $("#category").text('Sub Category*');
       else
            $("#category").text('Category*');
       
    });
});
</script>
<style>
    .uniForm .inlineLabels label, .uniForm .inlineLabels .label
    {
        width: 13%;
        margin-left: 10px;
    }

</style>
<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */

?>

<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
)); ?>
    <fieldset class="inlineLabels">
        
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        
        <?php if(Yii::app()->user->hasFlash('message')){  ?>
        <div class="alert alert-success"><?php echo Yii::app()->user->getFlash('message')?></div>
        <?php }?>
	<?php echo $form->errorSummary($model); ?>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php echo $form->dropDownList($model,'parent',ComSpry::getCategories(),array('id'=>'parent','class'=>'selectInput','empty' => '','style'=>'width:20%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'category',array('id'=>'category')); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
		<?php //echo $form->error($model,'category'); ?>

		<?php echo $form->labelEx($model,'package_length'); ?>
		<?php echo $form->textField($model,'package_length',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'package_height'); ?>
		<?php echo $form->textField($model,'package_height',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	
		<?php echo $form->labelEx($model,'package_width'); ?>
		<?php echo $form->textField($model,'package_width',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dimension_unit'); ?>
		<?php echo $form->textField($model,'dimension_unit',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>

		<?php echo $form->labelEx($model,'dept'); ?>
		<?php echo $form->textField($model,'dept',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	</div>
	    <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'class'); ?>
		<?php echo $form->textField($model,'class',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	
		<?php echo $form->labelEx($model,'subclass'); ?>
		<?php echo $form->textField($model,'subclass',array('size'=>60,'maxlength'=>128,'class'=>'textInput', 'style'=>'width:30%')); ?>
	</div>
	   
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
