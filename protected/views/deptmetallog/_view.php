<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddeptmetallog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->iddeptmetallog), array('view', 'id'=>$data->iddeptmetallog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetal')); ?>:</b>
	<?php echo CHtml::encode($data->idmetal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddept')); ?>:</b>
	<?php echo CHtml::encode($data->iddept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cunit')); ?>:</b>
	<?php echo CHtml::encode($data->cunit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idpo')); ?>:</b>
	<?php echo CHtml::encode($data->idpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->updby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refrcvd')); ?>:</b>
	<?php echo CHtml::encode($data->refrcvd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refsent')); ?>:</b>
	<?php echo CHtml::encode($data->refsent); ?>
	<br />

	*/ ?>

</div>