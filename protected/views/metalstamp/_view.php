<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetalstamp')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmetalstamp), array('view', 'id'=>$data->idmetalstamp)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purity')); ?>:</b>
	<?php echo CHtml::encode($data->purity); ?>
	<br />


</div>