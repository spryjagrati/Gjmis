<?php
$this->breadcrumbs=array(
	'Reports'=>array('skuReport'),
	'Dept Sku Report',
);
?>
<h1>Sku Report</h1>
<?php
$tabs=array();
$tabs['Select Department']=$this->renderPartial("_form", array("model"=>$model,"type"=>$type), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
    ),
));
Yii::app()->clientScript->registerScript('search', "
$('.export').click(function(){
        var checked = $('input[name=\"ids[]\"]:checked').length > 0;
        
    if (!checked)
        {       
        alert('Please select atleast one Sku to export');
        }else{
             
            document.getElementById('checked-export').action='locationStockLedgerExport';
            document.getElementById('checked-export').submit();
        }
       
});
$('.checkbox-column input:checkbox').click(function(){
    
    selected_sku = new Array();
    
    $('input:checkbox[name=\"ids[]\"]:checked').each(function()
       {
           selected_sku.push($(this).val());
       });
//alert(selected_sku);
       $.ajax({
       'type':'post',
       'url':'locationStockLedger',
       'data':{selected_sku:selected_sku},
    });
                
            
       
});");
?>
<?php 
 $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
        'id'=>'checked-export',
        'enableAjaxValidation'=>false,'layoutName'=>'qtip',
        'htmlOptions'=>array('enctype' => 'multipart/form-data')
));


?>

<?php 

if(isset($dataProvider) && $dataProvider){
   
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skureport-grid',
        'afterAjaxUpdate' => 'js',
	'dataProvider'=>$dataProvider,
    //'summaryText'=>'',
    //material request columns
	'columns'=>array(
            array('name'=>'skucode','header'=>'Sku #','value'=>'$data["skucode"]'),
            array('header'=>'metal_type','value'=>'$data["metal_type"]'),
            //array('header'=>'size','value'=>'$data["size"]'),
            array('header'=>'tot_qty','value'=>'$data["totqty"]'),
            array('header'=>'shipp_qty','value'=>'$data["sipqty"]'),
            array('header'=>'bal_qty','value'=>'($data["totqty"] + $data["sipqty"])'),
            array('header'=>'pricepp','value'=>'number_format((float)$data["pricepp"],2)'),
            array('header'=>'amount','value'=>'($data["totqty"] + $data["sipqty"]) * number_format((float)$data["pricepp"],2)'),
            array('class'=>'CCheckBoxColumn',
                        'selectableRows' => '2',
                        //'header'=>'CHEK',
                        'value'=>'$data["iddeptskulog"]',
                        'checked'=>'Sku::model()->getChecked_admin($data["iddeptskulog"]);', 
                        'checkBoxHtmlOptions' => array(
                        'name' => 'ids[]'),
                ),
	),
)); ?>
<div class="buttonHolder" style="float:right;">
        <?php echo CHtml::button('Export',array('name'=>'export','class'=>'export')); ?>
</div>
<?php 
    

}
?>
<?php $this->endWidget(); 
Yii::app()->clientScript->registerScript('search2', "
    function js(){
$('.export').click(function(){
        var checked = $('input[name=\"ids[]\"]:checked').length > 0;
        
    if (!checked)
        {       
        alert('Please select atleast one Sku to export');
        }else{
             
            document.getElementById('checked-export').action='locationStockLedgerExport';
            document.getElementById('checked-export').submit();
        }
       
});
$('.checkbox-column input:checkbox').click(function(){
    
    selected_sku = new Array();
    
    $('input:checkbox[name=\"ids[]\"]:checked').each(function()
       {
           selected_sku.push($(this).val());
       });
//alert(selected_sku);
       $.ajax({
       'type':'post',
       'url':'locationStockLedger',
       'data':{selected_sku:selected_sku},
    });
                
            
       
});
}");


?>
