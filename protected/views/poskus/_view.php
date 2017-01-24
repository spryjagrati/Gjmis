<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idposkus')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idposkus), array('view', 'id'=>$data->idposkus)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idpo')); ?>:</b>
	<?php echo CHtml::encode($data->idpo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cdate')); ?>:</b>
	<?php echo CHtml::encode($data->cdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mdate')); ?>:</b>
	<?php echo CHtml::encode($data->mdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->updby); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('totamt')); ?>:</b>
	<?php echo CHtml::encode($data->totamt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stonevar')); ?>:</b>
	<?php echo CHtml::encode($data->stonevar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reforder')); ?>:</b>
	<?php echo CHtml::encode($data->reforder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usnum')); ?>:</b>
	<?php echo CHtml::encode($data->usnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descrip')); ?>:</b>
	<?php echo CHtml::encode($data->descrip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ext')); ?>:</b>
	<?php echo CHtml::encode($data->ext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
	<?php echo CHtml::encode($data->remark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refno')); ?>:</b>
	<?php echo CHtml::encode($data->refno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custsku')); ?>:</b>
	<?php echo CHtml::encode($data->custsku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('appmetwt')); ?>:</b>
	<?php echo CHtml::encode($data->appmetwt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemtype')); ?>:</b>
	<?php echo CHtml::encode($data->itemtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemmetal')); ?>:</b>
	<?php echo CHtml::encode($data->itemmetal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metalstamp')); ?>:</b>
	<?php echo CHtml::encode($data->metalstamp); ?>
        <br />

	*/ ?>

</div>