<?php
$this->breadcrumbs=array(
	'Memos'=>array('approval'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Approval Memo', 'url'=>array('createapproval')),
        array('label'=>'List Approval Memos', 'url'=>array('approval')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('memo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Approval Memos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'memo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'code',
		array('name'=>'iddptfrom','type'=>'raw','value'=>'$data->iddept->name'),
		'memoto',
		'remark',
                array('header' => 'Created On','name'=>'cdate','type'=>'raw','value'=>'date("d-m-Y", strtotime($data->cdate))'),
                array('header'=> 'Modified On','name'=>'mdate','type'=>'raw','value'=>'date("d-m-Y", strtotime($data->mdate))'),
                array('name' => 'status', 'type' => 'raw', 'value' => 'Memo::getStatus(2)[$data->status]'),
                array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{export}{return}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'url'=>'Yii::app()->createUrl("memo/updateapproval",array("id"=>$data->idmemo))',
                            ),
                            'export'=>array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/export.png',
                                'url'=>'Yii::app()->createUrl("export/skuexport/exportApproval",array("id"=>$data->idmemo))',
                                'options'=>array('style'=>'display:inline-block;margin:5px;'),
                            ),
                            'return'=>array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/return.png',
                                'url'=>'Yii::app()->createUrl("memo/returnApproval",array("id"=>$data->idmemo))',
                                'options'=>array('style'=>'display:inline-block;margin:5px;'),
                            ),
                        ),
                        'htmlOptions'=>array('style'=>'width:13%;'),
		),
	),
)); ?>
