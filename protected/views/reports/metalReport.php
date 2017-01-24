<?php
$this->breadcrumbs=array(
	'Reports'=>array('metalReport'),
	'Dept Metal Report',
);
?>
<h1>Metal Report</h1>
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
<?php if(isset($model->iddept)&&$model->iddept!==''){ ?>
<?php $metsql='select dml.idmetal, mm.name metal, ms.name stamp, dml.qty, mr.rqty rqty from
(select idmetal, iddept, sum(qty) qty from tbl_deptmetallog group by idmetal, iddept) dml
left join (select idmetal idm, reqby, sum(rqty) rqty from tbl_matreq where idstatusm='.ComSpry::getDefReqStatusm().' group by idm) mr on mr.reqby=dml.iddept and mr.idm=dml.idmetal,
tbl_metal m, tbl_metalm mm, tbl_metalstamp ms
where dml.idmetal=m.idmetal and m.idmetalstamp=ms.idmetalstamp and m.idmetalm=mm.idmetalm and dml.iddept='.$model->iddept.' group by dml.idmetal';
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metalreport-grid',
	'dataProvider'=>new CSqlDataProvider($metsql, array(
            'keyField'=>'idmetal',
            'sort'=>array(
                'attributes'=>array(
                    'metal','stamp',
                ),
            ),
        )),
    //'summaryText'=>'',
    //material request columns
	'columns'=>array(
            'idmetal',
            'metal',
            'stamp',
            'qty',
            array('name'=>'rqty','header'=>'Requested Qty'),
	),
)); ?>
<?php
}?>