<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddept')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->iddept), array('view', 'id'=>$data->iddept)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->getDeptTypeLabel($data->type)); ?>
	<br />


</div>