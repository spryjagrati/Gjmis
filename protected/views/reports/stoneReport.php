<?php
$this->breadcrumbs=array(
	'Reports'=>array('stoneReport'),
	'Dept Stone Report',
);
?>
<h1>Stone Report</h1>
<?php
$tabs=array();
$tabs['Select Department']=$this->renderPartial("_form", array("model"=>$model,"type"=>$type), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>
<?php ?>

<?php 
if($data){
Yii::import('ext.LinkListPager.LinkListPager');
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonereport-grid',
        'selectableRows' => 2,
		 'pager'=>array(
            'class'=>'LinkListPager', 
            ),
	'dataProvider'=>$data,
        
    //'summaryText'=>'',
    //material request columns
	'columns'=>array(
            'idstone',
            'stone',
            'shape',
            'quality',
            'size',
            'stonewt',
            'qty',
            array('name'=>'rqty','header'=>'Requested Qty'),
	),
)); ?>
<?php
}
?>