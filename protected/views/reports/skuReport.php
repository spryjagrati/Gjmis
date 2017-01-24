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
        alert('Please select atleast one DEPT to export');
        }else{
             
            document.getElementById('checked-export').action='deptSkuExport';
            document.getElementById('checked-export').submit();
        }
       
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
if($dataProvider){
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'skureport-grid',
	'dataProvider'=>$model->search(),
    //'summaryText'=>'',
    //material request columns
	'columns'=>array(
            array('name'=>'skucode','header'=>'Sku #','value'=>'$data->idsku0->skucode'),
            array('name'=>'po_num','header'=>'PO #', 'value'=>'$data["po_num"]'),
            array('name'=>'qty','header'=>'Qty','value'=>'$data["qty"]'),
            array('header'=>'Stone Pricepp','value'=>'$data->idsku0->stones[0]->curcost'),
            array('header'=>'Pricepp','value'=>'ComSpry::calcSkuCost($data->idsku)'),
            array('header'=>'Total Weight','value'=>'number_format(($data->idsku0->grosswt *$data->qty), 2, ".", "")'),
            array('header'=>'Total Stone','value'=>'number_format(($data->idsku0->totstowei *$data->qty), 2, ".", "")'),
            array('header'=>'Total Metal','value'=>'number_format(($data->idsku0->totmetalwei * $data->qty), 2, ".", "")'),
            array('name'=> 'mdate','header'=>'Date', 'value'=>'$data->mdate'),
            array('name'=> 'refrcvd','header'=>'Ref. Received by', 'value'=>'Dept::getDeptname($data->refrcvd)'),
            array('name'=> 'refsent','header'=>'Ref. Sent to','value'=>'Dept::getDeptname($data->refsent)'),
            array('class'=>'CCheckBoxColumn',
                        'selectableRows' => '2',
                        //'header'=>'CHEK',
                        'value'=>'$data->iddeptskulog',
                        
                        'checkBoxHtmlOptions' => array(
                        'name' => 'ids[]'),
                ),
            
	),
)); 
?>
<div class="buttonHolder" style="float:right;">
        <?php echo CHtml::button('Export',array('name'=>'export','class'=>'export')); ?>
</div>
<?php }

?>
<?php $this->endWidget(); ?>