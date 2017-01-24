<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idtbl_matreqlog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idtbl_matreqlog), array('view', 'id'=>$data->idtbl_matreqlog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmatreq')); ?>:</b>
	<?php echo CHtml::encode($data->idmatreq); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('rqty')); ?>:</b>
	<?php echo CHtml::encode($data->rqty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fqty')); ?>:</b>
	<?php echo CHtml::encode($data->fqty); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusm')); ?>:</b>
	<?php echo CHtml::encode($data->idstatusm); ?>
	<br />

	*/ ?>

</div>