<?php
/* @var $this AliasesController */
/* @var $data Aliases */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aTarget')); ?>:</b>
	<?php echo CHtml::encode($data->aTarget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aField')); ?>:</b>
	<?php echo CHtml::encode($data->aField); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initial')); ?>:</b>
	<?php echo CHtml::encode($data->initial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo CHtml::encode($data->alias); ?>
	<br />


</div>