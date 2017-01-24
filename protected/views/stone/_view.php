<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstone')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstone), array('view', 'id'=>$data->idstone)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namevar')); ?>:</b>
	<?php echo CHtml::encode($data->namevar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idshape')); ?>:</b>
	<?php echo CHtml::encode($data->idshape0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idclarity')); ?>:</b>
	<?php echo CHtml::encode($data->idclarity0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonem')); ?>:</b>
	<?php echo CHtml::encode($data->idstonem0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonesize')); ?>:</b>
	<?php echo CHtml::encode($data->idstonesize0->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('scountry')); ?>:</b>
	<?php echo CHtml::encode($data->scountry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cut')); ?>:</b>
	<?php echo CHtml::encode($data->cut); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('quality')); ?>:</b>
	<?php echo CHtml::encode($data->quality); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creatmeth')); ?>:</b>
	<?php echo CHtml::encode($data->creatmeth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatmeth')); ?>:</b>
	<?php echo CHtml::encode($data->treatmeth); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('curcost')); ?>:</b>
	<?php echo CHtml::encode($data->curcost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prevcost')); ?>:</b>
	<?php echo CHtml::encode($data->prevcost); ?>
	<br />

	
</div>