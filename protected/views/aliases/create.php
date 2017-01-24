<?php
/* @var $this AliasesController */
/* @var $model Aliases */

$this->breadcrumbs=array(
	'Aliases'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Aliases', 'url'=>array('index')),
	array('label'=>'Manage Aliases', 'url'=>array('admin')),
);
?>

<h1>Create Aliases</h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    //submit the member and validatedItems to the widget in the edit form
    'member'=>$member,
    'validatedMembers' => $validatedMembers,    
        )); ?>