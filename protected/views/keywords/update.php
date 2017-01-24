<?php
/* @var $this KeywordsController */
/* @var $model Keywords */

$this->breadcrumbs=array(
	'Keywords',
	'Update',
);

$this->menu=array(
	array('label'=>'Create Keywords', 'url'=>array('create')),
	array('label'=>'Manage Keywords', 'url'=>array('admin')),
);
?>

<h1>Update Keywords <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>