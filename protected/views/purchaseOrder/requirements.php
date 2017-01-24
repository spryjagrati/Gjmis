<?php
$this->breadcrumbs=array(
	'po'=>array('admin'),
	'Requirements',
);

$this->menu=array(
	array('label'=>'Manage POs', 'url'=>array('purchaseOrder/admin')),
    ($modelpo->idstatusm0->name=='Registered')?array('label'=>'Maintain PO', 'url'=>array('purchaseOrder/maintain','id'=>$modelpo->idpo)):array('label'=>''),
    array('label'=>'Process PO', 'url'=>array('purchaseOrder/process','id'=>$modelpo->idpo)),
);
?>
<h1>Requirements for Purchase Order #<?php echo $modelpo->idpo; ?></h1>
<h4>Newly added requests would not be update-able right away after creation, please revisit the page to update thru the links provided in list.</h4>

<?php
$tabs=array();
$tabs['Raise Metal Request']=$this->renderPartial("_form_request_metal", array("model"=>$modelrequestmetal), true);
$tabs['Raise Stone Request']=$this->renderPartial("_form_request_stone", array("model"=>$modelrequeststone), true);
$tabs['Raise Chemical Request']=$this->renderPartial("_form_request_chem", array("model"=>$modelrequestchem), true);
$tabs['Raise Finding Request']=$this->renderPartial("_form_request_find", array("model"=>$modelrequestfind), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
        'selected'=>-1,
        //'ajaxOptions'=>array('async'=>true),
        //'idPrefix'=>'ui-tabs-',
    ),
));
?>
<h2> PO Requirements </h2>
<!--list metal, stone and findings requirements.-->
<h4> Metal Requirements </h4>
<?php $metsql='select m.idmetal idmetal, m.namevar metal, ms.purity purity, sum(sm.weight*ps.qty) weight
    from tbl_po po, tbl_poskus ps, tbl_metal m, tbl_metalstamp ms, tbl_sku s, tbl_skumetals sm
where m.idmetal=sm.idmetal and m.idmetalstamp=ms.idmetalstamp
and po.idpo=ps.idpo and ps.idsku=s.idsku and s.idsku=sm.idsku and po.idpo='.$modelpo->idpo.' group by m.idmetal';

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metrequirement-grid',
	'dataProvider'=>new CSqlDataProvider($metsql, array(
            'keyField'=>'idmetal',
        )),
    'summaryText'=>'',
    //material request columns
	'columns'=>array(
            'idmetal',
            'metal',
            'purity',
            'weight',
		//'qunit',
	),
)); ?>
<h4> Stone Requirements </h4>
<?php $stosql='select st.idstone idstone, st.namevar stone,ss.height height, ss.diasize diasize, ss.sievesize sievesize, ss.mmsize mmsize, sz.size size, sh.name shape, st.quality quality, sc.name clarity, sum(ps.qty*ss.pieces) nos
from tbl_po po, tbl_poskus ps, tbl_stone st, tbl_stonesize sz, tbl_sku s, tbl_skustones ss, tbl_shape sh, tbl_clarity sc
where st.idstone=ss.idstone and st.idshape=sh.idshape and st.idstonesize=sz.idstonesize and st.idclarity=sc.idclarity and po.idpo=ps.idpo
and ps.idsku=s.idsku and s.idsku=ss.idsku and po.idpo='.$modelpo->idpo.' group by st.idstone';

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'storequirement-grid',
	'dataProvider'=>new CSqlDataProvider($stosql, array(
            'keyField'=>'idstone',
        )),
    'summaryText'=>'',
    //material request columns
	'columns'=>array(
            'idstone',
            'stone',
            'shape',
            'height',
            'mmsize',
            'diasize',
            'sievesize',
            'quality',
            'clarity',
            'size',
            'nos',
		//'qunit',
	),
)); ?>
<h4> Finding Requirements </h4>
<?php $metsql='select f.idfinding idfind, sf.name name, m.namevar metal, f.name code, sum(ps.qty*sf.qty) qty
from tbl_po po, tbl_poskus ps, tbl_finding f, tbl_metal m, tbl_sku s, tbl_skufindings sf
where po.idpo=ps.idpo and ps.idsku=s.idsku and s.idsku=sf.idsku and f.idfinding=sf.idfinding and f.idmetal=m.idmetal
and po.idpo='.$modelpo->idpo.' group by f.idfinding';

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metrequirement-grid',
	'dataProvider'=>new CSqlDataProvider($metsql, array(
            'keyField'=>'idfind',
            'totalItemCount'=>'All',
        )),
    'summaryText'=>'',
    //material request columns
	'columns'=>array(
            'idfind',
            'name',
            'metal',
            'code',
            'qty',
		//'qunit',
	),
)); ?>

<h4> PO Requests </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'matreq-grid',
	'dataProvider'=>new CActiveDataProvider('Matreq', array(
                'criteria'=>array(
                'condition'=>'idpo='.$modelpo->idpo,
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        )),
    //material request columns
	'columns'=>array(
		array('name'=>'idmatreq','header'=>'Id'),
		'type',
            array('name'=>'idmetal','header'=>'Metal','type'=>'raw','value'=>'($data->idmetal0)?$data->idmetal0->namevar:NULL'),
            array('name'=>'idstone','header'=>'Stone','type'=>'raw','value'=>'($data->idstone0)?$data->idstone0->namevar:NULL'),
            array('name'=>'idchemical','header'=>'Chemical','type'=>'raw','value'=>'($data->idchemical0)?$data->idchemical0->name:NULL'),
            array('name'=>'idfinding','header'=>'Finding','type'=>'raw','value'=>'($data->idfinding0)?$data->idfinding0->name:NULL'),
            array('name'=>'idstatusm','header'=>'Status','type'=>'raw','value'=>'($data->idstatusm0)?$data->idstatusm0->name:NULL'),
		//'cdate',
		'mdate',
            array('name'=>'sdate','value'=>'date("d-M-Y",strtotime($data->sdate))'),
		//'edate',
            array('name'=>'estdate','value'=>'date("d-M-Y",strtotime($data->estdate))'),
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
            array('name'=>'reqby','type'=>'raw','value'=>'$data->reqby0->locname'),
            array('name'=>'reqto','type'=>'raw','value'=>'$data->reqto0->locname'),
		//'notes',
		'rqty',
		'fqty',
		//'qunit',
            array('type'=>'raw',
                'value'=>'($data->idstatusm0->name!=="Fulfilled")?CHtml::ajaxLink("fulfill",Yii::app()->createUrl("purchaseOrder/updateRequest",array("id"=>$data->idmatreq)),array(
                    "onclick"=>"$(\"#updateRequest\").dialog(\"open\"); return false;",
                    "update"=>"#updateRequest",
            )):(CHtml::encode("fullfilled"))'),
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("purchaseOrder/deleteRequest",array("id"=>$data->idmatreq))',
                            'visible'=>'$data->idstatusm0->name!=="Fulfilled"',
                        )
                    )
		),
	),
)); ?>

<div id="updateRequest"></div>
<br>