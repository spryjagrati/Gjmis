<?php
$this->breadcrumbs=array(
	'Stonesizes'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Stonesize', 'url'=>array('index')),
	array('label'=>'Manage Stonesize', 'url'=>array('admin')),
);
?>

<h1>Create Stonesize</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'stonesize-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idstonesize',
		'size',
	),
)); ?>
