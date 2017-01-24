<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskufindings')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskufindings), array('view', 'id'=>$data->idskufindings)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('idfinding')); ?>:</b>
	<?php echo CHtml::encode($data->idfinding0->name); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->iduser0->username); ?>
	<br />
        
	<?php /*


	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	*/ ?>

</div>