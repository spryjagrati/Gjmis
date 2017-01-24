<?php
/* @var $this StonealiasController */
/* @var $model Stonealias */

$this->breadcrumbs=array(
	'Stonealiases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Stonealias', 'url'=>array('admin')),
);
?>

<h1>Create Stonealias</h1>

<?php
echo $this->renderPartial('_form', array(
                          'model'=>$model,
                          'member'=>$member,
                          'validatedMembers'=>$validatedMembers));

?>