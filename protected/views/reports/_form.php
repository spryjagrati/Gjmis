<div class="uniForm">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'deptlog-form',
	'enableAjaxValidation'=>false,
      
)); 

    $act = 'reports/stoneStockReport';
 $ac = $this->route;
 $stonem = Stonem::model()->findAll();
//print_r($stonem);
//die();
?>
    
    <fieldset class="inlineLabels">
<?php if($ac != 'reports/stoneStockLedger') {?>
	<div class="ctrlHolder">
		<?php echo $form->label($model,'iddept'); ?>
		<?php  echo $form->dropDownList($model,'iddept',
                              (Yii::app()->user->id == '1')? ComSpry::getLocationsdeptfrom():ComSpry::getLocDepts(),
                     array('class'=>'selectInput','style'=>'width:20%')); ?>
		<?php echo $form->error($model,'iddept'); ?>
	</div>
            <?php } ?>
         <?php if($ac == 'reports/stoneStockLedger') {?>
        <div class="ctrlHolder">
        <?php $stonelist = Stonem::model()->findAll(); 
       echo CHtml::Label('Stone Name','');  
        echo CHtml::dropDownList('idstonem',$idstonem,ComSpry::getStonem(),array('class'=>'selectInput','style'=>'width:20%'));
        ?>
 	<?php 
// echo $form->error($stonem,'idstonem'); ?>
	</div>
        <div class="ctrlHolder">
        <?php //  $list = ComSpry::getShapes();
       echo CHtml::Label('Shape','');  
        echo CHtml::dropDownList('idshape',$idshape,ComSpry::getShapes(),array('class'=>'selectInput','style'=>'width:20%'));
        ?>
            	<?php // echo $form->error($stonem,'idstonem'); ?>
	</div>
         <div class="ctrlHolder">
        <?php // $list = ComSpry::getStonesizes();
       echo CHtml::Label('Stone Size','');  
       echo CHtml::dropDownList('idstonesize',$idstonesize,ComSpry::getStonesizes(),array('class'=>'selectInput','style'=>'width:20%'));
        ?>
            	<?php // echo $form->error($stonem,'idstonem'); ?>
	</div>
        <div class="ctrlHolder">
        <?php //  $list = ComSpry::getShapes();
       echo CHtml::Label('Department','');  
        echo CHtml::dropDownList('iddept',$iddept,
                     ComSpry::getDepts(),array('class'=>'selectInput','style'=>'width:20%'));
        ?>
        <?php } ?>
        <?php if($ac == $act) {?>
        <div class="ctrlHolder">
		<?php echo CHtml::label('FROM',''); ?>
		<?php echo $form->textField($model,'cdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"cdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Stonestocks_cdate',
                    'button'=>'cdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                   
                ));
            ?>
	</div>

	<div class="ctrlHolder">
		<?php echo CHtml::label('To',''); ?>
		<?php echo $form->textField($model,'mdate'); ?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/calendar.jpg","calendar",array("id"=>"mdate_button","class"=>"pointer")); ?>
            <?php $this->widget('application.extensions.calendar.SCalendar',
                array(
                    'inputField'=>'Stonestocks_mdate',
                    'button'=>'mdate_button',
                    'ifFormat'=>'%Y-%m-%d',
                ));
            ?>
	</div>
        <?php } ?>

	<div class="buttonHolder">
		<?php echo CHtml::submitButton('Report',array('reports/Report'),array('complete' => 'function(){$.fn.yiiGridView.update("report-grid");}',),array('id'=>'genreport','class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
