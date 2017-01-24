<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'updateMetalDialog',
                'options'=>array(
                    'title'=>'update Sku Metal',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                    'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('product/maintain/'.$model->idsku).'";}',
                    //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
                ),
                ));
echo $this->renderPartial('_form_metal_update', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
