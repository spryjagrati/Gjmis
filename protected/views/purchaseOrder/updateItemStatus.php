<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'updateItemStatusDialog',
                'options'=>array(
                    'title'=>'update Item Status',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                    'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('purchaseOrder/process/'.$model->idpo).'";}',
                    //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
                ),
                ));
echo $this->renderPartial('_form_status_update', array('model'=>$model,'modelstatus'=>$modelstatus)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
