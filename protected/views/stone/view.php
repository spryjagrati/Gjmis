<?php
$this->breadcrumbs=array(
	'Stones'=>array('index'),
	$model->idstone,
);

$this->menu=array(
	
	array('label'=>'Create Stone', 'url'=>array('create')),
	array('label'=>'Update Stone', 'url'=>array('update', 'id'=>$model->idstone)),
	array('label'=>'Delete Stone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstone),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Stone', 'url'=>array('admin')),
      
);
?>

<h1>View Stone #<?php echo $model->idstone; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstone',
		'namevar',
		array('name'=>'idstonem','value'=>$model->idstonem0->name),
		array('name'=>'idstonesize','value'=>isset($model->idstonesize0->size)?$model->idstonesize0->size:''),
		array('name'=>'idshape','value'=>$model->idshape0->name),
		//array('name'=>'idclarity','value'=>$model->idclarity0->name),
		'color',
		'scountry',
		'cut',
		//'type',
		'quality',
		'creatmeth',
		'treatmeth',
		'cdate',
		'mdate',
		array('name'=>'jewelry_type','type'=>'raw','value'=>($model->jewelry_type==2)?'Beads':'Jewelry'),
		array('name'=>'updby','type'=>'raw','value'=>$model->iduser0->username),
		//'curcost',
            array('name'=>'curcost','header'=>'Price /Ct','value'=>($model->weight!=0)?round($model->curcost/$model->weight,2):""),
		'prevcost',
          
            'weight',
	),
)); ?>
