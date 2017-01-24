<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'invoice-skuform',
	'enableAjaxValidation'=>false,
));  ?>
  <fieldset class="inlineLabels">
       <?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
        <?php endif; ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoicesku-grid',
	'dataProvider'=>$po_data,
        'selectableRows'=>2,
	'columns'=>array(
                
               array(
                    'name'=>'SKU #',
                    'value'=>'$data->idsku0->skucode'
                ),
                 array(
                    'header'=>'Dept',
                    'value'=>'isset($model->deptto)?"From":""'
                ),
                array(
                    'name'=>'Location #',
                    'value'=>'isset($data->iddept0->idlocation0->name)?$data->iddept0->idlocation0->name:"not set"'
                ),
                array(
                        'name'=>'Available Qty',
                        'value'=>'$data->totqty - $data->qtyship'
                    ),
                array(
                        'name'=>'locref',
                        'header'=>'Location Ref.',
                        'type'=>'raw',
                        'value'=>'$data->locref',
                    ),
            
                array(
                        'name'=>'Unit Net Price Incl Vat',
                        'type'=>'raw',
                        'value'=>'$data->pricepp',
                    ),
            
            
                array(
                        'name'=>'Qty to be shipped',
                        'type'=>'raw',
                        'value'=>'CHtml::textField("shipped[$data->idlocationstocks]",ComSpry::getShipqty('.$model->idinvoice.',$data->idsku,$data->po_num),array("style"=>"width:50px;"))',
                        'htmlOptions'=>array("width"=>"50px"),
                    ),
                array(
                        'name'=>'idsku',
                         'type'=>'raw',
                        'value'=>'CHtml::textField("idsku",$data->idsku,array("style"=>"width:50px;"))',
                        'visible'=>false
                )
	),
)); ?>
      
      
        <div class="ctrlHolder">
		<label for="ship">Ship</label>
		<?php echo(CHtml::dropDownList('ship', $model->ship, array(0=>'False',1=>'True')));?>
	</div>
        <?php echo(CHtml::hiddenField('empty','true'));?>
        <div class="buttonHolder">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->