<?php
$this->breadcrumbs=array(
	'Reports'=>array('stoneStockDetail'),
	'Stone Stock Detail',
);
?>
<div class="pageTitle">
<h3>Stone Stock Details</h3>
<?php
$tabs=array();
$tabs['Select Department']=$this->renderPartial("_form", array("model"=>$model,"type"=>$type), true);

?>

        <?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>

<div class="listtab">

<?php 
if($dataProvider){
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'loginreport-grid',
        'pager'=>array(
            'class'=>'LinkListPager', 
            ), 
	'dataProvider'=>$dataProvider,
        'columns'=>array(
//            array( 'name' => '',
//                   'type' => 'raw',
//                   'value' => 'CHtml::link("Stone Ledger",array("reports/stoneStockLedger","id"=>$data["id"]))',
//                ),
//		
                     
              array( 'header' => 'Stone Name',
                   'type' => 'raw','name'=>'stonename',
                   'value' => '$data["stonename"]',
              ),
            /* Manish Changes on Oct-11 add shape and size field ----start--- */
            array( 'header' => 'Shape',
                   'type' => 'raw','name'=>'shape',
                   'value' => '$data["shape"]',
                ),
              array( 'header' => 'Size',
                   'type' => 'raw','name'=>'size',
                   'value' => '$data["size"]',
                ),
             /* Manish Changes add shape and size field ----end--- */
            array( 'header' => 'Total Receipt PCs',
                   'type' => 'raw',
                   'value' => 'abs($data["receiptquantity"])',
                ),
              array( 'header' => 'Total Receipt weight',
                   'type' => 'raw',
                   'value' => 'abs($data["rweight"])',
                ),
            array( 'header' => 'Total Issued PCs',
                   'type' => 'raw',
                   'value' => 'abs($data["issuequantity"])',
                ),
              array( 'header' => 'Total Issued weight',
                   'type' => 'raw',
                   'value' => 'abs($data["iweight"])',
                ),
//             array( 'header' => 'Total Issued PCs',
//                   'type' => 'raw',
//                   'value' => '$data["negquantity"]',
//                ),
            array( 'header' => 'Grade',
                   'type' => 'raw','name'=>'grade',
                   'value' => '$data["grade"]',
                ),
            array( 'header' => 'Balance Weight',
                   'type' => 'raw',
                   'value' => array($this,'balanceWtDetails'),
                ),
             array( 'header' => 'Balance Quantity',
                   'type' => 'raw',
                   'value' => 'abs($data["balqty"])',
                ),
          
        
           
))); }?>

</div>
</div>