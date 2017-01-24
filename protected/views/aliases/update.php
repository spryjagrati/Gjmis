<?php
/* @var $this AliasesController */
/* @var $model Aliases */

//$this->breadcrumbs=array(
//	'Aliases'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);

$this->menu=array(
	//array('label'=>'List Aliases', 'url'=>array('index')),
	array('label'=>'Create Aliases', 'url'=>array('create')),
	//array('label'=>'View Aliases', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Aliases', 'url'=>array('admin')),
);
?>

<h1>Update Aliases <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    //submit the member and validatedItems to the widget in the edit form
    'member'=>$member,
    'validatedMembers' => $validatedMembers,      
        )); ?>