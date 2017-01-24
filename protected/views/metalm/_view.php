<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetalm')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmetalm), array('view', 'id'=>$data->idmetalm)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>