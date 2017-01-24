<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusm')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstatusm), array('view', 'id'=>$data->idstatusm)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>