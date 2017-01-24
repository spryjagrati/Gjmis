<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idpostatuslog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idpostatuslog), array('view', 'id'=>$data->idpostatuslog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idpo')); ?>:</b>
	<?php echo CHtml::encode($data->idpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->updby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusm')); ?>:</b>
	<?php echo CHtml::encode($data->idstatusm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructions')); ?>:</b>
	<?php echo CHtml::encode($data->instructions); ?>
	<br />


</div>