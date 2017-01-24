<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcostadd')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcostadd), array('view', 'id'=>$data->idcostadd)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetal')); ?>:</b>
	<?php echo CHtml::encode(($data->idmetal0)?$data->idmetal0->namevar:''); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factormetal')); ?>:</b>
	<?php echo CHtml::encode($data->factormetal); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('idstone')); ?>:</b>
	<?php echo CHtml::encode(($data->idstone0)?$data->idstone0->namevar:''); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factorstone')); ?>:</b>
	<?php echo CHtml::encode($data->factorstone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idchemical')); ?>:</b>
	<?php echo CHtml::encode(($data->idchemical0)?$data->idchemical0->name:''); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factorchem')); ?>:</b>
	<?php echo CHtml::encode($data->factorchem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsetting')); ?>:</b>
	<?php echo CHtml::encode(($data->idsetting0)?$data->idsetting0->name:''); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factorsetting')); ?>:</b>
	<?php echo CHtml::encode($data->factorsetting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('factornumsto')); ?>:</b>
	<?php echo CHtml::encode($data->factornumsto); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('fixcost')); ?>:</b>
	<?php echo CHtml::encode($data->fixcost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costformula')); ?>:</b>
	<?php echo CHtml::encode($data->costformula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('threscostformula')); ?>:</b>
	<?php echo CHtml::encode($data->threscostformula); ?>
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

	
</div>