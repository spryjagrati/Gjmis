<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonem')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstonem), array('view', 'id'=>$data->idstonem)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:
	<b><?php echo CHtml::encode($data->type); ?></b>
	<br />

	<?php echo CHtml::encode($data->getAttributeLabel('scountry')); ?>:
	<b><?php echo CHtml::encode($data->scountry); ?></b>
	<br />

	<?php echo CHtml::encode($data->getAttributeLabel('creatmeth')); ?>:
	<b><?php echo CHtml::encode($data->creatmeth); ?></b>
	<br />

	<?php echo CHtml::encode($data->getAttributeLabel('treatmeth')); ?>:
	<b><?php echo CHtml::encode($data->treatmeth); ?></b>
	<br />

</div>