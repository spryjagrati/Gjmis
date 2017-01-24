<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'updateItemDialog',
                'options'=>array(
                    'title'=>'update Po Sku Item',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                    'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('purchaseOrder/maintain/'.$model->idpo).'";}',
                    //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
                ),
                ));
echo $this->renderPartial('_form_sku_update', array('model'=>$model,'suggprice'=>$suggprice)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
