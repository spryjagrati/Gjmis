<?php
$this->breadcrumbs=array(
	'Clarities'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Clarity', 'url'=>array('index')),
	array('label'=>'Manage Clarity', 'url'=>array('admin')),
);
?>

<h1>Create Clarity</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clarity-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idclarity',
		'name',
	),
)); ?>
