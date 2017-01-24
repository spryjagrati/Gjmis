<?php
/* @var $this KeywordsController */
/* @var $model Keywords */

$this->breadcrumbs=array(
	'Keywords',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Keywords', 'url'=>array('admin')),
);
?>

<h1>Create Keywords</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>