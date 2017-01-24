<h3>Gtdf export with SKU Name</h3>
<div class="uniForm">


<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'gtdf-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
 <?php echo $form->errorSummary($model); ?>
	<fieldset class="inlineLabels">
    	<p class="note">Fields with <span class="required">*</span> are required.</p>
    	<?php echo $form->errorSummary($model); ?>
    	<div class="ctrlHolder">
    		<?php echo $form->labelEx($model,'skucode'); ?>
            <?php
                $this->widget('ext.multicomplete.MultiComplete', array(
                    'model'=>$model,
                    'attribute'=>'skucode',
                    'name'=>'codeme',
                    'sourceUrl'=>'skuexport/search',
                    'options'=>array(
                    'delay'=>300,
                    'minLength'=>2,
                ),
                'htmlOptions'=>array(
                'style'=>'height:20px;'
                ),
            ));?>
	        <?php echo $form->error($model,'skucode'); ?>
            <?php echo Chtml::hiddenField('type',1,array('id' => 'download_type_n')); ?>
    	</div>
    	
        <div class="buttonHolder">
    		<?php echo CHtml::submitButton('Submit',array('class'=>'primaryAction', 'style'=>'width:20%', 'onclick' => '$("#download_type_n").val(1);')); ?><?php echo CHtml::submitButton('Download Images',array('class'=>'primaryAction', 'style'=>'margin-left:10px;', 'onclick' => '$("#download_type_n").val(2);')); ?>
    	</div>
    </fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
