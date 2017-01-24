<?php
$this->breadcrumbs=array(
	'Access History',
);
?>
<h1><?php echo UserModule::t("Access History"); ?></h1>

<?php /* echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Create User'),array('create')),
		),
	)); */
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$modelAccesstime->search($userid),
	'columns'=>array(
            
            array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::encode($data->id)',
		),
            array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::encode($data->users->username)',
		),
            array(
			'name' => 'firstname',
			'type'=>'raw',
			'value' => 'CHtml::encode($data->users->profile->firstname)',
		),
            array(
			'name' => 'lastname',
			'type'=>'raw',
			'value' => 'CHtml::encode($data->users->profile->lastname)',
		),
		array(
			'name' => 'logintime',
			'value' => '(($data->logintime)?date("d.m.Y H:i:s",$data->logintime):UserModule::t("Not visited"))',
		),
		 array(
			'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                                'delete'=>array(
                                //'imageUrl'=>Yii::app()->request->baseUrl.'/images/process.gif',
                                'url'=>'Yii::app()->createUrl("accesstime/delete",array("id"=>$data->id))',
                                'options'=>array('style'=>'margin:1px;'),
                                    ),
                        )

		),
	),
));
?>
