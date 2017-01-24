<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'posku-form','action'=>$this->createUrl('purchaseOrder/createItem/'.$model->idpo),
	'enableAjaxValidation'=>false,
)); ?>
    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('posku',''); ?></span>
	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model,'idpo'); ?>


        <div class="ctrlHolder">
         
        
		<?php echo $form->hiddenField($model,'idsku'); ?>

                <label class="required">SKU# *</label>
           <?php
                    $count=Yii::app()->db->createCommand('select * from tbl_sku')->queryAll();
                  $query=array(); foreach($count as $c)
                    {$i=0;$query[]  = array('label'=>$c['skucode'],'value' =>$c['idsku']); $i++;}
                  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(


                    'name'=>'sku',
                    'source'=>$query,
                    // additional javascript options for the autocomplete plugin

                    'options'=>array(
                    'focus'=>'js:function( event, ui ) {
				$( "#sku" ).val( ui.item["label"] );
				return false;
			}',

                        'select'=>'js: function( event, ui ) {
				$( "#sku" ).val( ui.item["label"] );
				$( "#Poskus_idsku" ).val( ui.item["value"] );

				return false;
			}',
                    'delay'=>300,
                    'minLength'=>3,
                    ),

                    'htmlOptions'=>array('size'=>8,'maxlength'=>8,
                        'class'=>'textInput',
                        'style'=>'width:15%'),
                ));  ?>
	
           
        


		<?php echo $form->labelEx($model,'qty',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'qty',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		
	</div>
        
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'reforder'); ?>
		<?php echo $form->textField($model,'reforder',array('size'=>10,'maxlength'=>10, 'class'=>'textInput', 'style'=>'width:15%')); ?>
		<?php echo $form->error($model,'reforder'); ?>
		<?php echo $form->labelEx($model,'usnum',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'usnum',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'usnum'); ?>
		<?php echo $form->labelEx($model,'ext',array('style'=>'width:10%')); ?>
		<?php echo $form->textField($model,'ext',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:10%')); ?>
		<?php echo $form->error($model,'ext'); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'refno'); ?>
                <?php echo $form->textField($model,'refno',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php echo $form->error($model,'refno'); ?>
		<?php echo $form->labelEx($model,'metalstamp',array('style'=>'width:20%')); ?>
		<?php echo $form->dropDownList($model,'metalstamp',ComSpry::getMetalStamps(),array('empty'=>'','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'metalstamp'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'remark'); ?>
		<?php echo $form->textArea($model,'remark',array('rows'=>2,'cols'=>40,'maxlength'=>128, 'class'=>'textArea', 'style'=>'height:3em;')); ?>
		<?php echo $form->error($model,'remark'); ?>
	</div>

	<div class="buttonHolder">
		
		<?php echo CHtml::submitButton($model->isNewRecord?'Create':'Save',array('id'=>'posku-create','class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
