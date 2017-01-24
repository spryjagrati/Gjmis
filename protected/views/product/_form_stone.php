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
        'id' => 'skustones-form', 'action' => $this->createUrl('product/createStone/' . $model->idsku),
        'enableAjaxValidation' => true, //'layoutName'=>'qtip'
    ));
    ?>
    <fieldset class="inlineLabels">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <span class="required"><?php echo Yii::app()->user->getFlash('skustone', ''); ?></span>
            <?php echo $form->errorSummary($model); ?>
            <?php echo $form->hiddenField($model, 'idsku'); ?>
        <div class="ctrlHolder">
            <?php echo $form->labelEx($model, 'idstone', array('style' => 'width:10%')); ?>
            <?php
            //echo CHtml::activeDropDownList($model, 'idstone', ComSpry::getStone(), array('prompt' => '')
            //);
         $this->widget('ext.select2.ESelect2',array(
                 //'selector' => '#skucode',            
                 'model'=>$model,
                 'attribute' => 'idstone', 
                  'options'  => array( 
           
           'placeholder'=>'Select Gemstone',
            'minimumInputLength'=> 2,
           'ajax' => array(
            'url' => Yii::app()->createUrl('product/getstone'),
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
            
            
            <?php echo $form->labelEx($model, 'Shape*', array('style' => 'width:10%', 'class' => 'required')); ?>
            <?php echo CHtml::dropDownList('Shape', '', array(), array('class'=>'drop', 'empty' => '')); ?>
            <?php echo $form->labelEx($model, 'idsetting', array('style' => 'width:12%')); ?>
            <?php echo $form->dropDownList($model, 'idsetting', ComSpry::getSettings(), array('class' => 'drop', 'empty' => '')); ?>
            <?php //echo $form->error($model,'idsetting'); ?>
            <!--<?php echo $form->labelEx($model, 'type', array('style' => 'width:10%')); ?>
<?php echo $form->dropDownList($model, 'type', $model->getTypes(), array('class' => 'selectInput', 'style' => 'width:10%', 'empty' => '')); ?>
<?php //echo $form->error($model,'type');  ?>-->

        </div>
        <div class="ctrlHolder">
            <?php echo $form->labelEx($model, 'Size*', array('style' => 'width:6%', 'class' => 'required')); ?>
            <?php echo CHtml::dropDownList('Size', '', array(), array('class'=>'drop', 'empty' => '')); ?>

<?php echo $form->labelEx($model, 'Quality*', array('style' => 'width:10%', 'class' => 'required')); ?>
<?php echo CHtml::dropDownList('Quality', '', array(), array('class'=>'drop', 'empty' => '')); ?>
        </div>


        <div class="ctrlHolder">
            <?php echo $form->labelEx($model, 'height', array('style' => 'width:8%')); ?>
            <?php echo $form->textField($model, 'height', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:10%')); ?>
            <?php echo $form->error($model, 'height'); ?>
            <?php echo $form->labelEx($model, 'mmsize', array('style' => 'width:10%')); ?>
            <?php echo $form->textField($model, 'mmsize', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:10%')); ?>
            <?php echo $form->error($model, 'mmsize'); ?>
            <?php echo $form->labelEx($model, 'diasize', array('style' => 'width:10%')); ?>
            <?php echo $form->textField($model, 'diasize', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:10%')); ?>
            <?php echo $form->error($model, 'diasize'); ?>
            <?php echo $form->labelEx($model, 'sievesize', array('style' => 'width:10%')); ?>
<?php echo $form->textField($model, 'sievesize', array('size' => 16, 'maxlength' => 16, 'class' => 'textInput', 'style' => 'width:10%')); ?>
<?php echo $form->error($model, 'sievesize'); ?>
        </div>

        <div class="ctrlHolder">
            <?php echo $form->labelEx($model, 'pieces', array('style' => 'width:10%')); ?>
<?php echo $form->textField($model, 'pieces', array('size' => 3, 'maxlength' => 3, 'class' => 'textInput', 'style' => 'width:5%')); ?>
<?php //echo $form->error($model,'pieces');  ?>
        </div>

        <div class="ctrlHolder">
<?php echo $form->labelEx($model, 'reviews', array('style' => 'width:10%')); ?>
<?php echo $form->textArea($model, 'reviews', array('rows' => 4, 'cols' => 40, 'maxlength' => 255, 'class' => 'textArea', 'style' => 'height:3em;')); ?>

        </div>

        <div class="buttonHolder">
    <?php echo CHtml::ajaxSubmitButton($model->isNewRecord ? 'Create' : 'Save', array('product/createStone/' . $model->idsku), array('update' => '#yw0_tab_2', 'complete' => 'function(){$.fn.yiiGridView.update("skustones-grid");location.reload();}',), array('id' => 'stone-create', 'class' => 'primaryAction', 'style' => 'width:20%')); ?>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $("#Skustones_idstone").on('change', function () {
        var value = $("#Skustones_idstone").val();
        $.ajax({
            type: "post",
            url: '<?php echo $this->createUrl('product/getshape'); ?>',
            data: {"name": value},
            success: function (response) {
                $("#Shape").html(response);
                $("#Shape").change();
            }
        });
        $.ajax({
            type: "post",
            url: '<?php echo $this->createUrl('product/getquality'); ?>',
            data: {"name": value},
            success: function (response) {
                $("#Quality").html(response);
            }
        });
    });



    $("#Shape").on('change', function () {
        var stone = $("#Skustones_idstone").val();
        var shape = $("#Shape").val();
        $.ajax({
            type: "post",
            url: '<?php echo $this->createUrl('product/getsize'); ?>',
            data: {"stone": stone, "shape": shape},
            success: function (response) {
                $("#Size").html(response);
            }
        });

    });




</script>
