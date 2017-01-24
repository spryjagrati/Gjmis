<style>
    .item-class .odd{
        background-color: #d3e8eb;
    }
    .listtab{
        width:500px;
    }
</style>
<?php
$this->breadcrumbs=array(
	'Reports'=>array('stoneStockReport'),
	'Stone Stock Report',
);
?>
<div class="pageTitle">
<h3>Stone Stock Summary</h3>

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

<?php 
//$tabs = array();
//$tabs['Select Stones']= this->renderPartial("_form", array("model"=>$model,"type"=>$type), true);
//echo CHtml::listData(reports::model()->findAll(), 'state_id', 'state_name');
?>
<div class="listtab">

<?php 
if($dataProvider){
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'loginreport-grid',
        'selectableRows' => 2,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'dataProvider'=>$dataProvider,
        'columns'=>array(
//            array( 'name' => '',
//                   'type' => 'raw',
//                   'value' => 'CHtml::link("View",array("reports/stoneStockDetail","id"=>$data["id"]))',
//                ),
		
            array( 'header' => 'Stone',
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
              array( 'header' => 'Weight',
                   'type' => 'raw','name'=>'weight',
                   'value' => 'abs($data["weight"])',
                ),
             array( 'header' => 'Pcs',
                   'type' => 'raw',
                   'value' => 'abs($data["quantity"])',
                ),
        
           
)));} ?>

</div>