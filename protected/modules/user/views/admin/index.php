<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Manage'),
);
?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Create User'),array('create')),
		),
	));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("admin/view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
                array(
                    'header'=>'Department',
                    'name'=>'iddept',
                    'value'=>function($data) { 
							 if($data->id !== '1'){
    						return $data->iddept0->name.'-'.$data->idlocation0->name;
						}
						else{								
						      }  
                    }
                ),
               // 'idlocation',
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
		),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
		),
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{login_history}{view}{update}{access}{delete}',
                        'buttons'=>array(
                                'access'=>array(
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/process.gif',
                                'url'=>'Yii::app()->createUrl("user/access",array("id"=>$data->id))',
                                'options'=>array('style'=>'margin:1px;'),
                                ),
                                'login_history'=>array(
                                'label'=>'Login History',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/login_history.jpg',
                                'url'=>'Yii::app()->createUrl("accesstime/useraccesstime",array("id"=>$data->id))',
                                'options'=>array('style'=>'margin:1px;'),
                                ),
                        )
		),
	),
)); ?>
