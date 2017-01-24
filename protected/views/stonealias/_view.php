<?php
/* @var $this StonealiasController */
/* @var $data Stonealias */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstone_alias')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstone_alias), array('view', 'id'=>$data->idstone_alias)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstonem')); ?>:</b>
	<?php echo CHtml::encode($data->idstone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('export')); ?>:</b>
	<?php echo CHtml::encode($data->export); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idproperty')); ?>:</b>
	<?php echo CHtml::encode($data->idproperty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />


</div>