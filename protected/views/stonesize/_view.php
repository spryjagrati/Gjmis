<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonesize')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstonesize), array('view', 'id'=>$data->idstonesize)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />


</div>