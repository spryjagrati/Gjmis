<style>
.select2-container{
width: 45%;
}
.ctrlHolder .mmf_row{
  width: 33%;
}
</style>
<div class="uniForm">

<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
	'id'=>'stone-form',
	'enableAjaxValidation'=>false,
          //'layoutName'=>'qtip',
)); ?>
    <fieldset class="inlineLabels">
     <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php if(Yii::app()->user->hasFlash('errormessage')):?>
        <div class="info" style="color:red;">
        <?php echo Yii::app()->user->getFlash('errormessage'); ?>
        </div>
        <?php endif; ?>
        
	<?php echo $form->errorSummary($member); ?>

	<div class="ctrlHolder">
            <label class="span3 required" for="stone-form_idstonem">Gemstone<span class="required">*</span></label>
	    <?php if($model->isNewRecord){
                $this->widget('ext.select2.ESelect2',array(
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
                echo $form->dropDownList($model,'idstonem',ComSpry::getStonem(),array('disabled'=>'disabled','style'=>'width:40%'));
               ?>
		<?php echo $form->error($model,'idstonem'); ?>
        </div>

<?php
    $memberFormConfig = array(
          'elements'=>array(
            'export'=>array(
                'type'=>'dropdownlist',
                'items' => array(0=>'',1 => 'Amazon_Sheet', 2 => 'HT_Sheet', 3 => 'QB_Sheet', 4 =>'ZY_Sheet',5 =>'GKW_Sheet',6 =>'TH_Sheet',7 =>'QOV_Sheet',8 =>'QJC_Sheet',9 =>'JZ_Sheet'),
             // 'type' => 'text',
                'maxlength'=>50,
            ),
            'idproperty'=>array(
                 'type'=>'dropdownlist',
                 'items' => array(0=>'',1 => 'Color',2 =>'Birthstone',3 => 'Treatment'),
                //'type' =>'text',
                'maxlength'=>50,
            ),
            'alias'=>array(
                'type'=>'text',
                'maxlength' =>20,
            ),
        ));
 
    $this->widget('ext.multimodelform.MultiModelForm',array(
            'id' => 'id_member', //the unique widget id
            'formConfig' => $memberFormConfig, //the form configuration array
            'model' => $member, //instance of the form model
            'validatedItems' => $validatedMembers,
            'bootstrapLayout' => true,
            'removeText' => 'X', 
            'tableView' => false, 
            'fieldsetWrapper' => array('tag' => 'div', 'htmlOptions' => array('class' => 'ctrlHolder ctrpanel')),
 
            //array of member instances loaded from db
            'data' => $member->findAll('idstonem=:idstonem', array(':idstonem'=>$model->idstonem)),
        ));
    ?>



	<div class="buttonHolder">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'primaryAction', 'style'=>'width:20%')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->
