<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsetting')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idsetting), array('view', 'id'=>$data->idsetting)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('setcost')); ?>:</b>
	<?php echo CHtml::encode($data->setcost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bagcost')); ?>:</b>
	<?php echo CHtml::encode($data->bagcost); ?>
	<br />


</div>