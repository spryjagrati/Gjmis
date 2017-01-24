<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idshape')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idshape), array('view', 'id'=>$data->idshape)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>