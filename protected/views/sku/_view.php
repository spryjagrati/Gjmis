<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idsku), array('view', 'id'=>$data->idsku)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('skucode')); ?>:</b>
	<?php echo CHtml::encode($data->skucode); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('leadtime')); ?>:</b>
	<?php echo CHtml::encode($data->leadtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('refpo')); ?>:</b>
	<?php echo CHtml::encode($data->refpo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('parentsku')); ?>:</b>
	<?php echo CHtml::encode($data->parentsku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentrel')); ?>:</b>
	<?php echo CHtml::encode($data->parentrel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxcode')); ?>:</b>
	<?php echo CHtml::encode($data->taxcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimunit')); ?>:</b>
	<?php echo CHtml::encode($data->dimunit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimdia')); ?>:</b>
	<?php echo CHtml::encode($data->dimdia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimhei')); ?>:</b>
	<?php echo CHtml::encode($data->dimhei); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimwid')); ?>:</b>
	<?php echo CHtml::encode($data->dimwid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dimlen')); ?>:</b>
	<?php echo CHtml::encode($data->dimlen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('totmetalwei')); ?>:</b>
	<?php echo CHtml::encode($data->totmetalwei); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('metweiunit')); ?>:</b>
	<?php echo CHtml::encode($data->metweiunit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('totstowei')); ?>:</b>
	<?php echo CHtml::encode($data->totstowei); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stoweiunit')); ?>:</b>
	<?php echo CHtml::encode($data->stoweiunit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numstones')); ?>:</b>
	<?php echo CHtml::encode($data->numstones); ?>
	<br />

	*/ ?>

</div>