<?php
$this->breadcrumbs=array(
	'Shapes'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Shape', 'url'=>array('index')),
	array('label'=>'Manage Shape', 'url'=>array('admin')),
);
?>

<h1>Create Shape</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shape-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idshape',
		'name',
	),
)); ?>
