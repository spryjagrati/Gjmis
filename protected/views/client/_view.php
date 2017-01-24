<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclient')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idclient), array('view', 'id'=>$data->idclient)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stimagesize')); ?>:</b>
	<?php echo CHtml::encode($data->stimagesize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imgfolder')); ?>:</b>
	<?php echo CHtml::encode($data->imgfolder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commission')); ?>:</b>
	<?php echo CHtml::encode($data->commission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />


</div>