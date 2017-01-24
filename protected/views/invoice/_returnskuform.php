<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'returninvoice-skuform',
	'enableAjaxValidation'=>false,
)); ?>
  <fieldset class="inlineLabels">
       <?php if(Yii::app()->user->hasFlash('fail')):?>
            <div style="color:#C20F2E;margin:20px;">
                <?php echo Yii::app()->user->getFlash('fail'); ?>
            </div>
        <?php endif; ?>
      
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'returninvoicesku-grid',
	'dataProvider'=>$poskus,
        'selectableRows'=>2,
	'columns'=>array(
                
               array(
                    'name'=>'ID SKU',
                    'value'=>'$data->idsku'
                ),
                array(
                    'name'=>'SKU #',
                    'value'=>'$data->idsku0->skucode'
                ),
                
               array(            
                    'header'=>'Total Qty',
                    'type'=>'raw', 
                    //'value'=>array($this,'gridSkuStocks'), 
                    'value'=>'$data->skuStocks', 
                ),
                array(
                        'header'=>'Shipped Qty',
                        'type'=>'raw',
                        'value'=>'$data->idinvoicespokus0->shipqty',
                    ),
                array(
                        'name'=>'Returned Qty',
                        'type'=>'raw',
                        'value'=>'CHtml::textField("returninvoice[$data->idinvoicereturn]","$data->returnqty",array("style"=>"width:50px;"))',
                        'htmlOptions'=>array("width"=>"50px"),
                    ),
                
	),
)); ?>
        
        <?php echo(CHtml::hiddenField('empty','true'));?>
        <div class="buttonHolder">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->