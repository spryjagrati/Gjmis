<style>
.select2-container{
width: 25%;
float: left;
}
.drop{
    width:15%;
    height: 28px;
}
</style>
<div class="uniForm">
	<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'beadstones-form', 'action' => $this->createUrl('bead/createStone/' . $model->idbeadsku),
        'enableAjaxValidation' => true, 
    ));
    ?>
    	<fieldset class="inlineLabels">
	        <p class="note">Fields with <span class="required">*</span> are required.</p>
	        <span class="required"><?php echo Yii::app()->user->getFlash('beadstone', ''); ?></span>
	            <?php echo $form->errorSummary($model); ?>
	            <?php echo $form->hiddenField($model, 'idbeadsku'); ?>
	        <div class="ctrlHolder">
	            <?php echo $form->labelEx($model, 'idstone', array('style' => 'width:10%')); ?>
	            <?php
			    $this->widget('ext.select2.ESelect2',array(
	             	'model'=>$model,
	             	'attribute' => 'idstone', 
	              	'options'  => array( 
			            'placeholder'=>'Select Gemstone',
			            'minimumInputLength'=> 2,
			            'ajax' => array(
				            'url' => Yii::app()->createUrl('stone/getstone'),
				            'dataType' => 'json',
				            'quietMillis'=> 100,
				            'data' => 'js: function(term,page) {
			                    return {                      
			                        q: term, 
			                        page_limit: 10,                                  
			                        page: page,
			                    };
			                }',
				            'results'=>'js:function(data,page) { 
				             return {results: data }; }',
	        			),
			            'formatResult'=> 'js:function(data){
			                if (data.name !== undefined) {
			                    return data.name;
			                }
			                return "";
			            }',
			            'formatSelection' => 'js: function(data) {
			                return data.name;
			            }',
			            'initSelection' =>'js: function (element, callback) {               
			                var element = $(element).val();  
			                callback(data.name);
			            }',
	            		'escapeMarkup'=>'js: function(m) { return m; }' 
	       			), 
          
        		));
            ?>

            <?php echo $form->labelEx($model, 'Shape *', array('style' => 'width:10%', 'class' => 'required')); ?>
            <?php echo CHtml::dropDownList('Shape', '', array(), array('class'=>'drop', 'empty' => '')); ?>
            <?php echo $form->labelEx($model, 'idsetting', array('style' => 'width:12%')); ?>
            <?php echo $form->dropDownList($model, 'idsetting', ComSpry::getSettings(), array('class' => 'drop', 'empty' => '')); ?>
	        </div>

	        <div class="ctrlHolder">
	            <?php echo $form->labelEx($model, 'Size *', array('style' => 'width:10%','class' =>'required')); ?>
	            <?php echo CHtml::dropDownList('Size', '', array(), array('class'=>'drop', 'empty' => '')); ?>

				<?php echo $form->labelEx($model, 'gem_wt', array('style' => 'width:12%')); ?>
				<?php echo $form->textField($model, 'gem_wt', array('size' => 16, 'maxlength' => 25, 'class' => 'textInput', 'style' => 'width:14%')); ?>
			</div>
			<div class="ctrlHolder">
	            <?php echo $form->labelEx($model, 'lgsize', array('style' => 'width:10%')); ?>
	            <?php echo $form->textField($model, 'lgsize', array('size' => 16, 'maxlength' => 25, 'class' => 'textInput', 'style' => 'width:14%')); ?>
	           
	            <?php echo $form->labelEx($model, 'smsize', array('style' => 'width:12%')); ?>
				<?php echo $form->textField($model, 'smsize', array('size' => 16, 'maxlength' => 25, 'class' => 'textInput', 'style' => 'width:14%')); ?>

	            <?php echo $form->labelEx($model, 'pieces', array('style' => 'width:10%')); ?>
				<?php echo $form->textField($model, 'pieces', array('size' => 3, 'maxlength' => 3, 'class' => 'textInput', 'style' => 'width:5%')); ?>
            </div>

            <div class="ctrlHolder">
				<?php echo $form->labelEx($model, 'remark', array('style' => 'width:10%')); ?>
				<?php echo $form->textArea($model, 'remark', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>
        	</div>

	        <div class="buttonHolder">
				<?php
				 echo CHtml::ajaxSubmitButton('Create',array('bead/createStone', 'id'=>$model->idbeadsku),array('update'=>'#yw0_tab_2','complete' => 'function(){$.fn.yiiGridView.update("beadstones-grid");location.reload();}',),array('id'=>'stone-create','class'=>'primaryAction', 'style'=>'width:20%'));
		        ?>  
			</div>
	    </fieldset>
    <?php $this->endWidget(); //$.fn.yiiGridView.update("beadstones-grid");location.reload();?>
</div>

<script>
    $("#Beadstones_idstone").on('change', function () {
        var value = $("#Beadstones_idstone").val();
        $.ajax({
            type: "post",
            url: '<?php echo $this->createUrl('bead/getshape'); ?>',
            data: {"name": value},
            success: function (response) {
                $("#Shape").html(response);
                $("#Shape").change();
            }
        });
    });

     $("#Shape").on('change', function () {
        var stone = $("#Beadstones_idstone").val();
        var shape = $("#Shape").val();
        $.ajax({
            type: "post",
            url: '<?php echo $this->createUrl('bead/getsize'); ?>',
            data: {"stone": stone, "shape": shape},
            success: function (response) {
                $("#Size").html(response);
            }
        });

    });

</script>