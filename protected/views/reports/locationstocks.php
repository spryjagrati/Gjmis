<?php
$this->breadcrumbs=array(
	'Reports'=>array('skuReport'),
	'Dept Sku Report',
);
?>
<h1>Sku Report</h1>
<?php

$tabs=array();
$tabs['Select Department']=$this->renderPartial("_form", array("model"=>$model), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.excel').click(function(){
        var checked = $('input[name=\"ids[]\"]:checked').length > 0;
    if (!checked)
        {       
        alert('Please select atleast one SKU to export');
        }else{
            document.getElementById('checked-export').action='excel';
            document.getElementById('checked-export').submit();
        }
       
});
$('.excelall').click(function(){
     
            document.getElementById('checked-export').action='excelall';
            document.getElementById('checked-export').submit();
       
       
});");


?>
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
        'id'=>'checked-export',
        'enableAjaxValidation'=>false,'layoutName'=>'qtip',
        'htmlOptions'=>array('enctype' => 'multipart/form-data')
));
?>
<?php  if(($dataProvider)){ ?>
<div class="uniForm">
<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'location-form',
	'enableAjaxValidation'=>false,
)); ?>
<fieldset class="inlineLabels">

<?php 

Yii::import('ext.LinkListPager.LinkListPager');

$this->widget('zii.widgets.grid.CGridView', array(

   'id'=>'skureport-grid',
   'dataProvider'=>$dataProvider,
    //'summaryText'=>'',
    //material request columns
    'filter'=>$model,
    'selectableRows' => 2,
    'pager'=>array(
            'class'=>'LinkListPager', 
        ),
        'columns'=>array(
            //array('header'=>'S. No','value'=>'++$row','name' => 'idskus'),
            array('name'=>'idsku','header'=>'Sku#','value'=>'$data->idsku0->skucode'),
            array('name'=>'po_num','header'=>'PO#'),
            array('name'=>'totqty','header'=>'Total Qty','value'=>'$data->totqty'),
            array('header'=>'Total Wt','value'=>'number_format(($data->totwt), 2, ".", "")'),
            array('header'=>'Total Stone Wt','value'=>'number_format(($data->totstone), 2, ".", "")'),
            array('header'=>'Total Metal Wt','value'=>'number_format(($data->totmetwt), 2, ".", "")'),
            array('name'=> 'qtyship','header'=>'Shipped Qty','value'=>'$data->qtyship'),
            array('header'=>'Balance Qty','value'=>'($data->totqty - $data->qtyship)','type'=>'raw'),
           // array('name'=> 'qtyrecieved','header'=>'Recieved Qty','value'=>'$data->qtyrecieved'),
            array('name'=> 'locref','header'=>'Location Ref.','value'=>'CHtml::textField("data[$data->idlocationstocks][locref]",$data->locref,array("style"=>"width:50px;"))', 'type'=>'raw','htmlOptions'=>array("width"=>"50px"),),
            array('name'=> 'currency','header'=>'Currency','value'=>'CHtml::dropdownlist("data[$data->idlocationstocks][currency]",$data->currency,ComSpry::getCurrency(),array("style"=>"width:50px;"))', 'type'=>'raw','htmlOptions'=>array("width"=>"50px"),),
            array('name'=> 'pricepp','header'=>'Price PP','value'=>'CHtml::textField("data[$data->idlocationstocks][pricepp]",($data->pricepp=="0.00")?"":$data->pricepp,array("style"=>"width:50px;"))', 'type'=>'raw', 'htmlOptions'=>array("width"=>"50px"),),
            array('name'=> 'lupdated','header'=>'Last Updated'),
            array('class'=>'CCheckBoxColumn',
                'header'=>'CHEK',
                'value'=>'$data->idlocationstocks',
                'checkBoxHtmlOptions' => array(
                'name' => 'ids[]'),           

                ),

            ))); 

?>
        <div class="buttonHolder">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Submit',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>

            <?php echo CHtml::button('Export',array('name'=>'excel','class'=>'excel','style'=>'float:left')); ?>

            <?php echo CHtml::button('ExportAll',array('submit'=>array('reports/excelAll', 'iddept'=>$dept),'class'=>'excelall','style'=>'float:left')); ?>
        </div>

</fieldset>

<?php $this->endWidget(); ?>
<?php
}?><?php $this->endWidget(); ?>
</div>
