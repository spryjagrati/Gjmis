<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusnav')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstatusnav), array('view', 'id'=>$data->idstatusnav)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatusf')); ?>:</b>
	<?php echo CHtml::encode($data->idstatusf0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatust')); ?>:</b>
	<?php echo CHtml::encode($data->idstatust0->name); ?>
	<br />


</div>