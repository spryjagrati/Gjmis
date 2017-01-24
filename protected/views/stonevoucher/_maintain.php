<style>
    .uniForm .inlineLabels label, .uniForm .inlineLabels .label{
        width:7.2%;
    }
    
    #add_field a{
        float:right;
    }
</style>
<?php 
       foreach(ComSpry::getStones() as $key=>$value){
           $data =  $data.'<option value="'.$key.'">'.$value.'</option>';
       }
	   $string_data = preg_replace("/\r?\n/", "\\n", addslashes($data));
     //  print_r($data);die();
?>
<script>
    var count = 0;
    $(function(){
            $('p#add_field').click(function(){
                    count += 1;
                    $('#container').append('<div class="ctrlHolder"><label for="Stonestocks_idstone" class="required">Stone <span class="required">*</span></label> '
                                                + '<select class="selectInput" style="width:15%" name="Stonestocks[more][' + count + '][idstone]" id="Stonestocks_idstone">'
                                                + '<option value=""></option>'
                                                + '<?php print_r($string_data); ?>'
                                                + '</select>'		
                                                + '<label for="Stonestocks_qty" class="required">Quantity <span class="required">*</span></label>'             
                                                + '<input empty="" class="textInput" style="width:3%" name="Stonestocks[more][' + count + '][qty]" id="Stonestocks_qty" type="text">'	
                                                + '<label for="Stonestocks_idpo">IdPO</label> '               
                                                + '<input empty="" class="textInput" style="width:3%" name="Stonestocks[more][' + count + '][idpo]" id="Stonestocks_idpo" type="text">'                
                                                + '<label for="Stonestocks_stonewt">Total Stone Wt</label> '               
                                                + '<input empty="" class="textInput" style="width:7%" name="Stonestocks[more][' + count + '][stonewt]" id="Stonestocks_stonewt" type="text" value="0.0000">'                
                                                + '<label for="Stonestocks_remark">Remark</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][remark]" id="Stonestocks_remark" type="text"> '
                                                + '<input  style="width:3%" name="Stonestocks[more][' + count + '][acknow]" id="Stonestocks_acknow" type="checkbox"> '
                                                + '<div style="clear:both;"></div><label for="Stonestocks_Sku Name">Sku Name</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][skuname]" id="Stonestocks_skuname" type="text"> '
                                                + '<label for="Stonestocks_set">Set</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][set]" id="Stonestocks_set" type="text"> '
                                                + '<div>');
                                                });
                                        });
    
    
</script>
<div class="uniForm">
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'stonestocks-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">

    <p class="note"  style="width:22% !important ">Fields with <span class="required">*</span> are required.</p>
    
    
    <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstone'); ?>
                <?php echo $form->dropDownList($model,'idstone',ComSpry::getStones(),array( 'class'=>'selectInput', 'empty' => '','style'=>'width:15%')); ?>
		<?php echo $form->labelEx($model,'qty'); ?>
                <?php echo $form->textField($model,'qty',array('empty' => '', 'class'=>'textInput', 'style'=>'width:3%')); ?>
		<?php echo $form->labelEx($model,'idpo'); ?>
                <?php echo $form->textField($model,'idpo',array('empty' => '', 'class'=>'textInput', 'style'=>'width:3%')); ?>
                <?php echo $form->labelEx($model,'Total Stone Wt'); ?>
                <?php echo $form->textField($model,'stonewt',array('empty' => '', 'class'=>'textInput', 'style'=>'width:7%')); ?>
                <?php echo $form->labelEx($model,'remark'); ?>
                <?php echo $form->textField($model,'remark',array('empty' => '', 'class'=>'textInput', 'style'=>'width:10%')); ?>
                <?php echo $form->checkBox($model,'acknow',array('style'=>'width:3%')); ?>
                <br/>
                <br/>
                <?php echo $form->labelEx($model,'Sku Name'); ?>
                <?php echo $form->textField($model,'skuname',array('empty' => '', 'class'=>'textInput', 'style'=>'width:10%')); ?>
           
                <?php echo $form->labelEx($model,'Set'); ?>
                <?php echo $form->textField($model,'set',array('empty' => '', 'class'=>'textInput', 'style'=>'width:10%')); ?>
    </div>
    
   <div id="container"></div>
    
    <p id="add_field"><a href="#"><span>Add More Stones</span></a></p>
    
    <div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
                
    </div>

<?php $this->endWidget(); ?>  
</fieldset>
</div><!-- form -->