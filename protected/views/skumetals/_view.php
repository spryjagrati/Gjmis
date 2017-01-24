<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskumetals')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskumetals), array('view', 'id'=>$data->idskumetals)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetal')); ?>:</b>
	<?php echo CHtml::encode($data->idmetal0->namevar); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('usage')); ?>:</b>
	<?php echo CHtml::encode($data->usage); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('lossfactor')); ?>:</b>
	<?php echo CHtml::encode($data->lossfactor); ?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->updby); ?>
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