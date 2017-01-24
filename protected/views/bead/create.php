<?php
/* @var $this BeadController */
/* @var $model Bead */

$this->breadcrumbs=array(
	'Beads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Bead', 'url'=>array('admin')),
);
?>

<h1>Create Bead</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>