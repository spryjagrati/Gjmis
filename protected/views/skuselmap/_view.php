<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskuselmap')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskuselmap), array('view', 'id'=>$data->idskuselmap)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclient')); ?>:</b>
	<?php echo CHtml::encode($data->idclient0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clientcode')); ?>:</b>
	<?php echo CHtml::encode($data->clientcode); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('csname')); ?>:</b>
	<?php echo CHtml::encode($data->csname); ?>
	<br />


</div>