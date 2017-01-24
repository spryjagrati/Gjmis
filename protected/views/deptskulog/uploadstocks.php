<div class="uniForm">
<?php 
Yii::app()->clientScript->registerScript('register_script_name', "
    $(document).ready(function(){    
      var value =$('#val_sku').val(); 
      var id =$('#id_sku').val(); 
      $('.select2-chosen').text(value);
      var input = $( 'input#skucode' );
      input.val( input.val() + id );
    });
     $(document).ready(function(){ 
      $('#Deptskulog_iddept').change(function() {
         $('#reference').change();
      });
      $('#reference').change(function() {
        var id = this.value;
        var iddept = $('#Deptskulog_iddept').val();
        //alert(dept);
         $.ajax({
          type: 'post',
          dataType :'json',
         url:'" . Yii::app()->createUrl('deptskulog/getreference')."',
         data:{'id':iddept},
         success:function(response){
          //alert(response);
         }
        });
        if(id == 1){
        $('#sent').hide();
        $('#received').show();
        }else if(id == 2){
        $('#received').hide();
        $('#sent').show();
        }else{
         $('#received').hide();
         $('#sent').hide();
        }
    });
    });
    
");
?>
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'deptskulog-form',
	'enableAjaxValidation'=>false,
  'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
  )
)); ?>
<fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
   
	<?php echo $form->errorSummary($model); ?>
        <?php if(Yii::app()->user->hasFlash('uploadfile')):?>
            <div class="info">
                <?php echo Yii::app()->user->getFlash('uploadfile'); ?>
            </div>
        <?php endif; ?>
        <?php if($model->isNewRecord){ $style=''; ?>

        <div class="ctrlHolder">
          <?php echo $form->labelEx($model,'iddept'); ?>
          <?php echo $form->dropDownList($model,'iddept',ComSpry::getDepts(),array('class'=>'textInput','style'=>'width:30%')); ?>
          <?php echo $form->error($model,'iddept'); ?>
        </div>

        <div class="ctrlHolder">
          <?php
          $value = 0;
          if(isset($model->refrcvd) && $model->refrcvd ){ $value = 1;}
          if(isset($model->refsent) && $model->refsent ){ $value = 2;}
          
          $options = array('0' =>'','1' => 'Received', '2' => 'Sent');
          echo CHtml::label('Reference Type', 'reference');
          echo CHtml::dropDownList('reference', $value, $options, array('class' => 'textInput', 'style' => 'width:30%'));
          ?>
        </div>       

        <div id="received" class="ctrlHolder" <?php if($value == 1){echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>
            <?php echo $form->labelEx($model, 'refrcvd'); ?>
            <?php echo $form->dropDownList($model, 'refrcvd', ComSpry::getDepts(), array('class' => 'textInput', 'empty' => '', 'style' => 'width:30%')); ?>
            <?php echo $form->error($model, 'refrcvd'); ?>
        </div>
    
        <div id ="sent" class="ctrlHolder"  <?php if($value == 2){echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>
              <?php echo $form->labelEx($model, 'refsent'); ?>
              <?php echo $form->dropDownList($model, 'refsent', ComSpry::getDepts(), array('class' => 'textInput', 'empty' => '', 'style' => 'width:30%')); ?>
              <?php echo $form->error($model, 'refsent'); ?>
        </div>
        <?php }else { $style='disabled:disabled'; ?>
            <div class="ctrlHolder">
              <?php echo $form->labelEx($model,'iddept'); ?>
              <?php echo $form->dropDownList($model,'iddept',ComSpry::getDepts(),array('class'=>'selectInput','empty' => '','style'=>'width:30%','disabled'=>'disabled')); ?>
              <?php echo $form->error($model,'iddept'); ?>
            </div>
            <div class="ctrlHolder">
              <?php
              $value = 0;
              if(isset($model->refrcvd) && $model->refrcvd ){ $value = 1;}
              if(isset($model->refsent) && $model->refsent ){ $value = 2;}
              
              $options = array('0' =>'','1' => 'Received', '2' => 'Sent');
              echo CHtml::label('Reference Type', 'reference');
              echo CHtml::dropDownList('reference', $value, $options, array('class' => 'textInput', 'style' => 'width:30%', 'disabled' => 'disabled'));
              ?>
            </div>      

            <div id="received" class="ctrlHolder" <?php if($value == 1){echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>
                <?php echo $form->labelEx($model, 'refrcvd'); ?>
                <?php echo $form->dropDownList($model, 'refrcvd', ComSpry::getDepts(), array('class' => 'textInput', 'empty' => '', 'style' => 'width:30%', 'disabled' => 'disabled')); ?>
                <?php echo $form->error($model, 'refrcvd'); ?>
            </div>
        
           <div id ="sent" class="ctrlHolder"  <?php if($value == 2){echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>
              <?php echo $form->labelEx($model, 'refsent'); ?>
              <?php echo $form->dropDownList($model, 'refsent', ComSpry::getDepts(), array('class' => 'textInput', 'empty' => '', 'style' => 'width:30%', 'disabled' => 'disabled')); ?>
              <?php echo $form->error($model, 'refsent'); ?>
          </div>
        <?php } ?>


        <div class="ctrlHolder">
          <?php echo $form->labelEx($model,'inputfile', array('id'=>'inputfile')); ?>
          <?php echo $form->fileField($model,'inputfile'); ?>
          
          <?php echo $form->error($model,'inputfile'); ?>
        </div>
     

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
  #inputfile{
    color:#c20f2e;
  }
</style>
