<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskustones')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskustones), array('view', 'id'=>$data->idskustones)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->iduser0->username); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->pieces); ?></b><?php echo CHtml::encode($data->getAttributeLabel('piece(s)')); ?> of
	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('idstone')); ?>:</b>-->
	<b><?php echo CHtml::encode($data->idstone0->namevar); ?></b>

	<?php echo CHtml::encode($data->getAttributeLabel('idsetting')); ?>:
	<b><?php echo CHtml::encode($data->idsetting0->name); ?></b>

	<?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:
	<b><?php echo CHtml::encode($data->type); ?></b>
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