<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclientparams')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idclientparams), array('view', 'id'=>$data->idclientparams)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclient')); ?>:</b>
	<?php echo CHtml::encode($data->idclient0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('defaultval')); ?>:</b>
	<?php echo CHtml::encode($data->defaultval); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formula')); ?>:</b>
	<?php echo CHtml::encode($data->formula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />


</div>