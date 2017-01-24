<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetal')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idmetal), array('view', 'id'=>$data->idmetal)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namevar')); ?>:</b>
	<?php echo CHtml::encode($data->namevar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetalm')); ?>:</b>
	<?php echo CHtml::encode($data->idmetalm0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idmetalstamp')); ?>:</b>
	<?php echo CHtml::encode($data->idmetalstamp0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('currentcost')); ?>:</b>
	<?php echo CHtml::encode($data->currentcost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prevcost')); ?>:</b>
	<?php echo CHtml::encode($data->prevcost); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('lossfactor')); ?>:</b>
	<?php echo CHtml::encode($data->lossfactor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chemcost')); ?>:</b>
	<?php echo CHtml::encode($data->chemcost); ?>
	<br />


</div>