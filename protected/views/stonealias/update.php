<?php
/* @var $this StonealiasController */
/* @var $model Stonealias */

$this->breadcrumbs=array(
	'Stonealiases'=>array('index'),
	//$model->idstone_alias=>array('view','id'=>$model->idstone_alias),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Stonealias', 'url'=>array('create')),
	array('label'=>'Manage Stonealias', 'url'=>array('admin')),
);
?>

<!-- <h1>Update Stonealias <?php //echo $model->idstone_alias; ?></h1> -->

<?php
echo $this->renderPartial('_form', array(
                          'model'=>$model,
                          'member'=>$member,
                          'validatedMembers'=>$validatedMembers));

?>