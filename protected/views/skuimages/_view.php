<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskuimages')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idskuimages), array('view', 'id'=>$data->idskuimages)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idsku')); ?>:</b>
	<?php echo CHtml::encode($data->idsku0->skucode); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclient')); ?>:</b>
	<?php echo CHtml::encode($data->idclient0->name); ?>

        <b><?php echo CHtml::encode($data->getAttributeLabel('updby')); ?>:</b>
	<?php echo CHtml::encode($data->iduser0->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('imgalt')); ?>:</b>
	<?php echo CHtml::encode($data->imgalt); ?>
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