<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddeptskulog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->iddeptskulog), array('view', 'id'=>$data->iddeptskulog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddept')); ?>:</b>
	<?php echo CHtml::encode($data->iddept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
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

	<?php /*
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