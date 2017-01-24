<?php

$this->widget('ext.multicomplete.MultiComplete', array(
    'model'=>$skumodel,
    'attribute'=>'idsku',
    'name'=>'approval_memo_skus',
    'sourceUrl'=>Yii::app()->createUrl("memo/search/", array('dept' => $dept)),
    'options'=>array(
    'delay'=>300,
    'minLength'=>2,
    ),

    'htmlOptions'=>array(
    'style'=>'height:20px;'
    ),
));