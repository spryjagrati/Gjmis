<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idtbl_deptfindlog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idtbl_deptfindlog), array('view', 'id'=>$data->idtbl_deptfindlog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddept')); ?>:</b>
	<?php echo CHtml::encode($data->iddept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idfinding')); ?>:</b>
	<?php echo CHtml::encode($data->idfinding); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refrcvd')); ?>:</b>
	<?php echo CHtml::encode($data->refrcvd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refsent')); ?>:</b>
	<?php echo CHtml::encode($data->refsent); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('idpo')); ?>:</b>
	<?php echo CHtml::encode($data->idpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	*/ ?>

</div>