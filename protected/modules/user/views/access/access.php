<?php
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	(UserModule::t('Update')),
);
?>

<h1><?php echo  UserModule::t('Assign Access to User')." ".$model->id; ?></h1>

    <div class="uniForm">
        <?php echo CHtml::beginForm(array('access/AssignAccess', 'id'=>$id),'post' , array('id'=>'selection')); ?>  
            <?php $i=0; foreach($screens as $key=>$value){ ?>
        <br />
            <div class="accessheader"><?php echo $key; ?></div>
            <div class="ctrlHolder" style="width:400px;margin-left: 70px;" >
                <table>
                <?php echo CHtml::checkBoxList('selections[]'.preg_replace('/\s+/', '', $key), $selections, $value, array('checkAll' => 'Select All','template'=>'<tr><td >{label}</td><td>{input}</td></tr>', 'separator'=>'')); ?> 
                </table>
            </div>
            <?php } ?>
                <?php echo CHtml::hiddenField('accessdata','checkedvalues'); ?>
            <div class="buttonHolder">
                <?php echo CHtml::submitButton("Submit Selections",array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
            </div>
        <?php echo CHtml::endForm(); ?>
    </div>
    <?php //echo('<pre>');print_r($screens);die(); ?>

