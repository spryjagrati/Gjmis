<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
 
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_new.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/uni-form_new.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/brown.uni-form.css" />
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/sprytechies.js"></script>
        <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/uni-form.jquery.js">-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo" style="color:#000000;"><?php echo CHtml::image(Yii::app()->request->baseUrl."/images/logo.png"); ?>
            	   <span id="sitename"><?php echo CHtml::encode("GALLANT MIS"); ?></span>
	</div><!-- header -->
       
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                            array('label'=>'SKU', 'url'=>array('/product/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'OnlySku', 'url'=>array('/sku/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Content', 'url'=>array('/skucontent/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Images', 'url'=>array('/skuimages/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Client Rel', 'url'=>array('/skuselmap/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stones', 'url'=>array('/skustones/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Metals', 'url'=>array('/skumetals/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Findings', 'url'=>array('/skufindings/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'AddOn', 'url'=>array('/skuaddon/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Export', 'url'=>Yii::app()->getModule('export')->exportUrl, 'visible'=>!Yii::app()->user->isGuest),
                                //array('label'=>'Export', 'url'=>array('/skuexport'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Aliases', 'url'=>array('/aliases/create'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Categories', 'url'=>array('/category/create'), 'visible'=>!Yii::app()->user->isGuest),
                            )),
                            array('label'=>'PurchaseOrder', 'url'=>array('/purchaseOrder/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'PO Details', 'url'=>array('/po/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'PO Skus', 'url'=>array('/poskus/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'PO Status Log', 'url'=>array('/postatuslog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'PO Sku Status', 'url'=>array('/poskustatus/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'PO Sku Status Log', 'url'=>array('/poskustatuslog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Dept', 'url'=>array('/dept/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'Sku Stocks', 'url'=>array('/deptskulog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Finding Stocks', 'url'=>array('/deptfindlog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Chemical Stocks', 'url'=>array('/deptchemlog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Metal Stocks', 'url'=>array('/deptmetallog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Stocks', 'url'=>array('/deptstonelog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Vouchers', 'url'=>array('/stonevoucher/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Material Req', 'url'=>array('/matreq/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Mat Req Log', 'url'=>array('/matreqlog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                )),
                            array('label'=>'Reports', 'url'=>array('/reports/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin(),'items'=>array(
                                array('label'=>'Dept Stone Report', 'url'=>array('/reports/stoneReport'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Dept Metal Report', 'url'=>array('/reports/metalReport'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Dept Sku Report', 'url'=>array('/reports/skuReport'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Stock Report', 'url'=>array('/reports/stoneStockReport'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Stock Summary', 'url'=>array('/reports/stoneSummary'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Stock Detail', 'url'=>array('/reports/stoneStockDetail'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Stone Stock Ledger', 'url'=>array('/reports/stoneStockLedger'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label'=>'Location Stock Ledger', 'url'=>array('/reports/locationStockLedger'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                
                                 )),
                            array('label'=>'Client', 'url'=>array('/client/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin(),'items'=>array(
                                array('label'=>'Client Params', 'url'=>array('/clientparams/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Cost Add', 'url'=>array('/costadd/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'Metal', 'url'=>array('/metal/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Stone', 'url'=>array('/stone/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Setting', 'url'=>array('/setting/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Chemical', 'url'=>array('/chemical/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Findings', 'url'=>array('/finding/admin'), 'visible'=>!Yii::app()->user->isGuest),
                            )),
                            array('label'=>'Metal', 'url'=>array('/metal/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'MetalM', 'url'=>array('/metalm/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Stamp', 'url'=>array('/metalstamp/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Cost Log', 'url'=>array('/metalcostlog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Stone', 'url'=>array('/stone/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                                array('label'=>'Shape', 'url'=>array('/shape/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Clarity', 'url'=>array('/clarity/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'StoneM', 'url'=>array('/stonem/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Size', 'url'=>array('/stonesize/admin'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Cost Log', 'url'=>array('/stonecostlog/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                             // array('label'=>'Stone Alias', 'url'=>array('/stonealias/create'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'StatusM', 'url'=>array('/statusm/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin(),'items'=>array(
                                array('label'=>'Navigation', 'url'=>array('/statusnav/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Upload', 'url'=>array('/importcsv'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            array('label'=>'Transactions', 'url'=>'javascript:void(0)', 'visible'=>Yii::app()->getModule('user')->isAdmin(), 'items' => array(
                                array('label'=>'Invoices', 'url'=>array('/invoice/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                                array('label' => 'Approval Memo', 'url' => array('/memo/approval'), 'visible' => Yii::app()->getModule('user')->isAdmin()),
                                array('label' => 'Quote', 'url' => array('/memo/quote'), 'visible' => Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Locations', 'url'=>array('/locations/admin'), 'visible'=>!Yii::app()->user->isGuest,'items'=>array(
                            array('label'=>'Location Stocks', 'url'=>array('/reports/locationstocks'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            )),
                            array('label'=>'Keywords', 'url'=>array('/keywords/admin'), 'visible'=>Yii::app()->getModule('user')->isAdmin()),
                            
                            array('label'=>'Master', 'url'=>array('/product/master'), 'visible'=>!Yii::app()->user->isGuest ,'items'=>array(
                                    array('label' => 'Exports', 'url'=>Yii::app()->getModule('export')->exportUrl, 'visible'=>!Yii::app()->user->isGuest),
                                )),
                            
				/*array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)*/
                                array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
                                //array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
                                array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
                                array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Contact', 'url'=>array('/site/contact'), 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Gallant Jewelry.<br/>
		All Rights Reserved.<br/>
		<?php echo (Yii::app()->params['sprypowered']); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
