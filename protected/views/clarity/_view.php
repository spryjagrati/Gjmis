<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclarity')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idclarity), array('view', 'id'=>$data->idclarity)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>