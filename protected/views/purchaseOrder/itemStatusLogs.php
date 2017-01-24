<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'itemStatusLogsDialog',
                'options'=>array(
                    'title'=>'Item Status Logs',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'1000px',
                    'height'=>'auto',
                    //'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('purchaseOrder/process/'.$model->idpo).'";}',
                    //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
                ),
                ));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'poskustatuslog-grid',
	'dataProvider'=>new CActiveDataProvider('Poskustatuslog', array(
                'criteria'=>array(
                'condition'=>'idposku='.$model->idposkus,
                'order'=>'mdate desc',
            ),
            'pagination'=>array(
                'pageSize'=>20,
            ),
        )),
	'columns'=>array(
		array('name'=>'idposkustatuslog','header'=>'id'),
		//'idposku',
		array('name'=>'idstatusm','type'=>'raw','value'=>'$data->idstatusm0->name'),
                'reqdqty',
		'processqty',
		'delqty',
		array('name'=>'Dept','value'=>'($data->idprocdept)?$data->idprocdept0->locname:""'),
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'descrip',
                'remark',
		/*
		'cdate',
		'rcvddate',
		'dlvddate',
                */
	),
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
