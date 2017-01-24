<style>
    .uniForm .inlineLabels label, .uniForm .inlineLabels .label{
        width:7.2%;
    }
    
    #add_field a{
        float:right;
    }
</style>


<div class="uniForm">
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'stonestocks-form',
	'enableAjaxValidation'=>false,'layoutName'=>'qtip'
)); ?>
<fieldset class="inlineLabels">

    <p class="note"  style="width:22% !important ">Fields with <span class="required">*</span> are required.</p>
    
    <?php
        $i = 0;
        foreach(ComSpry::getStones() as $key=>$value){
           $data =  $data.'<option value="'.$key.'">'.$value.'</option>';
       }
	   $string_data = preg_replace("/\r?\n/", "\\n", addslashes($data));
        foreach($models as $model){ ?>
    <?php 
//       /  print_r($model->attributes);die();
    $stonemodel= new Stone();
        $stone_name=$stonemodel->findByPk($model->idstone)->name;
    ?>
    <div class="ctrlHolder">
                                                <input type="hidden" value="<?php print_r($model->idstonestocks); ?>" name="Stonestocks[<?php print_r($i); ?>][idstonestocks]" id="Stonestocks_idstonestocks">
                                                <label for="Stonestocks_idstone" class="required">Stone <span class="required">*</span></label> 
                                                <input empty="" class="textInput" style="width:3%" name="Stonestocks[<?php print_r($i); ?>][idstone]" id="Stonestocks_idstone" type="hidden" value="<?php print_r($model->idstone); ?>" >	
                                                <input empty="" class="textInput" style="width:20%" name="Stonestocks[<?php echo $i;?>][stone_name]" id="Stonestocks_idstone" type="text" value="<?php echo $stone_name; ?>" disabled="disabled" >
                                                
                                                <!--<select class="selectInput" style="width:15%" name="Deptstonelog[<?php //print_r($i); ?>][idstone]" id="Deptstonelog_idstone" disabled="disabled" >
                                                <option value="" ></option>
                                                <?php //print_r($data); ?>
                                                </select>
                                                -->
                                                
                                                <label for="Stonestocks_qty" class="required">Quantity <span class="required">*</span></label>           
                                                <input empty="" class="textInput" style="width:3%" name="Stonestocks[<?php echo $i;?>][qty]" id="Stonestocks_qty" type="text" value="<?php print_r($model->qty); ?>" disabled="disabled">	
                                                <label for="Stonestocks_idpo">IdPO</label>                
                                                <input empty="" class="textInput" style="width:3%" name="Stonestocks[<?php print_r($i); ?>][idpo]" id="Stonestocks_idpo" type="text" value="<?php print_r($model->idpo); ?>" disabled="disabled" >                
                                                <input empty="" class="textInput" style="width:3%" name="Stonestocks[<?php print_r($i); ?>][idpo]" id="Stonestocks_idpo" type="hidden" value="<?php print_r($model->idpo); ?>"  >                
                                                <label for="Stonestocks_stonewt">Stone Wt. per piece</label>               
                                                <input empty="" class="textInput" style="width:7%" name="Stonestocks[<?php print_r($i); ?>][stonewt]" id="Stonestocks_stonewt" type="text" value="<?php print_r($model->stonewt); ?>" disabled="disabled" >                
                                                <label for="Stonestocks_remark">Remark</label>               
                                                <input empty="" class="textInput" style="width:10%" name="Stonestocks[<?php print_r($i); ?>][remark]" id="Stonestocks_remark" type="text" value="<?php print_r($model->remark); ?>" >  
                                                <input style="width:3%" name="Stonestocks[<?php print_r($i); ?>][acknow]" id="Stonestocks_acknow"    <?php if($model->acknow ==1){?> checked="checked" <?php } ?>type="checkbox">
                                                <div style="clear:both;"></div>
                                                <label for="Stonestocks_skuname">Sku Name</label>               
                                                <input empty="" class="textInput" style="width:10%" name="Stonestocks[<?php print_r($i); ?>][skuname]" id="Stonestocks_skuname" type="text" value="<?php print_r($model->skuname); ?>" >  
                                                
                                                <label for="Stonestocks_set">Set</label>               
                                                <input empty="" class="textInput" style="width:10%" name="Stonestocks[<?php print_r($i); ?>][set]" id="Stonestocks_set" type="text" value="<?php print_r($model->set); ?>" >  
                                                
    </div>
    <?php $i++;} 
    
    Yii::trace('before', 'pradeep');
       $select_html=$form->dropDownList(new Stone(),'idstone',ComSpry::getStones(), array('class'=>'selectInput', 'style'=>'width:20%','empty'=>'', 'name'=>'Stonestocks[more][placeholderxxx][idstone]'));
    Yii::trace('after', 'pradeep');
	 
	?>
    
   <div id="container"></div>
    
    <p id="add_field"><a href="#"><span>Add More Stones</span></a></p>
    
    <div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
                
    </div>

<?php $this->endWidget(); ?>  
</fieldset>
</div><!-- form -->

<script>
    var count = <?php echo($i); ?>;
     //var data = "<?php //print_r($data); ?>";
     var select_html = "<?php echo preg_replace("/\r?\n/", "\\n", addslashes($select_html));?>";
    
    $(function(){
            $('p#add_field').click(function(){
                    count += 1; 
                    new_html = select_html.replace('placeholderxxx', count)
                    $('#container').append('<div class="ctrlHolder"><label for="Stonestocks_idstone" class="required">Stone <span class="required">*</span></label> '
                                                + new_html	
                                                + '<label for="Stonestocks_qty" class="required">Quantity <span class="required">*</span></label>'             
                                                + '<input empty="" class="textInput" style="width:3%" name="Stonestocks[more][' + count + '][qty]" id="Stonestocks_qty" type="text">'	
                                                + '<label for="Stonestocks_idpo">IdPO</label> '               
                                                + '<input empty="" class="textInput" style="width:3%" name="Stonestocks[more][' + count + '][idpo]" id="Stonestocks_idpo" type="text">'                
                                                + '<label for="Stonestocks_stonewt">Stone Wt. per piece</label> '               
                                                + '<input empty="" class="textInput" style="width:7%" name="Stonestocks[more][' + count + '][stonewt]" id="Stonestocks_stonewt" type="text" value="0.0000">'                
                                                + '<label for="Stonestocks_remark">Remark</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][remark]" id="Stonestocks_remark" type="text"> '
                                                + '<input  style="width:3%" name="Stonestocks[more][' + count + '][acknow]" id="Stonestocks_acknow" type="checkbox"> '
                                                + '<div style="clear:both;"></div>'
                                                +'<label for="Stonestocks_skuname">Sku Name</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][skuname]" id="Stonestocks_skuname" type="text"> '
                                                + '<label for="Stonestocks_set">Set</label>  '             
                                                + '<input empty="" class="textInput" style="width:10%" name="Stonestocks[more][' + count + '][set]" id="Stonestocks_set" type="text"> '
                                                + '<div>');
                                                });
                                        });
    
    
</script>