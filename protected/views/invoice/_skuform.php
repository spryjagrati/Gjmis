<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'invoice-skuform',
	'enableAjaxValidation'=>false,
)); //print_r(in_array(1, $activinposkus));die();?>
  <fieldset class="inlineLabels">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoicesku-grid',
	'dataProvider'=>$po_data,
        'selectableRows'=>2,
	'columns'=>array(
                array(
                    'class'=>'CCheckBoxColumn',
                    'id'=>'rows_to_add',
                    'value'=>'$data->idposkus',
                    'checked'=>'($data->activ == 1)?"checked":"";'
                ),
                array(
                    'name'=>'IdSku',
                    'value'=>'$data->idsku0->idsku'
                ),
                array(
                    'name'=>'Sku Code',
                    'value'=>'$data->idsku0->skucode'
                ),
                array(
                    'name'=>'shipqty',
                    'value'=>'$data->shipqty'
                ),
                array(
                    'name'=>'totprice',
                    'value'=>'$data->totprice'
                ),
//                array(
//                        'name'=>'Total Amount',
//                        'value'=>'$data->idposkus0->totamt'
//                    ),
//                
//            
//                array(
//                        'name'=>'Ref No',
//                        'value'=>'$data->idposkus0->refno'
//                    ),
	),
)); ?>
        
        <?php echo(CHtml::hiddenField('empty','true'));?>
        <div class="buttonHolder">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->