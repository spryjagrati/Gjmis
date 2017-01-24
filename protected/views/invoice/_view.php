<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idinvoice')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idinvoice), array('view', 'id'=>$data->idinvoice)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idlocation')); ?>:</b>
	<?php echo CHtml::encode($data->idlocation); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('activ')); ?>:</b>
	<?php echo CHtml::encode($data->activ); ?>
	<br />


</div>