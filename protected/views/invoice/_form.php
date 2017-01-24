
<script type="text/javascript">
$(document).ready(function(){
	$("#Invoice_idlocation").change(function(){
		var department = $('#Invoice_idlocation').val();
		<?php if ($model->isNewRecord){ ?>
		 window.location.href =  '<?php echo Yii::app()->createurl("invoice/create"); ?>' + '?department=' + department;
		<?php }else{ ?>
			 window.location.href =  '<?php echo Yii::app()->createurl("invoice/update"); ?>' + '?department=' + department;
		<?php } ?>
	})

	
	
	$("#Invoice_deptto").change(function(){
		var extvalue = $('#Invoice_deptto').val();
		if(extvalue == "" ){
		$('#idextname').show();
		}else{
		$('#idextname').hide();
		}
	})

	
	
})
</script>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
)); ?>
  <fieldset class="inlineLabels">
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model, $loc_model)); ?>
        <?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
        <?php endif; ?>
        <?php if($model->isNewRecord){?>
        <?php
            if(isset($_GET['department'])){
            $model->idlocation = $_GET['department'];
            }
        ?>
        <!--------------------Changes by Sprymohit, 23-05-2014--------------------->
        <div class="ctrlHolder">
                <label class="required" for="Invoice_idlocation"> Dept From<span class="required"> *</span></label>
		<?php //echo $form->labelEx($model,'idlocation'); ?>
		<?php echo $form->dropdownlist($model,'idlocation', 
			(Yii::app()->user->id == '1')? ComSpry::getLocationsdeptfrom():ComSpry::getLocDepts(),
                    array('style'=>"width:150px;")); ?>
		<?php echo $form->error($model,'idlocation'); ?>
	</div>
        <div class="ctrlHolder">
                <?php echo $form->labelEx($model,'deptto'); ?>
		<?php echo $form->dropdownlist($model,'deptto', ComSpry::getLocations(),array('style'=>"width:150px;", 'empty' => '')); ?>
		<?php echo $form->error($model,'deptto'); ?>
	</div> 
        <!--------------------Changes by Sprymohit, 23-05-2014--------------------->
	
        <div class="ctrlHolder">
                <label for="Invoice_SKU Codes" >Sku Code</label>
              
         <?php
         $dept = Dept::model()->find('iddept='.User::model()->findByPk(Yii::app()->user->id)->iddept);  
         $user_dept=$dept->iddept;
                    $this->widget('ext.multicomplete.MultiComplete', array(
                    'name'=>'Skus',
                    'source'=>ComSpry::getSkus1(isset($_GET['department'])?$_GET['department']:$user_dept),
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                    'delay'=>300,
                    'minLength'=>2,
                    ),

                    'htmlOptions'=>array(
                    'style'=>'height:20px;'
                    ),
         ));?>
	
                 <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated, fill when po not included</p>
        </div>
		</span>
<!--        <div class="ctrlHolder">
                <label for="Invoice_SKU Codes" >Sku Code</label>		
                <input type="text" value="" name="Skus" id="Skus">            
                <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated, fill when po not included</p>
        </div>-->
         <?php }else{?>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idlocation'); ?>
		<?php echo $form->dropdownlist($model,'idlocation',  ComSpry::getLocationsdeptfrom(),array('style'=>"width:150px;", 'disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'idlocation'); ?>
	</div>
         <div class="ctrlHolder">
                <?php echo $form->labelEx($model,'deptto'); ?>
		<?php echo $form->dropdownlist($model,'deptto', ComSpry::getLocations(),array('style'=>"width:150px;", 'disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'deptto'); ?>
	</div> 
        <div class="ctrlHolder">
                <label for="Invoice_SKU Codes" >Sku Code</label>		
                <input type="text" value="<?php if(isset($skus)){echo $skus;} ?>" name="Skus" id="Skus" disabled='disabled'>            
                <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated, fill when po not included</p>
        </div>
        <?php } ?>

    

<!--        <div class="ctrlHolder">
		<?php //echo $form->labelEx($model,'createdby'); ?>
		<?php //echo $form->textField($model,'createdby'); ?>
		<?php //echo $form->error($model,'createdby'); ?>
	</div>-->

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idpo'); ?>
		<?php echo $form->textField($model,'idpo'); ?>
		<?php echo $form->error($model,'idpo'); ?>
	</div>

        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'activ'); ?>
		<?php echo $form->dropdownlist($model,'activ',array(1=>'Yes',0=>'No')); ?>
		<?php echo $form->error($model,'activ'); ?>
	</div>
        <div class="ctrlHolder" id = 'idextname' >
		<?php echo $form->labelEx($model,'extname'); ?>
		<?php echo $form->textField($model,'extname'); ?>
		<?php echo $form->error($model,'extname'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'dcountry'); ?>
		<?php echo $form->textField($loc_model,'dcountry'); ?>
		<?php echo $form->error($loc_model,'dcountry'); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'dstreet'); ?>
		<?php echo $form->textField($loc_model,'dstreet'); ?>
		<?php echo $form->error($loc_model,'dstreet'); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'dpincode'); ?>
		<?php echo $form->textField($loc_model,'dpincode'); ?>
		<?php echo $form->error($loc_model,'dpincode'); ?>
	</div>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'dperson'); ?>
		<?php echo $form->textField($loc_model,'dperson'); ?>
		<?php echo $form->error($loc_model,'dperson'); ?>
	</div>
        
        <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'dphone'); ?>
		<?php echo $form->textField($loc_model,'dphone'); ?>
		<?php echo $form->error($loc_model,'dphone'); ?>
	</div>
        
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'scountry'); ?>
		<?php echo $form->textField($loc_model,'scountry'); ?>
		<?php echo $form->error($loc_model,'scountry'); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'sstreet'); ?>
		<?php echo $form->textField($loc_model,'sstreet'); ?>
		<?php echo $form->error($loc_model,'sstreet'); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'spincode'); ?>
		<?php echo $form->textField($loc_model,'spincode'); ?>
		<?php echo $form->error($loc_model,'spincode'); ?>
	</div>
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'sperson'); ?>
		<?php echo $form->textField($loc_model,'sperson'); ?>
		<?php echo $form->error($loc_model,'sperson'); ?>
	</div>
        
         <div class="ctrlHolder">
		<?php echo $form->labelEx($loc_model,'sphone'); ?>
		<?php echo $form->textField($loc_model,'sphone'); ?>
		<?php echo $form->error($loc_model,'sphone'); ?>
	</div>
        
   <!--     

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'mdate'); ?>
		<?php echo $form->textField($model,'mdate'); ?>
		<?php echo $form->error($model,'mdate'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'updby'); ?>
		<?php echo $form->textField($model,'updby'); ?>
		<?php echo $form->error($model,'updby'); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'activ'); ?>
		<?php echo $form->textField($model,'activ'); ?>
		<?php echo $form->error($model,'activ'); ?>
	</div>-->

	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php 
if($model->isNewRecord){
?>
<fieldset class="inlineLabels">
    <div id="message" style="display:none;"></div>
<?php 
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sku-grid',
	'dataProvider'=>$skus->search(),
	'filter'=>$skus,
        'selectableRows' => 2, 
        'pager'=>array(
            'class'=>'LinkListPager', 
             //'pageSize'=>10,

            ),
	'columns'=>array(
                'idsku',
		'skucode',
        array('type'=>'raw','value'=>'$data->metals[0]->namevar','name'=>'sku_metals',),
		'grosswt',
		array('name'=>'sku_size','type'=>'raw','value'=>'$data->skucontent->size'),
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'refpo',
		'totmetalwei',
		'totstowei',
		'numstones',
               
            
           
	),
   
)); ?>
</fieldset>
<?php
}

?>
