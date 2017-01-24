
<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sku-form','action'=>$this->createUrl('product/updateSku/'.$model->idsku),
	'enableAjaxValidation'=>false,//'layoutName'=>'qtip'
)); ?>

    <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('sku',''); ?></span>
	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model,'idsku'); ?>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'skucode'); ?>
            <?php if($model->isNewRecord)
                        echo $form->textField($model,'skucode',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:13%'));
                    else
                        echo $form->textField($model,'skucode',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:13%','disabled'=>'disabled'));
            ?>
		<?php //echo $form->error($model,'skucode'); ?>

		<?php echo $form->labelEx($model,'refpo',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'refpo',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php //echo $form->error($model,'refpo'); ?>

                <?php echo $form->labelEx($model,'sub_category',array('style'=>'width:18%')); ?>
		<?php echo $form->dropDownList($model,'sub_category', $model->getTypes(), array('class'=>'selectInput','empty' => '', 'style'=>'width:20%')); ?>
		<?php echo $form->error($model,'sub_category'); ?>     
	</div>
        
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'leadtime'); ?>
		<?php echo $form->textField($model,'leadtime',array('size'=>2,'maxlength'=>2,'class'=>'textInput', 'style'=>'width:3%')); ?>
		<p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">days</p>
                <?php //echo $form->error($model,'leadtime'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'parentsku'); ?>
            <?php
            if($model->parentsku == NULL){
            $this->widget('ext.select2.ESelect2',array(
                 //'selector' => '#skucode',            
                 'model'=>$model,
                 'attribute' => 'parentsku',
                  'options'  => array( 
           
           'placeholder'=>'Select Sku',
            'minimumInputLength'=> 2,
           'ajax' => array(
            'url' => Yii::app()->createUrl('product/getskucode'),
            'dataType' => 'json',
            'quietMillis'=> 100,
            'data' => 'js: function(term,page) {
                    return {                      
                        q: term, 
                        page_limit: 10,                                  
                        page: page,
                    };
                }',
            'results'=>'js:function(data,page) { 
            
              return {results: data }; }',
        ),
             'formatResult'=> 'js:function(data){
                if (data.name !== undefined) {
                    return data.name;
                }
                return "";
            }',
            'formatSelection' => 'js: function(data) {
                return data.name;
            }',
            'initSelection' =>'js: function (element, callback) {               
                var element = $(element).val();  

                callback(data.name);
            }',
            'escapeMarkup'=>'js: function(m) { return m; }' 
       ), 
          
        ));
            }else{
              echo $form->dropdownList($model,'parentsku',  ComSpry::getSkucode(),array('class'=>'selectInput', 'style'=>'width:20%','empty'=>''));
            }
            
            ?>
		<?php //echo $form->textField($model,'parentsku',array('class'=>'textInput', 'style'=>'width:33%')); ?>
		<?php //echo $form->error($model,'parentsku'); ?>

		<?php echo $form->labelEx($model,'parentrel',array('style'=>'width:10%')); ?>
		<?php echo $form->dropdownList($model,'parentrel',$model->getRelTypes(),array('class'=>'selectInput', 'style'=>'width:13%','empty'=>'')); ?>
		<?php //echo $form->error($model,'parentrel'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'taxcode'); ?>
		<?php echo $form->textField($model,'taxcode',array('size'=>16,'maxlength'=>16,'class'=>'textInput', 'style'=>'width:13%')); ?>
		<?php //echo $form->error($model,'taxcode'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'dimdia'); ?>
		<?php echo $form->textField($model,'dimdia',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'dimdia'); ?>
		<?php echo $form->labelEx($model,'dimhei',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimhei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'dimhei'); ?>
		<?php echo $form->labelEx($model,'dimwid',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimwid',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'dimwid'); ?>
		<?php echo $form->labelEx($model,'dimlen',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimlen',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'dimlen'); ?>
                <?php echo $form->labelEx($model,'dimunit',array('style'=>'width:7%')); ?>
		<?php echo $form->textField($model,'dimunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'dimunit'); ?>
	</div>

        	

	<div class="ctrlHolder">

		<?php echo $form->labelEx($model,'grosswt'); ?>
		<?php echo $form->textField($model,'grosswt',array('size'=>8,'maxlength'=>8, 'class'=>'textInput', 'style'=>'width:12%')); ?>
		<?php echo $form->labelEx($model,'totmetalwei',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'totmetalwei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
            <p class="formHint" style="width:3%; display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">gms</p>
		<?php //echo $form->error($model,'totmetalwei'); ?>
		<?php //echo $form->labelEx($model,'metweiunit',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'metweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'metweiunit'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'numstones'); ?>
		<?php echo $form->textField($model,'numstones',array('size'=>2,'maxlength'=>2, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
		<?php //echo $form->error($model,'numstones'); ?>
		<?php echo $form->labelEx($model,'totstowei',array('style'=>'width:13%')); ?>
		<?php echo $form->textField($model,'totstowei',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled')); ?>
            <p class="formHint" style="width:3%; display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">ct</p>
		<?php //echo $form->error($model,'totstowei'); ?>
		<?php //echo $form->labelEx($model,'stoweiunit',array('style'=>'width:13%')); ?>
		<?php //echo $form->textField($model,'stoweiunit',array('size'=>4,'maxlength'=>4, 'class'=>'textInput', 'style'=>'width:8%')); ?>
		<?php //echo $form->error($model,'stoweiunit'); ?>
	</div>

	<div class="buttonHolder">
                <?php echo CHtml::ajaxSubmitButton('Save',array('product/updateSku', 'id'=>$model->idsku),array('update'=>'#yw0_tab_1','complete' => 'function(){$.fn.yiiGridView.update("skumetals-grid");}',),array('id'=>'sku-update','class'=>'primaryAction', 'style'=>'width:20%'));?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->

