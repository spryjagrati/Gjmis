<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'updateRequestDialog',
                'options'=>array(
                    'title'=>'fulfill material request',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                    'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('purchaseOrder/requirements/'.$model->idpo).'";}',
                    //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
                ),
                ));
echo $this->renderPartial('_form_request_update', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
