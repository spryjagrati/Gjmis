<div class="uniForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <fieldset class="inlineLabels">
		<div class="ctrlHolder">
			<?php echo $form->label($model,'refpo'); ?>
			<?php echo $form->textField($model,'refpo',array('class'=>'textInput', 'style'=>'width:23%')); ?>
		</div>

        <!--<div class="ctrlHolder">
		<?php echo $form->label($model,'tdnum'); ?>
		<?php echo $form->textField($model,'tdnum',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
	    </div>-->
        <div class="ctrlHolder">
			<?php echo $form->label($model,'keyword'); ?>
            <?php echo $form->dropDownList($model,'keyword',
                        CHtml::listData(Keywords::model()->findAll(), 'keyword', 'keyword'),
                        array('empty'=>'','style'=>'width:24%'));?>
        </div>
        
        <div class="ctrlHolder">
			<?php echo $form->label($model,'type'); ?>
			<?php echo $form->dropDownList($model,'type',
	            CHtml::listData(Category::model()->findAll(), 'category', 'category'), array('empty'=>'','style'=>'width:24%'));
	        ?>
	        <div id='skufindingdrop'>
		        <?php echo $form->label($model,'finding'); ?>
		        <?php 
		        	echo $form->dropDownList($model,'finding',ComSpry::getEarringFindings(),array('empty'=>'',));
		        ?>
		    </div>
	        
		 </div>
        
        <div class="ctrlHolder">
			<?php echo $form->label($model,'metal type'); ?>
			<?php echo $form->textField($model,'sku_metals',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
		</div>
        
        <div class="ctrlHolder">
            <?php echo $form->label($model,'gemstone'); ?>
            <?php echo $form->textField($model,'gemstone',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
            <label style="width:15px;">&</label>
            <?php echo $form->labelEx($model,'gemstone2'); ?>
             <?php echo $form->textField($model,'gemstone2',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
            <?php echo $form->checkbox($model,'stone_check2')?>
	</div>
        <div class="ctrlHolder">
            <?php echo $form->label($model,'gem_shape'); ?>
            <?php echo $form->textField($model,'gem_shape',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
            <label style="width:15px;">&</label>
            <?php echo $form->label($model,'gem_shape2'); ?>
            <?php echo $form->textField($model,'gem_shape2',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
            <?php echo $form->checkbox($model,'stone_check3')?>
        </div>
        <div class="ctrlHolder">
            <?php echo $form->label($model,'gem_size'); ?>
            <?php echo $form->textField($model,'gem_size',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
            <label style="width:15px;">&</label>
            <?php echo $form->label($model,'gem_size2'); ?>
            <?php echo $form->textField($model,'gem_size2',array('size'=>45,'maxlength'=>45,'class'=>'textInput', 'style'=>'width:23%')); ?>
	<?php echo $form->checkbox($model,'stone_check4')?>
        </div>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'numstones'); ?>
		<?php echo $form->textField($model,'numstones',array('size'=>45,'maxlength'=>3, 'class'=>'textInput', 'style'=>'width:23%')); ?>
		<?php echo $form->checkbox($model,'stone_check')?>
	</div>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'wt_from'); ?>
		<?php echo $form->textField($model,'wt_from',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	        
                    <?php echo $form->labelEx($model,'wt_to'); ?>
		<?php echo $form->textField($model,'wt_to',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	</div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'met_not_less'); ?>
		<?php echo $form->textField($model,'met_not_less',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	</div>
        <div class="ctrlHolder">
		<?php echo $form->labelEx($model,'met_not_more'); ?>
		<?php echo $form->textField($model,'met_not_more',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	</div>
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'cost_not_less'); ?>
		<?php echo $form->textField($model,'cost_not_less',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	        
                    <?php echo $form->labelEx($model,'cost_not_more'); ?>
		<?php echo $form->textField($model,'cost_not_more',array('size'=>5,'maxlength'=>5, 'class'=>'textInput', 'style'=>'width:23%')); ?>
	</div>

	
       <div class="buttonHolder">
		<?php echo CHtml::submitButton('Search',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
        
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- search-form -->