<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idpo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idpo), array('view', 'id'=>$data->idpo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclient')); ?>:</b>
	<?php echo CHtml::encode($data->idclient0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->iduser0->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusm')); ?>:</b>
	<?php echo CHtml::encode($data->idstatusm0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dlvddate')); ?>:</b>
	<?php echo CHtml::encode($data->dlvddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startdate')); ?>:</b>
	<?php echo CHtml::encode($data->startdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('totamt')); ?>:</b>
	<?php echo CHtml::encode($data->totamt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instructions')); ?>:</b>
	<?php echo CHtml::encode($data->instructions); ?>
	<br />


</div>