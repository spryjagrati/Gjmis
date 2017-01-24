<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'updateMetalDialog',
                'options'=>array(
                    'title'=>'update Bead Metal',
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                    'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('bead/maintain/'.$model->idbeadsku).'";}',
                ),
                ));
echo $this->renderPartial('_form_metal_update', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>