<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmemo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmemo), array('view', 'id'=>$data->idmemo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddptfrom')); ?>:</b>
	<?php echo CHtml::encode($data->iddptfrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('memoto')); ?>:</b>
	<?php echo CHtml::encode($data->memoto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
	<?php echo CHtml::encode($data->remark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('memoreturn')); ?>:</b>
	<?php echo CHtml::encode($data->memoreturn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('returndate')); ?>:</b>
	<?php echo CHtml::encode($data->returndate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdby')); ?>:</b>
	<?php echo CHtml::encode($data->createdby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedby')); ?>:</b>
	<?php echo CHtml::encode($data->updatedby); ?>
	<br />

	*/ ?>

</div>