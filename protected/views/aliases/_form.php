<script type="text/javascript">
$(document).ready(function(){
	$("#Aliases_option").change(function(){
		var option = $('#Aliases_option').val();
		 window.location.href =  '?option=' + option;
                 
	});
        var query = window.location.search.split('=') ;
        if(query){
            $('#Aliases_option').val(query[1]);
        }
});
</script>

<?php
/* @var $this AliasesController */
/* @var $model Aliases */
/* @var $form CActiveForm */
?>

<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'aliases-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
)); ?>
     <fieldset class="inlineLabels">

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'aTarget'); ?>
		<?php echo $form->dropDownList($model,'aTarget',array('0'=>'All') + ComSpry::getClients(),array('class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'aTarget'); ?>
	</div>
        <div class="ctrlHolder">

		<?php 
                $a=ComSpry::getOptions();
                $a1=array(1=>'Aliases with Dependants');
                 $a2=array(2=>'Only Dependants');
                 $c=  array_replace($a, $a1,$a2);
                 
                echo $form->labelEx($model,'option'); ?>
             <?php echo $form->dropDownList($model,'option',$c, array(
                      'class'=>'textInput','style'=>'width:25%;' ,
              )); ?>
		<?php echo $form->error($model,'option'); ?>
	</div>
       
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'aField'); ?>
		<?php echo $form->textField($model,'aField',array('size'=>60,'maxlength'=>64,'class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'aField'); ?>
	</div>
      
        
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'initial'); ?>
		<?php echo $form->textField($model,'initial',array('size'=>60,'maxlength'=>64,'class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'initial'); ?>
	</div>
        <?php if(!isset($_GET['option'])){ ?>
         <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>64,'class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>
        <?php } ?>
        <?php if(isset($_GET['option'])){
            if($_GET['option']!=2){ ?>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>64,'class'=>'textInput','style'=>'width:25%;')); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>
        <?php }} ?>
       
        <?php
 
            // see http://www.yiiframework.com/doc/guide/1.1/en/form.table
            // Note: Can be a route to a config file too,
            //       or create a method 'getMultiModelForm()' in the member model

            $memberFormConfig = array(
                  'elements'=>array(
                    'column'=>array(
                        'type'=>'text',
                        'maxlength'=>40,
                    ),
                    'alias'=>array(
                        'type'=>'text',
                        'maxlength'=>40,
                    ),
                ));

            $this->widget('ext.multimodelform.MultiModelForm',array(
                    'id' => 'id', //the unique widget id
                    'formConfig' => $memberFormConfig, //the form configuration array
                    'model' => $member, //instance of the form model

                    //if submitted not empty from the controller,
                    //the form will be rendered with validation errors
                    'validatedItems' => $validatedMembers,
                    'bootstrapLayout' => true,
                    //array of member instances loaded from db
                    'data' => $member->findAll('idaliases=:idaliases', array(':idaliases'=>$model->id)),
                    'removeText' => 'X', 
                    'tableView' => false, //sortable will not work
                    'fieldsetWrapper' => array('tag' => 'div', 'htmlOptions' => array('class' => 'ctrlHolder ctrpanel')),
                ));
        ?>
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
        
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->