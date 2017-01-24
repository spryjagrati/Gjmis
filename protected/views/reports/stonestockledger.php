
<?php
$this->breadcrumbs=array(
	'Reports'=>array('stoneStockLedger'),
	'Stone Stock Ledger',
);
?>
<div class="pageTitle">
<h3>Stone Stock Ledger</h3>
<?php
$tabs=array();
$tabs['Select Stone']=$this->renderPartial("_form", array("type" => $type,"idshape"=>$idshape,"idstonesize"=>$idstonesize,"idstonem"=>$idstonem, "iddept"=>$iddept), true);
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

<?php { $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonestockledger-grid',
	'dataProvider'=>$dataProvider,
        'columns'=>array(
//            array( 'name' => '',
//                   'type' => 'raw',
//                   'value' => 'CHtml::link("View",array("reports/stoneStockDetail","id"=>$data["id"]))',
//                ),
             array( 'header' => 'Received From Dept.',
               'type' => 'raw',
               'value' => '($data["refrcvd"] !== Null )?Dept::model()->findByPk($data["refrcvd"])->name."-".Dept::model()->findByPk($data["refrcvd"])->location:""',
             ), 
            array( 'header' => 'Received Date',
               'type' => 'raw',
               'value' => '($data["refrcvd"] !== Null || (($data["refrcvd"] == Null) && ($data["refsent"] == Null)))?$data["mdate"]:""',
             ),
            array( 'header' => 'Received Wt',
                   'type' => 'raw',
                   'value' => '($data["refrcvd"] !== Null || (($data["refrcvd"] == Null) && ($data["refsent"] == Null)))?$data["stonewt"]:""',
               ),
             array( 'header' => 'Received Qty',
                   'type' => 'raw',
                   'value' => '($data["refrcvd"] !== Null || (($data["refrcvd"] == Null) && ($data["refsent"] == Null)))?$data["qty"]:""',
               ),
            
              array( 'header' => 'Issue to Dept.',
                   'type' => 'raw',
                   'value' => '($data["refsent"] !== Null )?Dept::model()->findByPk($data["refsent"])->name."-".Dept::model()->findByPk($data["refsent"])->location:""',
              ),
             array( 'header' => 'Issued Date',
                   'type' => 'raw',
                   'value' => '($data["refsent"] !== Null)? $data["mdate"]: ""',
                ),
            
              array( 'header' => 'Issued Wt',
                   'type' => 'raw',
                   'value' => '($data["refsent"] !== Null)? $data["stonewt"]:""',
                ),
             array( 'header' => 'Issued Qty',
                   'type' => 'raw',
                   'value' => '($data["refsent"] !== Null)? abs($data["qty"]):""',
                ),
            array( 'header' => 'Balance Wt',
                   'type' => 'raw',
                   'value' => array($this,'balanceWt'),
                ),
            array( 'header' => 'Balance Qty',
                   'type' => 'raw',
                   'value' => array($this,'balanceQty'),
                ),
        
           
))); } ?>

</div>
