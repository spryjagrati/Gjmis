<?php
$this->breadcrumbs=array(
	'Reports'=>array('stoneStockReport'),
	'Stone Stock Report',
);
?>
<h1>Stone Stock Report</h1>
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
if($dataProvider){
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonereport-grid',
        'selectableRows' => 1,
          'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'dataProvider'=>$dataProvider,
        //'filter'=>$model,
    
    'columns'=>array(
//        array('name' => '',
//            'type' => 'raw',
//            'value' => 'CHtml::link("Summary",array("reports/stoneSummary","id"=>"$data[stoneid]"))',
//            'htmlOptions' => array('style' => 'width:8%;')),
            //'summaryText'=>'',
            array( 'header' => 'S. No',
                   'type' => 'raw',
                   'value' => '++$row',
               ),
            array( 'header' => 'Id Stone',
                   'type' => 'raw',
                   'value' => '$data["stoneid"]',
               ),
            array( 'header' => 'Stone',
                   'type' => 'raw','name'=>'stonename',
               ),'shape','size','weight',
            
           array( 'header' => 'Quantity',
                   'type' => 'raw',
                   'value' => '$data["quantity"]',
               ),
            
            
	),
)); }?>
