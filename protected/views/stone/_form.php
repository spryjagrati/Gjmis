<style>
.select2-container{
width: 25%;
}
</style>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'stone-form',
	'enableAjaxValidation'=>false,
          //'layoutName'=>'qtip',
)); ?>
<fieldset class="inlineLabels">
  <?php $stonetype = array('1'=>'Jewelry', 2=>'Beads') ?>
  <?php if(Yii::app()->user->hasFlash('errormessage')):?>
    <div class="info" style="color:red;">
      <?php echo Yii::app()->user->getFlash('errormessage'); ?>
    </div>
  <?php endif; ?>
        
	<?php echo $form->errorSummary($model); ?>
    <div class="ctrlHolder">
      <?php echo $form->labelEx($model,'jewelry_type',array('style'=>'width:13%')); ?>
       <?php if($model->isNewRecord)
            echo $form->dropDownList($model,'jewelry_type',$stonetype,array('style'=>'width:20%'));
          else
            echo $form->dropDownList($model,'jewelry_type',$stonetype,array('style'=>'width:20%','disabled'=>'disabled'));
          ?>
      <?php echo $form->error($model,'jewelry_type'); ?>
    </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idstonem'); ?>
		<?php if($model->isNewRecord){
        //echo $form->dropDownList($model,'idstonem',ComSpry::getStonem(),array('empty'=>''));
        //echo CHtml::hiddenField('skucode', '', array('class' => 'span5', 'style'=>'width:30%'));
        $this->widget('ext.select2.ESelect2',array(
           //'selector' => '#skucode',            
          'model'=>$model,
          'attribute' => 'idstonem', 
          'options'  => array( 
             'placeholder'=>'Select Gemstone',
              'minimumInputLength'=> 2,
             'ajax' => array(
                'url' => Yii::app()->createUrl('stone/getstonem'),
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
      }else
      echo $form->dropDownList($model,'idstonem',ComSpry::getStonem(),array('disabled'=>'disabled','empty'=>''));
    ?>
	  <?php echo $form->error($model,'idstonem'); ?>
  </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'idshape',array('class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
		<?php if($model->isNewRecord){
                   $this->widget('ext.select2.ESelect2',array(
                 //'selector' => '#skucode',            
                 'model'=>$model,
                 'attribute' => 'idshape', 
                  'options'  => array( 
           
           'placeholder'=>'Select Shape',
            'minimumInputLength'=> 2,
           'ajax' => array(
            'url' => Yii::app()->createUrl('stone/getshape'),
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
            }
               //echo $form->dropDownList($model,'idshape',ComSpry::getShapes(),array('empty'=>'','style'=>'width:150px;'));
            else
              echo $form->dropDownList($model,'idshape',ComSpry::getShapes(),array('disabled'=>'disabled','empty'=>'','style'=>'width:150px;'));
            ?>
		
    </div>
               <div class = "ctrlHolder">
		<?php echo $form->labelEx($model,'idstonesize'); ?>
		<?php if($model->isNewRecord){
                       $this->widget('ext.select2.ESelect2',array(
                 //'selector' => '#skucode',            
                 'model'=>$model,
                 'attribute' => 'idstonesize', 
                  'options'  => array( 
           
           'placeholder'=>'Select Size',
            'minimumInputLength'=> 2,
           'ajax' => array(
            'url' => Yii::app()->createUrl('stone/getsize'),
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
                if (data.size !== undefined) {
                    return data.size;
                }
                return "";
            }',
            'formatSelection' => 'js: function(data) {
                return data.size;
            }',
            'initSelection' =>'js: function (element, callback) {               
                var element = $(element).val();  

                callback(data.size);
            }',
            'escapeMarkup'=>'js: function(m) { return m; }' 
       ), 
          
        ));
            }
              
             else

             
                 echo $form->dropDownList($model,'idstonesize',ComSpry::getStonesizes(),array('disabled'=>'disabled','empty'=>''));
              
              
               ?>
       <?php echo $form->error($model,'idstonesize'); ?>
	</div>


  <div class="ctrlHolder">
    <?php //$model->curcost = $cost_price; ?>
    <?php echo $form->labelEx($model,'curcost'); ?>
    <?php echo $form->textField($model,'curcost',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:8%'));?>
    <?php if(!$model->isNewRecord)
        echo CHtml::textField($model->getAttributeLabel('curcost'), $model->curcost,array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:8%','disabled'=>'disabled'));
    ?>
    <?php echo $form->error($model,'curcost'); ?>
    <?php echo CHtml::dropDownList('priceopt','priceopt',$priceopt,array('style'=>'width:12%'));?>
  </div>

	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'weight',array('class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
		<?php if($model->isNewRecord)
      echo $form->textField($model,'weight',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
    else
      echo $form->textField($model,'weight',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
    ?>
	
		<?php echo $form->labelEx($model,'color',array('style'=>'width:10%','class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
		<?php if($model->isNewRecord)
      echo $form->textField($model,'color',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
      else
      echo $form->textField($model,'color',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
    ?>
	</div>

  <div class="ctrlHolder">
    <?php echo $form->labelEx($model,'quality',array('style'=>'width:10%','class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
    <?php if($model->isNewRecord)
        echo $form->textField($model,'quality',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:3%'));
      else
        echo $form->textField($model,'quality',array('size'=>1,'maxlength'=>1, 'class'=>'textInput', 'style'=>'width:3%'));
      ?>
    <?php //echo $form->error($model,'quality'); ?>

    <?php echo $form->labelEx($model,'cut',array('style'=>'width:10%','class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
    <?php if($model->isNewRecord)
          echo $form->textField($model,'cut',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
        else
          echo $form->textField($model,'cut',array('size'=>16,'maxlength'=>16, 'class'=>'textInput', 'style'=>'width:13%'));
        ?>
    <?php //echo $form->error($model,'cut'); ?>

    <?php echo $form->labelEx($model,'idclarity',array('style'=>'width:10%'));
      if($model->isNewRecord)
        echo $form->dropDownList($model,'idclarity',ComSpry::getClarities(),array('empty'=>''));
      else
        echo $form->dropDownList($model,'idclarity',ComSpry::getClarities(),array('disabled'=>'disabled','empty'=>''));             
     //echo $form->error($model,'idclarity'); ?>
  </div>

	
  <div class="ctrlHolder">
    <?php echo $form->labelEx($model,'namevar',array('class'=>'changecolor','style'=> 'color:#c20f2e')); ?>
    <?php if($model->isNewRecord)
            echo $form->textField($model,'namevar',array('size'=>64,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:20%'));
          else
            echo $form->textField($model,'namevar',array('size'=>64,'maxlength'=>64, 'class'=>'textInput', 'style'=>'width:20%'));
          ?>
    <?php echo $form->error($model,'namevar'); ?>

    <?php echo $form->labelEx($model,'month'); ?>
    <?php echo $form->textField($model,'month',array('size'=>16,'maxlength'=>16)); ?>
    <?php echo $form->error($model,'month'); ?>
  </div>
        <!--
	<div class="ctrlHolder">
		<?php echo $form->labelEx($model,'prevcost'); ?>
		<?php echo $form->textField($model,'prevcost',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'prevcost'); ?>
	</div>
-->
	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$("#Stone_idstonem").on('change', function(){
    $("#Stone_namevar").val($(this).select2('data').name);
})

$("#Stone_jewelry_type").on('change',function(){
    var type = $("#Stone_jewelry_type").val();
    var x = document.getElementsByClassName("changecolor");
    if(type == 1){
      for (var i = 0; i < x.length; i++) {
          x[i].setAttribute("style", "color: #c20f2e;");
      } 
    }else{
      for (i = 0; i < x.length; i++) {
          x[i].setAttribute("style", "color:''");
      } 
    }
})

$( window ).load(function() {
  var type = $("#Stone_jewelry_type").val();
  var x = document.getElementsByClassName("changecolor");
  if(type == 2){
      for (var i = 0; i < x.length; i++) {
          x[i].setAttribute("style", "color:''");
      } 
  }
});


</script>