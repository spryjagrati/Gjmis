<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idposkustatus')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idposkustatus), array('view', 'id'=>$data->idposkustatus)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idposku')); ?>:</b>
	<?php echo CHtml::encode($data->idposku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reqdqty')); ?>:</b>
	<?php echo CHtml::encode($data->reqdqty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('processqty')); ?>:</b>
	<?php echo CHtml::encode($data->processqty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delqty')); ?>:</b>
	<?php echo CHtml::encode($data->delqty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idprocdept')); ?>:</b>
	<?php echo CHtml::encode($data->idprocdept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusm')); ?>:</b>
	<?php echo CHtml::encode($data->idstatusm0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcvddate')); ?>:</b>
	<?php echo CHtml::encode($data->rcvddate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->updby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dlvddate')); ?>:</b>
	<?php echo CHtml::encode($data->dlvddate); ?>
	<br />

	*/ ?>

</div>