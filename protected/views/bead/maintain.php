<?php
/* @var $this BeadController */
/* @var $model Bead */

$this->breadcrumbs=array(
    'Beads'=>array('index'),
    'Maintain',
);

$this->menu=array(
    array('label'=>'Manage Bead', 'url'=>array('admin')),
);
?>
<h1>Bead</h1>

<?php
$tabs=array();
$tabs['Update Bead'] = $this->renderPartial("_form_bead", array("model"=>$modelbead), true); 
$tabs['Add Metal'] = $this->renderPartial("_form_metal", array("model"=>$modelmetal), true);
$tabs['Add Stone'] = $this->renderPartial("_form_stone", array("model"=>$modelstones), true);
$tabs['Add Finding'] = $this->renderPartial("_form_finding", array("model"=>$modelfinding), true);
$tabs['Add Images'] = $this->renderPartial("_form_image", array("model"=>$modelimages), true);
$tabs['Add Review']=$this->renderPartial("_form_review", array("model"=>$modelreview), true);

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>$tabs,
    'options'=>array(
        'collapsible'=>true,
        'selected'=>-1,
    ),
));


?>

<br> <br>
<h4> Bead Metals </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'beadmetals-grid',
    'dataProvider'=>new CActiveDataProvider('Beadmetals', array(
                'criteria'=>array(
                'condition'=>'idbeadsku='.$modelbead->idbeadsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'summaryText'=>'',
    'columns'=>array(
        array('name'=>'idbeadmetals','header'=>'id'),
        array('name'=>'idbeadsku','header'=>'Sku','value'=>'$data->idbead0->beadskucode'),
        array('name'=>'idmetal','value'=>'$data->idmetal0->namevar'),
        array('name'=>'metal','header'=>'Metal','value'=>'$data->idmetal0->idmetalm0->name'),
        array('name'=>'metalstamp','header'=>'MetalStamp','value'=>'$data->idmetal0->idmetalstamp0->name'),
        'weight',
        array('type'=>'raw',
            'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("bead/updateMetal",array("id"=>$data->idbeadmetals)),array(
                "onclick"=>"$(\"#updateMetal\").dialog(\"open\"); return false;",
                "update"=>"#updateMetal",
        ));'),
        array(
            'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("bead/deleteMetal",array("id"=>$data->idbeadmetals))',
                    )
                )
        ),
    ),
)); ?>

<div id="updateMetal"></div>
<br>
<h4> Bead Stones </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'beadstones-grid',
    'dataProvider'=>new CActiveDataProvider('Beadstones', array(
                'criteria'=>array(
                'condition'=>'idbeadsku='.$modelbead->idbeadsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'columns'=>array(
        array('name'=>'idstone','header'=>'id'),
        array('name'=>'idbeadsku','header'=>'Sku','type'=>'raw','value'=>'$data->idbead0->beadskucode'),
        array('name'=>'Stone Alias','type'=>'raw','value'=>'$data->idstone0->namevar'),
        array('name'=>'stone','header'=>'Stone','value'=>'$data->idstone0->idstonem0->name'),
        array('name'=>'shape','header'=>'Shape','value'=>'$data->idstone0->idshape0->name'),
        array('name'=>'grade','header'=>'Grade','value'=>'$data->idstone0->quality'),
        array('name'=>'size','header'=>'Size','value'=>'$data->idstone0->idstonesize0->size'),
        array('name'=>'curcost','header'=>'Price /Ct','value'=>'($data->idstone0->weight!=0)?round($data->idstone0->curcost/$data->idstone0->weight,2):""'),
        array('name'=>'lgsize','header'=>'LG','value'=>'$data->lgsize'),
        array('name'=>'smsize','header'=>'SM','value'=>'$data->smsize'),
        array('name'=>'weight','header'=>'Weight','value'=>'$data->idstone0->weight*$data->pieces'),
        'pieces',
      
        array('type'=>'raw',
            'value'=>'CHtml::link("update","javascript:void(0);",array(
                "onClick"=>CHtml::ajax(array
               (
                   "url"=>Yii::app()->createUrl("bead/updateStone",array("id"=>$data->idbeadstones)),
                   "success"=>"function(data){jQuery(\'#updateStone\').html(data).dialog(\'open\');return false;}",
                   "update"=>"#updateStone",
                                        
                ) 
            )
        ))'),
        array(
            'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("bead/deleteStone",array("id"=>$data->idbeadstones))',
                        )
                    )
        ),
    ),
)); ?>

<div id="updateStone"></div>
<br>
<h4> Bead Findings </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'beadfindings-grid',
    'dataProvider'=>new CActiveDataProvider('Beadfinding', array(
                'criteria'=>array(
                'condition'=>'idbeadsku='.$modelbead->idbeadsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'columns'=>array(
        array('name'=>'idbeadfinding','header'=>'id'),
        array('name'=>'idbeadsku','header'=>'Sku','type'=>'raw','value'=>'$data->idbead0->beadskucode'),
        array('name'=>'idfinding','type'=>'raw','value'=>'$data->idfinding0->name'),
        array('name'=>'metal','header'=>'Metal','type'=>'raw','value'=>'($data->idfinding0->idmetal0)?$data->idfinding0->idmetal0->namevar:NULL'),
        array('name'=>'weight','header'=>'Wt','type'=>'raw','value'=>'($data->idfinding0->weight)?$data->idfinding0->weight:NULL'),
        'qty',
        array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
         
        array('type'=>'raw',
            'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("bead/updateFinding",array("id"=>$data->idbeadfinding)),array(
                "onclick"=>"$(\"#updateFinding\").dialog(\"open\"); return false;",
                "update"=>"#updateFinding",
        ));'),
        array(
            'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                    'buttons'=>array(
                        'delete'=>array(
                            'url'=>'Yii::app()->createUrl("bead/deleteFinding",array("id"=>$data->idbeadfinding))',
                        )
                    )
        ),
    ),
)); ?>

<div id="updateFinding"></div>
<br>
<h4> Bead Images </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'beadimage-grid',
    'dataProvider'=>new CActiveDataProvider('Beadimages', array(
                'criteria'=>array(
                'condition'=>'idbeadsku='.$modelbead->idbeadsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'columns'=>array(
        array('name'=>'idbeadimages','header'=>'id'),
        array('name'=>'idsku','header'=>'Sku','type'=>'raw','value'=>'$data->idbead0->beadskucode'),
        array('name'=>'image','type'=>'image','value'=>'$data->imageThumbUrl'),
        array('name'=>'image','header'=>'Image Name'),
        'type',
        array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
        array('type'=>'raw',
            'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("bead/updateImage",array("id"=>$data->idbeadimages)),array(
                "onclick"=>"$(\"#updateImage\").dialog(\"open\"); return false;",
                "update"=>"#updateImage",
        ));'),
        array(
            'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("bead/deleteImage",array("id"=>$data->idbeadimages))',
                    )
                )
        ),
    ),
)); ?>


<div id="updateImage"></div>
<br>

<h4> Bead Reviews </h4>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'beadreviews-grid',
    'dataProvider'=>new CActiveDataProvider('Beadreviews', array(
                'criteria'=>array(
                'condition'=>'idbeadsku='.$modelbead->idbeadsku,
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        )),
    'columns'=>array(
        array('name'=>'idbeadreview','header'=>'id'),
        array('name'=>'idbeadsku','header'=>'Sku','type'=>'raw','value'=>'$data->idbead0->beadskucode'),
        'mdate',
        'reviews',
        array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'), 
        array('type'=>'raw',
            'value'=>'CHtml::ajaxLink("update",Yii::app()->createUrl("bead/updateReview",array("id"=>$data->idbeadreview)),array(
                "onclick"=>"$(\"#updateReview\").dialog(\"open\"); return false;",
                "update"=>"#updateReview",
        ));'),
        array(
            'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete'=>array(
                        'url'=>'Yii::app()->createUrl("bead/deleteReview",array("id"=>$data->idbeadreview))',
                    )
                )
        ),
    ),
)); ?>


<div id="updateReview"></div>


<style>
#beadimage-grid_c2{
    width:0px;
}
</style>