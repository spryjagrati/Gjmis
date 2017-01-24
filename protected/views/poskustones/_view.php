<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idtbl_poskustones')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idtbl_poskustones), array('view', 'id'=>$data->idtbl_poskustones)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idposku')); ?>:</b>
	<?php echo CHtml::encode($data->idposku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idskustone')); ?>:</b>
	<?php echo CHtml::encode($data->idskustone); ?>
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


</div>