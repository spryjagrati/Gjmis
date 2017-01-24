<?php
$this->breadcrumbs=array(
	'Metalstamps'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Metalstamp', 'url'=>array('index')),
	array('label'=>'Manage Metalstamp', 'url'=>array('admin')),
);
?>

<h1>Create Metalstamp</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metalstamp-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idmetalstamp',
		'name',
		'purity',
	),
)); ?>
