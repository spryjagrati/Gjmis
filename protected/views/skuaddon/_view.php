<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskuaddon')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskuaddon), array('view', 'id'=>$data->idskuaddon)); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('idcostaddon')); ?>:</b>
	<?php echo CHtml::encode($data->idcostaddon0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->iduser0->username); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />
-->
</div>