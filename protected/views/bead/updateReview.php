<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'updateReviewDialog',
    'options'=>array(
        'title'=>'update Bead review',
        'autoOpen'=>true,
        'modal'=>'true',
        'width'=>'700px',
        'height'=>'auto',
        'close'=> 'js: function(event, ui){ window.location = "'.Yii::app()->createUrl('bead/maintain/'.$model->idbeadsku).'";}',
        //'close'=> 'js: function(event, ui){ $.fn.yiiGridView.update("skustones-grid");}',
    ),
    ));
echo $this->renderPartial('_form_review_update', array('model'=>$model)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>