<div width="100%">
	<div width="50%">
		<table>
			<?php $form=$this->beginWidget('ext.wvactiveform.wvActiveForm', array(
			'id'=>'metalm-form',
			'enableAjaxValidation'=>false,'layoutName'=>'qtip'
			)); ?>
			<?php if(Yii::app()->user->hasFlash('error')):?>
			    <div class="warning" style="color:#c20f2e">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php endif; ?>
			<tr>
				<td class="label"> <?php echo $form->labelEx($model,'srate'); ?> </td>
				<td class="field"> <?php echo $form->textField($model,'srate'); ?>
					<span class="">P.Onz</span>
					<?php echo $form->error($model,'srate'); ?>
				</td>
				<td rowspan="2"> <?php echo CHtml::submitButton('Update',array('class'=>'primaryAction')); ?></td>
			</tr>
			<tr>
				<td class="label"> <?php echo $form->labelEx($model,'grate'); ?> </td>
				<td class="field"> <?php echo $form->textField($model,'grate'); ?>
					<span class="">P.Onz</span>
					<?php echo $form->error($model,'grate'); ?>
				</td>
			</tr>
			<?php $this->endWidget(); ?>
		</table>
	</div>
</div>
<style type="text/css">
	.label{
		width:17%!important;
		color:#c20f2e;
	}
	.field{
		width:33%!important;
	}
</style>