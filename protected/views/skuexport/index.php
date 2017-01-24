<script type="text/javascript">
$(document).ready(function(){
	$("#select").change(function(){
		var exprt = $('#select').val();
		 window.location.href =  '<?php echo Yii::app()->createurl("skuexport"); ?>' + '?export=' + exprt;
	});
        var query = window.location.search.split('=') ;
        if(query){
            $('#select').val(query[1]);
        }
});
</script>


<?php

$this->breadcrumbs=array(
	'Skuexport',
);

 $count=Yii::app()->db->createCommand('select skucode from tbl_sku')->queryAll();
                    foreach($count as $c)
                    {$i=0;$query[]=$c['skucode'];$i++;}
                    ?>
<?php echo CHtml::dropDownList('select', 'Sku Export', array(1=>'Sku Export',2=>'Worksheet Export',3=>'Quote Sheet Export',4=>'SN Export',5=>'BB Export',6=>'Boss Export',7=>'Code Me Export',8=>'HT Export', 9 =>'ZY Export',10 =>'QB Export'))?>
<?php if($_GET['export']==1 || $_GET['export']==""){?>


<h1 style="margin-top:30px;"><?php echo "SKU Export" ?></h1>
<?php echo $this->renderPartial('export', array('model'=>$model, 'query'=>$query)); ?>
<?php echo $this->renderPartial('exportn', array('model'=>$modeln, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==2){?>

<h1 style="margin-top:30px;"><?php echo "Worksheet Export" ?></h1>
<?php echo $this->renderPartial('worksheetiform', array('model'=>$modelwi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('worksheet', array('model'=>$modelex, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==3){?>
<h1 style="margin-top:30px;"><?php echo "Quote Sheet Export" ?></h1>
<?php echo $this->renderPartial('quotesheeti', array('model'=>$modelqi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('quotesheet', array('model'=>$modelq, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==4){?>
<h1 style="margin-top:30px;"><?php echo "SN Export" ?></h1>
<?php echo $this->renderPartial('sniform', array('model'=>$modelsni, 'query'=>$query)); ?>
<?php echo $this->renderPartial('snform', array('model'=>$modelsn, 'query'=>$query)); ?>


<?php }else?>
<?php if($_GET['export']==5){?>
<h1 style="margin-top:30px;"><?php echo "BB Export" ?></h1>
<?php echo $this->renderPartial('bbiform', array('model'=>$modelbbi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('bbform', array('model'=>$modelbb, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==6){?>
<h1 style="margin-top:30px;"><?php echo "Boss Export" ?></h1>
<?php echo $this->renderPartial('bossiform', array('model'=>$modelbossi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('bossform', array('model'=>$modelboss, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==7){?>
<h1 style="margin-top:30px;"><?php echo "Code Me Export" ?></h1>
<?php echo $this->renderPartial('codei', array('model'=>$modelcodei, 'query'=>$query)); ?>
<?php echo $this->renderPartial('code', array('model'=>$modelcode, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==8){?>
<h1 style="margin-top:30px;"><?php echo "HT Export" ?></h1>
<?php echo $this->renderPartial('hti', array('model'=>$modelhti, 'query'=>$query)); ?>
<?php echo $this->renderPartial('ht', array('model'=>$modelht, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==9){?>
<h1 style="margin-top:30px;"><?php echo "ZY Export" ?></h1>
<?php echo $this->renderPartial('zyi', array('model'=>$modelzyi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('zy', array('model'=>$modelzy, 'query'=>$query)); ?>

<?php }else?>
<?php if($_GET['export']==10){?>
<h1 style="margin-top:30px;"><?php echo "QB Export" ?></h1>
<?php echo $this->renderPartial('qbi', array('model'=>$modelqbi, 'query'=>$query)); ?>
<?php echo $this->renderPartial('qb', array('model'=>$modelqb, 'query'=>$query)); ?>


<?php } ?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sku-grid',
	'dataProvider'=>$models->search(),
	'filter'=>$models,
	'columns'=>array(
		'idsku',
		'skucode',
		'cdate',
		'mdate',
		array('name'=>'updby','type'=>'raw','value'=>'$data->iduser0->username'),
		'refpo',
		'totmetalwei',
		'totstowei',
		'numstones',
		/*
		'leadtime',
		'parentsku',
		'parentrel',
		'taxcode',
		'dimunit',
		'dimdia',
		'dimhei',
		'dimwid',
		'dimlen',
		'metweiunit',
		'stoweiunit',
		*/
		
	),
)); ?>
