<script type="text/javascript">
$(document).ready(function(){

	var url_s=window.location.href;
	var baseurl = url_s.split('?')[1];
	var baseurl = baseurl.split('&')[0];
	var baseurl = baseurl.split('=')[1];
	
	if (baseurl=="master") {

		$("#select").change(function(){
			var exprt = $('#select').val();
			 window.location.href =  '<?php echo Yii::app()->createurl("export/skuexport"); ?>' + '?export=' + exprt + '&type=master';
		});
	    var url_s=window.location.href;
		var baseurl=url_s.split('&')[1];
		var baseurl = baseurl.split('&')[0];
		var baseurl=baseurl.split('=')[1];
	    if(baseurl){
	        $('#select').val(baseurl);
	    }
	} else{
		$("#select").change(function(){
		var exprt = $('#select').val();
		 window.location.href =  '<?php echo Yii::app()->createurl("export/skuexport"); ?>' + '?export=' + exprt + '&type=skuexport';
		});
		var url_s=window.location.href;
		var baseurl=url_s.split('?')[1];
		var baseurl = baseurl.split('&')[0];
		var baseurl=baseurl.split('=')[1];
	    if(baseurl){
	        $('#select').val(baseurl);
	    }
	}

});
</script>


<?php

$this->breadcrumbs=array(
	'Skuexport',
);
?>

<?php echo CHtml::dropDownList('select', 'Sku Export', array(16=>'Amazon Export',17=>'CA Export',18=>'JOV Export',19=>'VG Export',2=>'Worksheet Export',3=>'Quote Sheet Export',4=>'SN Spec Export',5=>'BB Export',6=>'Boss Export',7=>'Code Me Export',8=>'HT Export',9=>'ZY Export',10 => 'QB Export',11 => 'GKW Export',12 => 'TH Export',13 => 'QOV Export',14 => 'QJC Export',15 => 'JZ Export' , 20 => 'Worksheet New Export' , 21 =>'RS Export', 22=>'SN Fact Export',23=>'Gtdf Export'))?>
<?php if(!empty($_GET) && isset($_GET['export'])) { ?>

<?php if($_GET['export']==16 || $_GET['export']==""){?>


<h1 style="margin-top:30px;"><?php echo "Amazon Export" ?></h1>
<?php echo $this->renderPartial('amform', array('model'=>$modelam)); ?>
<?php echo $this->renderPartial('amnform', array('model'=>$modelamn)); ?>

<?php }else?>
<?php if($_GET['export']==17){?>

<h1 style="margin-top:30px;"><?php echo "CA Export" ?></h1>
<?php echo $this->renderPartial('caform', array('model'=>$modelca)); ?>
<?php echo $this->renderPartial('canform', array('model'=>$modelcan)); ?>

<?php }else?>
<?php if($_GET['export']==18){?>

<h1 style="margin-top:30px;"><?php echo "JOV Export" ?></h1>
<?php echo $this->renderPartial('jovform', array('model'=>$modeljov)); ?>
<?php echo $this->renderPartial('jovnform', array('model'=>$modeljovn)); ?>

<?php }else?>
<?php if($_GET['export']==19){?>

<h1 style="margin-top:30px;"><?php echo "VG Export" ?></h1>
<?php echo $this->renderPartial('vgform', array('model'=>$modelvg)); ?>
<?php echo $this->renderPartial('vgnform', array('model'=>$modelvgn)); ?>

    <?php }else?>
<?php if($_GET['export']==2){?>

<h1 style="margin-top:30px;"><?php echo "Worksheet Export" ?></h1>
<?php echo $this->renderPartial('worksheetiform', array('model'=>$modelwi)); ?>
<?php echo $this->renderPartial('worksheet', array('model'=>$modelex)); ?>

<?php }else?>
<?php if($_GET['export']==3){?>
<h1 style="margin-top:30px;"><?php echo "Quote Sheet Export" ?></h1>
<?php echo $this->renderPartial('quotesheeti', array('model'=>$modelqi)); ?>
<?php echo $this->renderPartial('quotesheet', array('model'=>$modelq)); ?>

<?php }else?>
<?php if($_GET['export']==4){?>
<h1 style="margin-top:30px;"><?php echo "SN Spec Export" ?></h1>
<?php echo $this->renderPartial('sniform', array('model'=>$modelsni)); ?>
<?php echo $this->renderPartial('snform', array('model'=>$modelsn)); ?>


<?php }else?>
<?php if($_GET['export']==5){?>
<h1 style="margin-top:30px;"><?php echo "BB Export" ?></h1>
<?php echo $this->renderPartial('bbiform', array('model'=>$modelbbi)); ?>
<?php echo $this->renderPartial('bbform', array('model'=>$modelbb)); ?>

<?php }else?>
<?php if($_GET['export']==6){?>
<h1 style="margin-top:30px;"><?php echo "Boss Export" ?></h1>
<?php echo $this->renderPartial('bossiform', array('model'=>$modelbossi)); ?>
<?php echo $this->renderPartial('bossform', array('model'=>$modelboss)); ?>

<?php }else?>
<?php if($_GET['export']==7){?>
<h1 style="margin-top:30px;"><?php echo "Code Me Export" ?></h1>
<?php echo $this->renderPartial('codei', array('model'=>$modelcodei)); ?>
<?php echo $this->renderPartial('code', array('model'=>$modelcode)); ?>


<?php }else?>
<?php if($_GET['export']==8){?>
<h1 style="margin-top:30px;"><?php echo "HT Export" ?></h1>
<?php echo $this->renderPartial('hti', array('model'=>$modelhti)); ?>
<?php echo $this->renderPartial('ht', array('model'=>$modelht)); ?>

<?php }else?>
<?php if($_GET['export']==9){?>
<h1 style="margin-top:30px;"><?php echo "ZY Export" ?></h1>
<?php echo $this->renderPartial('zyi', array('model'=>$modelzyi)); ?>
<?php echo $this->renderPartial('zy', array('model'=>$modelzy)); ?>


<?php }else?>
<?php if($_GET['export']==10){?>
<h1 style="margin-top:30px;"><?php echo "QB Export" ?></h1>
<?php echo $this->renderPartial('qbi', array('model'=>$modelqbi)); ?>
<?php echo $this->renderPartial('qb', array('model'=>$modelqb)); ?>

<?php }else?>
<?php if($_GET['export']==11){?>
<h1 style="margin-top:30px;"><?php echo "GKW Export" ?></h1>
<?php echo $this->renderPartial('code_zki', array('model'=>$modelcode_zki)); ?>
<?php echo $this->renderPartial('code_zk', array('model'=>$modelcode_zk)); ?>

<?php }else?>
<?php if($_GET['export']==12){?>
<h1 style="margin-top:30px;"><?php echo "TH Export" ?></h1>
<?php echo $this->renderPartial('code_thi', array('model'=>$modelcode_thi)); ?>
<?php echo $this->renderPartial('code_th', array('model'=>$modelcode_th)); ?>

<?php }else?>
<?php if($_GET['export']==13){?>
<h1 style="margin-top:30px;"><?php echo "QOV Export" ?></h1>
<?php echo $this->renderPartial('qovi', array('model'=>$modelqovi)); ?>
<?php echo $this->renderPartial('qov', array('model'=>$modelqov)); ?>

<?php }else?>
<?php if($_GET['export']==14){?>
<h1 style="margin-top:30px;"><?php echo "QJC Export" ?></h1>
<?php echo $this->renderPartial('qjci', array('model'=>$modelqjci)); ?>
<?php echo $this->renderPartial('qjc', array('model'=>$modelqjc)); ?>

<?php }else?>
<?php if($_GET['export']==15){?>
<h1 style="margin-top:30px;"><?php echo "JZ Export" ?></h1>
<?php echo $this->renderPartial('jzi', array('model'=>$modeljzi)); ?>
<?php echo $this->renderPartial('jz', array('model'=>$modeljz)); ?>

<?php }else?>
<?php if($_GET['export']==21){?>
<h1 style="margin-top:30px;"><?php echo "RS Export" ?></h1>
<?php echo $this->renderPartial('rsi', array('model'=>$modelrsi)); ?>
<?php echo $this->renderPartial('rs', array('model'=>$modelrs)); ?>

<?php }else?>
<?php if($_GET['export']==22){?>
<h1 style="margin-top:30px;"><?php echo "SN Fact Export" ?></h1>
<?php echo $this->renderPartial('snni', array('model'=>$modelsnni)); ?>
<?php echo $this->renderPartial('snn', array('model'=>$modelsnn)); ?>

<?php }else?>
<?php if($_GET['export']==20){?>
<h1 style="margin-top:30px;"><?php echo "Worksheet New Export" ?></h1>
<?php echo $this->renderPartial('worksheetinewform', array('model'=>$modelnewwi)); ?>
<?php echo $this->renderPartial('worksheetnew', array('model'=>$modelnewex)); ?>

<?php }else ?>
<?php if($_GET['export']==23){?>
<h1 style="margin-top:30px;"><?php echo "GTDF Export" ?></h1>
<?php echo $this->renderPartial('gtdfi', array('model'=>$modelgtdfi)); ?>
<?php echo $this->renderPartial('gtdf', array('model'=>$modelgtdf)); ?>


<?php } }else { ?>
<h1 style="margin-top:30px;"><?php echo "Amazon Export" ?></h1>
<?php echo $this->renderPartial('amform', array('model'=>$modelam)); ?>
<?php echo $this->renderPartial('amnform', array('model'=>$modelamn)); }?>
    


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
