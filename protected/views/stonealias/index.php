<?php
/* @var $this StonealiasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stonealiases',
);

$this->menu=array(
	array('label'=>'Create Stonealias', 'url'=>array('create')),
	array('label'=>'Manage Stonealias', 'url'=>array('admin')),
);
?>

<h1>Stonealiases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
