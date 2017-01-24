<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonecostlog')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstonecostlog), array('view', 'id'=>$data->idstonecostlog)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstone')); ?>:</b>
	<?php echo CHtml::encode($data->idstone); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />


</div>