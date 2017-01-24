<?php

class InvoiceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2_new';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
                        
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','InvoiceExport', 'Invoiceaction', 'availAmount','returnInvoice', 'genCreditnote','externalInvoice'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
                    
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','InvoiceExport','Invoiceaction', 'availAmount','returnInvoice','admin', 'genCreditnote','externalInvoice'),
				'users'=>array('@'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(53, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $model=new Invoice;
            $loc_model = new Locationinvoice;
            
            if(isset($_POST['Invoice']['idlocation'])){
                $dept = Dept::model()->findByPk($_POST['Invoice']['idlocation']);
            }else{
                $dept = 1;
            }
            
            $image = new Skuimages;
            $skus=new Sku('search');

            $skus->unsetAttributes();  // clear any default values
            if(isset($_GET['Sku']))
                    $skus->attributes=$_GET['Sku'];
                    $imageUrl=$image->imageThumbUrl;   
            
            /**
             * Removed Po codes
             * Locationinvoice && invoice
             * by Sprymohit
             * 23-05-2014
             */
            if(isset($_POST['Invoice']) && isset($_POST["Skus"]))
            {  
                if(empty($_POST["Skus"])){
                    Yii::app()->user->setFlash('fail', "Invoice cannot be generated. Check the Sku ".$skuname."");
                    $this->redirect(array('create'));
                }
                else{
                      
                /**
                * Checking if sku is present in location stocks.
                * if not then give validation error.
                */
                $skunames = explode(",", $_POST["Skus"]); 
                foreach($skunames as $key=>$value){
                    if(trim($skunames[$key]) == ''){
                        unset($skunames[$key]);
                    }
                }
                foreach($skunames as $skuname){
                    $sku = Sku::model()->findByAttributes(array('skucode'=>trim($skuname)));
                    $locationstocks = Locationstocks::model()->findAllByAttributes(array('idsku'=>$sku->idsku,'iddept'=>($_POST['Invoice']['idlocation'])));

                    if(!isset($sku)){
                        Yii::app()->user->setFlash('fail', "Invoice cannot be generated. Check the Sku ".$skuname."");
                        $this->redirect(array('create'));
                    }
                   
                    if(count($locationstocks) < 1){ // dont have location stocks 
                        Yii::app()->user->setFlash('fail', "Sku id = ".$skuid." stock is not there in the location");
                         $this->redirect(array('create'));
                    }
                }
               
                // --ends

                if(isset($_POST['Locationinvoice'])){
                    $invoice = Invoice::model()->latest()->find();
                    $model->idinvoice = isset($invoice) ? $invoice->idinvoice + 1 : 1;
                    $model->attributes = $_POST['Invoice'];
                    $model->createdby =Yii::app()->user->id; 
                    $model->deptto = $_POST['Invoice']['deptto'];
                    $model->idlocation = $_POST['Invoice']['idlocation'];
                    $inv = Invoice::model()->findAllByAttributes(array('idlocation'=>$model->idlocation));

                    // -- invoice number for same department
                    $total_invoice = array();
                    foreach($inv as $value){
                        $total_invoice[$model->idlocation] = $value->invoice_num;
                    }
                    if(empty($total_invoice))
                        $model->invoice_num = 1;
                    else
                        $model->invoice_num = max($total_invoice)+1;
                    // -- ends

                    $model->save();

                    foreach($skunames as $skuname){
                        $sku = Sku::model()->findByAttributes(array('skucode'=>trim($skuname)));
                        $locationstocks =  Locationstocks::model()->findAllByAttributes(array('idsku'=>$sku->idsku,'iddept'=>$_POST['Invoice']['idlocation']));

                        foreach($locationstocks as $locationstock){
                            $invoiceposku = new Invoiceposkus();
                            $invoiceposku->idinvoice = $model->idinvoice;
                            $invoiceposku->activ = 1;
                            $invoiceposku->idsku = $sku->idsku;
                            $invoiceposku->idlocationstocks = $locationstock->idlocationstocks;
                            $invoiceposku->movements = 1; 
                            $invoiceposku->save(false);
                        }
                    } 
                        
                    $loc_model->attributes = $_POST['Locationinvoice'];
                    $loc_model->idinvoice = $model->idinvoice;
                    $loc_model->idlocation = $model->idlocation;
                    $loc_model->save(false);
                    
                    $this->redirect(array('update','id'=>$model->idinvoice));
                }
                }
            }
            $this->render('create',array(
                    'model'=>$model,'loc_model'=>$loc_model,'skus'=>$skus,'imageUrl'=>$imageUrl
            ));
	}
          

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{   
            
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(53, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            
			   $model=$this->loadModel($id);
                $loc_model = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$id));
                if(!isset($loc_model)){
                    $loc_model = new Locationinvoice;
                }
                $invoiceposkus = Invoiceposkus::model()->findAll("idinvoice = :idinvoice", array(":idinvoice"=>$id));
                
                $pos = array(); $skus = array();  $skuids = array();
                
                foreach($invoiceposkus as $invoiceposku){
                   $pos[] = $invoiceposku->idpo;
                   $skus[] = $invoiceposku->idsku0->skucode;
                   $skuids[] = $invoiceposku->idsku;
                   if($invoiceposku->activ == 1)
                   $activinposkus[] = $invoiceposku->idposkus;
                }
                
                $pos = array_unique($pos); $skus = array_unique($skus);$skuids = array_unique($skuids);
                $pos = implode(',',$pos); $skus = implode(',',$skus); $skuids = implode(',',$skuids); 
               
                             
               if(isset($_POST['empty']) && isset($_POST['shipped'])){
                        
                        if(isset($_POST['ship'])){
                            $model->ship = $_POST['ship'];
                            $model->save();
                        } 
                        
                       
                    foreach($_POST['shipped'] as $key=>$value){
                        // key = idlocationstocks, value = shipping quantity
                        
                        $locstocks = Locationstocks::model()->findByPk($key);
                        $posku = Invoiceposkus::model()->findByAttributes(array('idinvoice'=>$id,'idsku'=>$locstocks->idsku,'movements'=>1));
                        
                        if(($locstocks->totqty ) < ($locstocks->qtyship + ($value - $posku->shipqty))){
                             Yii::app()->user->setFlash('fail', "Entered quantity should be less than or equal to available quantity to ship for sku = ". $locstocks->idsku0->skucode);
                              $this->redirect(array('update','id'=>$id));
                        }else{
                           if($value != $posku->shipqty && $value >= 0){ 
                            $sku = Sku::model()->findByPk($locstocks->idsku);
                            if($model->deptto!=0){
                                /**
                                 * adding value from qtyship: that means if one item is shipped then 
                                 * one will be add in location stock 
                                 * value : entered by user - no. of qty to be shipped
                                 */
                                // Dept From
								$addition = $value - $posku->shipqty;
                                $locstocks->qtyship = ($locstocks->qtyship + ($value - $posku->shipqty));
                                $locstocks->totwt = ($locstocks->totqty - $locstocks->qtyship)* $sku->grosswt;
                                $locstocks->totstone = ($locstocks->totqty - $locstocks->qtyship)* $sku->totstowei;
                                $locstocks->totmetwt = ($locstocks->totqty - $locstocks->qtyship)* $sku->totmetalwei;
                                $locstocks->save();
								 $posku->shipqty = $value;
                                  $posku->save(false);
                                
                                // Dept To
                                $loc =  Locationstocks::model()->findByAttributes(array('idsku'=>$locstocks->idsku,'iddept'=>$model->deptto));
								
                                if(isset($loc)){
                                    $loc->totqty = $loc->totqty +($addition); //total quantity which is shipped to dept.
                                    $loc->totwt = ($loc->totqty-$loc->qtyship)*$sku->grosswt;
                                    $loc->totstone = ($loc->totqty-$loc->qtyship)*$sku->totstowei;
                                    $loc->totmetwt = ($loc->totqty-$loc->qtyship)*$sku->totmetalwei;
									
                                    if($loc->save(false)){
                                        $posku2 = Invoiceposkus::model()->findByAttributes(array('idinvoice'=>$id,'idsku'=>$locstocks->idsku,'idpo'=>$locstocks->po_num,'movements'=>2));   
                                       if(!empty($posku2)){                                                                            
                                        $posku2->shipqty = $value;
                                        $posku2->save(false);
                                    }
                                 } 
                                }
                                else{
                                    
                                    $loc = new Locationstocks;
                                    $loc->totqty = $locstocks->qtyship;
                                    $loc->totwt = ($locstocks->qtyship)* $sku->grosswt;
                                    $loc->totstone = ($locstocks->qtyship)* $sku->totstowei;
                                    $loc->totmetwt = ($locstocks->qtyship)* $sku->totmetalwei;  
                                    $loc->totmetwt = $loc->totqty*$sku->totmetalwei;
                                    $loc->locref = $locstocks->locref;
                                    $loc->iddept = $model->deptto;
                                    $loc->idsku = $locstocks->idsku;
                                    $loc->pricepp = $locstocks->pricepp;
                                    if($loc->save(false)){
                                        $invoiceposku = new Invoiceposkus();
                                        $invoiceposku->idinvoice = $posku->idinvoice;
                                        $invoiceposku->activ = 1;
                                        $invoiceposku->idsku = $sku->idsku;
					$invoiceposku->shipqty = $locstocks->qtyship;
                                        $invoiceposku->idpo = $loc->po_num;
                                        $invoiceposku->idlocationstocks = $loc->idlocationstocks;
                                        $invoiceposku->movements = 2; //deptto

                                        $invoiceposku->save(false);
                                    }
                                }
                            
                            }
                            else{
                                //Dept to
                                /**
                                * 
                                * by Sprymohit
                                * 14-05-2014
                                */
								
                                $loc =  Locationstocks::model()->findByAttributes(array('idsku'=>$locstocks->idsku,'iddept'=>$model->idlocation));
                              
                                if(isset($loc)){
                                    $loc->qtyship = ($loc->qtyship + ($value - $posku->shipqty));
                                    $loc->totwt =($loc->totqty-$loc->qtyship)*$sku->grosswt;
                                    $loc->totstone = ($loc->totqty-$loc->qtyship)*$sku->totstowei;
                                    $loc->totmetwt = ($loc->totqty-$loc->qtyship)*$sku->totmetalwei;
                                    $loc->locref = $locstocks->locref;
                                    $loc->pricepp = $locstocks->pricepp;
                                    $loc->save();
                                }
                            }
                            	
                                $posku->shipqty =$value;
                                $posku->save(false);
                            }
                        }
                        Deptskulog::feedInvoicedata($model);
                    }
                    
                  }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
               if(isset($_POST['Locationinvoice'])){
                    $loc_model->attributes = $_POST['Locationinvoice'];
                    $loc_model->idlocation = $model->idlocation;
                    $loc_model->save(false);
               }
                    
                   // echo"<pre>";var_dump($skuids);die;
                        $inposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$id,'movements'=>1));
                      

						$poskuz = array();
						foreach($inposkus as $poskus){
							array_push($poskuz, $poskus->idlocationstocks);
						}
                        $poskuz = implode(',',$poskuz);
						
                     $dataProvider=new CActiveDataProvider('Locationstocks', array(
                    'criteria'=>array(
                         'condition'=>'idlocationstocks in ('.$poskuz.')',
                        ),
                    'pagination'=>array(
                        'pageSize'=>50,
                )));
                     $po_data = $dataProvider;
                     
               
                /**
                 * Updating InvoiceFields
                 */
		if(isset($_POST['Invoice']))
		{   
			$model->attributes=$_POST['Invoice'];
                        if($model->iddept0->idlocation != 1){
                            $invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$model->idinvoice));
                            foreach($invoiceposkus as $invoiceposku){
                            $invoiceposku->activ = $_POST['Invoice']['activ'];
                            $invoiceposku->save();
                        }
                        $locationinvoice = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$model->idinvoice, 'idlocation' => $model->idlocation));
                        $locationinvoice->attributes = $_POST['Locationinvoice'];
                        }
                        
                        if (isset($_POST['Invoice']['deptto']))
                            $model->deptto=$_POST['Invoice']['deptto'];
                         
			if($model->save(false))
				$this->redirect(array('update','id'=>$model->idinvoice));
		}
               
		$this->render('update',array(
			'model'=>$model,'po_data'=>$po_data,'activinposkus'=>$activinposkus,'loc_model'=>$loc_model,
                        'pos'=>$pos,'skus'=>$skus
		));
	}
        
        

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(53, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		if(Yii::app()->request->isPostRequest)
		{
                        $invoiceposkus = Invoiceposkus::model()->findAll("idinvoice = :idinvoice", array(":idinvoice"=>$id));
                        foreach($invoiceposkus as $invoiceposku){
                            $invoiceposku->delete();
                        }
                        
                        $returninvoice = Invoicereturn::model()->findByAttributes(array("idinvoice"=>$id));
                        if(isset($returninvoice))
                            $returninvoice->delete();
                        
                        $locationinvoice = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$id));
                        if(isset($locationinvoice))
                            $locationinvoice->delete();
                        
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		 $criteria=new CDbCriteria;
        	 $id= Yii::app()->user->id;
        	 $user=User::model()->findByPk($id);
       	         if($id !== '1'){
            		$criteria->compare('idlocation', $user['iddept']);
           		 $criteria->compare('createdby',$id);  
                 }  
		$dataProvider=new CActiveDataProvider('Invoice', array(
        		    'criteria'=>$criteria));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(53, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }

            $model=new Invoice('search');
            $model->unsetAttributes();  // clear any default values

            if(isset($_GET['Invoice']))
                    $model->attributes=$_GET['Invoice'];

            $this->render('admin',array(
                    'model'=>$model
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Invoice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        /**
         * Download PKG sheet in excel format
         * Selected Skus are used for generating PKG sheets and then they are used to generate 
         * final invoices
         */
        public function actionInvoiceExport($id){
           
            //Do all DB processing before loading PHPExcel
             $invoice_array = array();
             $metaltype = array();
             $Invoice = Invoice::model()->findbypk($id); 
             
            
              if(true){  
                 $this->actionExternalInvoice($id);
             }else{
                 $invposku = Invoiceposkus::model()->find("idinvoice=:idinvoice AND activ=:activ AND movements=:movements", array(":idinvoice"=>$id, "activ"=>1,'movements'=>1));
             $Invoiceposkus = Invoiceposkus::model()->findAll("idinvoice=:idinvoice AND activ=:activ AND movements=:movements", array(":idinvoice"=>$id, "activ"=>1,'movements'=>1)); 
            
            
             if(!isset($Invoiceposkus))
                $Invoiceposkus = Invoiceposkus::model()->findAll("idinvoice=:idinvoice AND activ=:activ AND movements=:movements", array(":idinvoice"=>$id, "activ"=>1,'movements'=>2)); 
              
              if(empty($Invoiceposkus)){
                    Yii::app()->user->setFlash('error', "Invoice cannot be exported. Please check your entries again.");
                    $this->redirect(array('admin'));
                }
             foreach($Invoiceposkus as $Invoiceposku){
                
                $purchase_order = $Invoiceposku->idpo;
                $sku = Sku::model()->findByPk($invposku->idsku);
                $qty = $Invoiceposku->idposkus0->qty;
                if(isset($Invoiceposku->idposkus0->qty)){
                $ppc = ($Invoiceposku->idposkus0->totamt / $Invoiceposku->idposkus0->qty);}
                $skumetal=$sku->skumetals[0];
                $metal=$skumetal->idmetal0->namevar;
                $metalcost=$skumetal->idmetal0->currentcost*$skumetal->weight;
                $metalstamp=$skumetal->idmetal0->idmetalstamp0->name;
                $idclient = $Invoiceposku->idposkus0->idpo->idclient->name;
                $skucontent=$sku->skucontent;
                $skustones=$sku->skustones;
                $invoice['id'] =$Invoiceposku->idinvoice;
                $invoice['date'] = $Invoiceposku->mdate;
                
                $pre_stones_id = array (81, 52, 59, 21, 30, 33, 50, 52, 5, 8, 25, 28, 43, 46, 53, 64 );
                $semi_stones_id = array (40, 9, 36, 39, 44, 47, 56, 58, 65, 68, 20, 31, 86, 10, 23, 27, 34, 84, 19, 26, 70, 15, 29, 57, 6, 13, 14, 16, 18, 22, 32, 35, 37, 38, 41, 48, 49, 51, 54, 55, 60, 62, 63, 67, 71, 73, 74, 75, 76, 77, 78, 79, 80, 82, 83, 85, 87, 88 );
                $diamond_id = array( 4, 7, 11, 12, 17, 24, 42, 45, 61, 66, 69, 72);
                $pre_stones_amt = 0;
                $semi_stones_amt = 0;
                $diamond_amt = 0;
                $diamond_wt = 0;
                
                foreach ($skustones as $skustone){
                if(in_array($skustone->idstone, $pre_stones_id)){
                    $pre_stones_amt += ($skustone->pieces * $skustone->idstone0->curcost);
                }
                if(in_array($skustone->idstone, $semi_stones_id)){
                    $semi_stones_amt += ($skustone->pieces * $skustone->idstone0->curcost);
                }
                if(in_array($skustone->idstone, $diamond_id)){
                    $diamond_amt += ($skustone->pieces * $skustone->idstone0->curcost);
                    $diamond_wt += ($skustone->pieces * $skustone->idstone0->weight);
                }
                
                $stones[]=array('id'=>$skustone->idstone, 'pieces'=>$skustone->pieces,'setting'=>$skustone->idsetting0->name,'color'=>$skustone->idstone0->color,
                    'clarity'=>$skustone->idstone0->idclarity0->name,'shape'=>$skustone->idstone0->idshape0->name,'size'=>$skustone->idstone0->idstonesize0->size,'cmeth'=>$skustone->idstone0->creatmeth,
                    'tmeth'=>$skustone->idstone0->treatmeth,'name'=>$skustone->idstone0->namevar,'weight'=>$skustone->idstone0->weight,'stonem'=>$skustone->idstone0->idstonem);
                }
                
                $cost=ComSpry::calcSkuCostArray($Invoiceposku->idposkus0->idsku);
                $currentcost=$skumetal->idmetal0->currentcost;
                $date = $Invoiceposku->idinvoice0->mdate;
                $findwt=Sku::model()->getDbConnection()->createCommand('select sum(fg.weight*sf.qty) wt from {{skufindings}} sf, {{finding}} fg where sf.idsku='.$Invoiceposku->idsku.' and sf.idfinding=fg.idfinding')->queryScalar();
                $totalsku[$skumetal->idmetal0->idmetalm0->name][]=array($sku->attributes,$skucontent->attributes,$stones,$metal,$metalcost,$metalstamp,$currentcost,$date,$purchase_order,$findwt,$qty,$ppc,$Invoiceposku->idposkus0->totamt,$idclient,'pre_stones_amt'=>$pre_stones_amt, 'semi_stones_amt'=>$semi_stones_amt, 'diamond_amt'=>$diamond_amt, 'labor_cost'=> $cost['labor'],'diamond_wt'=>$diamond_wt);
             }
             
             $totqty = array();
             
            $stone_array = array(
                 'N' => array( 81, 52, 59 ),
                 'O' => array( 21, 30, 33, 50, 52),
                 'P' => array( 5, 8, 25, 28, 43, 46, 53, 64 ),
                 'Q' => array( 40 ),
                 'R' => array( 9, 36, 39, 44, 47, 56, 58, 65, 68 ),
                 'S' => array( 20 ),
                 'T' => array( 31, 86 ),
                 'U' => array( 10, 23, 27, 34, 84 ),
                 'V' => array( 19, 26, 70 ),
                 'W' => array( 15 ),
                 'AB' => array( 4, 7, 11, 12, 17, 24, 42, 45, 61, 66, 69, 72 ),
                 'Y' => array(),
                 'Z' => array( 29, 57 ),
                 'AA' => array( 6, 13, 14, 16, 18, 22, 32, 35, 37, 38, 41, 48, 49, 51, 54, 55, 60, 62, 63, 67, 71, 73, 74, 75, 76, 77, 78, 79, 80, 82, 83, 85, 87, 88 )
              );
             
             
             // get a reference to the path of PHPExcel classes
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
              spl_autoload_unregister(array('YiiBase','autoload'));

             
             // making use of our reference, include the main class
             // when we do this, phpExcel has its own autoload registration
             // procedure (PHPExcel_Autoloader::Register();)
             include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

             // Create new PHPExcel object
             $objPHPExcel = new PHPExcel();

             // Set properties
            $objPHPExcel->getProperties()->setCreator("GJMIS")
            ->setLastModifiedBy("GJMIS")
            ->setTitle("Excel Export Document")
            ->setSubject("Excel Export Document")
            ->setDescription("Exporting documents to Excel using php classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Excel export file");
              
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Gallant Jewelry')
            ->setCellValue('A3', 'F-25,Special Economic Zone - II (SEZ),Sitapura')
            ->setCellValue('A4', 'Tonk Road,Jaipur-302022')
            ->setCellValue('A5', 'Tel : 0141-2172523')
            ->setCellValue('A6', "Consignee")
            ->setCellValue('P9', 'Invoice No. : '.$invoice['id'].'    Dated: '.$invoice['date'])
            ->setCellValue('W11', 'SB/JSEZ :')
            ->setCellValue('AB12', 'Date :'.$invoice['date'])
            ->setCellValue('A14', 'S No.')
            ->setCellValue('B14', 'Code')
            ->setCellValue('C14', 'Size')
            ->setCellValue('D14', 'GJ NO.')
            ->setCellValue('E13', 'Gallant')
            ->setCellValue('E14', 'PO #')
            ->setCellValue('F13', 'Metal')
            ->setCellValue('F14', 'Type')
            ->setCellValue('G13', 'Customer')
            ->setCellValue('G14', 'Sku #')
            ->setCellValue('G15', 'Other Ref')
            ->setCellValue('H13', 'Customer')
            ->setCellValue('H14', 'Order #')
            ->setCellValue('I14', 'Order #')
            ->setCellValue('J14', 'Qty')
            ->setCellValue('K14', 'Item')
            ->setCellValue('L14', 'Gross Wt.')
            ->setCellValue('L15', 'Gms')
            ->setCellValue('N14', 'Emrald')
            ->setCellValue('O14', 'Ruby')
            ->setCellValue('P14', 'Sapp')
            ->setCellValue('Q14', 'Tan')
            ->setCellValue('R14', 'Topaz')
            ->setCellValue('S14', 'Garnet')
            ->setCellValue('T14', 'Peridot')
            ->setCellValue('U14', 'AMY')
            ->setCellValue('V14', 'OP')
            ->setCellValue('W14', 'Citrine')
            ->setCellValue('X14', 'CD')
            ->setCellValue('Y14', 'SM')
            ->setCellValue('Z14', 'AQ')
            ->setCellValue('AA14', 'Miss')
            ->setCellValue('AA15', 'Stone')
            ->setCellValue('N13', 'Stone Weight(Cts)')
            ->setCellValue('AB13', 'Diamond')
            ->setCellValue('AB14', 'Wt.')
            ->setCellValue('AB15', 'Cts')
            ->setCellValue('AC13', 'Findings')
            ->setCellValue('AC14', 'Wt')
            ->setCellValue('AC15', 'Gms')
            ->setCellValue('AD13', 'Net')
            ->setCellValue('AD14', 'Metal')
            ->setCellValue('AD15', 'Gms')
            ->setCellValue('AE13', '.995/.999')
            ->setCellValue('AE14', 'Fine')
            ->setCellValue('AE15', 'Gold/Silver')
            ->setCellValue('AH13', 'Price')
            ->setCellValue('AH14', 'Per-Pc')
            ->setCellValue('AH15', '(US $)')
            ->setCellValue('AI13', 'Total')
            ->setCellValue('AI14', 'Amount')
            ->setCellValue('AI15', 'US $');
            
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:AI2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:AI3');
            $objPHPExcel->getActiveSheet()->mergeCells('A4:AI4');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:AI5');
            $objPHPExcel->getActiveSheet()->mergeCells('P9:AI9');
            $objPHPExcel->getActiveSheet()->mergeCells('N13:AA13');
            
            
            
            $styleArray = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                    ),
            );
            
            $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A1:AI1')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A2:AI2')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A3:AI3')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A4:AI4')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A5:AI5')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A6:AI6')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('P9:AI12')->applyFromArray($styleArray2);
           

          //setting style for thick border
          $styleThickBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),

                        ),
                    ),
           );
          
          //setting style for thick border
          $styleThickBorderbottom = array(
                    'borders' => array(
                        'bottom' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),

                        ),
                    ),
           );

          //setting style for thin bottom
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
          
          //setting style for thin right
          $styleThickBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' =>  PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );

          
          
          $objPHPExcel->getActiveSheet()->getStyle('A12:AI12')->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A15:AI15')->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A13:A15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B13:B15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C13:C15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D13:D15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('E13:E15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F13:F15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G13:G15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('H13:H15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('I13:I15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('J13:J15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('K13:K15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('L13:L15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('Q14:Q15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('R14:R15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('S14:S15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('T14:T15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('U14:U15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('V14:V15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('W14:W15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('X14:X15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('Y14:Y15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('Z14:Z15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AA13:AA15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AB13:AB15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AC13:AC15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AD13:AD15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AE13:AE15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AF13:AF15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AG13:AG15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AH13:AH15')->applyFromArray($styleThickBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('AI13:AI15')->applyFromArray($styleThickBlackBorderright);
          
          $i = 0;
          foreach($totalsku as $name => $skucontent){
              $j = 0;
              $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('A'.($i + 16), 'Lot #'.$name); $i++;
              foreach($skucontent as $skuc){
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.($i + 16), $i)
                ->setCellValue('C'.($i + 16), '')
                ->setCellValue('D'.($i + 16), $skuc[0]['skucode'])
                ->setCellValue('E'.($i + 16), $skuc[8])
                ->setCellValue('G'.($i + 16), $skuc[0]['refpo'])
                ->setCellValue('H'.($i + 16), $purchase_order )
                ->setCellValue('J'.($i + 16), $skuc[10])
                ->setCellValue('K'.($i + 16), $skuc[1]['type'])
                ->setCellValue('L'.($i + 16), ($skuc[10] * $skuc[0]['grosswt']));
               //echo('<pre>');print_r($stone_array);print_r($skuc[2][0]['idstone']);die();
                foreach($stone_array as $k=>$v){
                    foreach($skuc[2] as $stones){
                    if(in_array($stones['stonem'], $v)){
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.($i + 16), ($skuc[10]* $skuc[2][0]['weight']*$skuc[2][0]['pieces']));
                        break;
                    }}
                }
                
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('AC'.($i + 16), ($skuc[9]*$skuc[10]))
                ->setCellValue('AD'.($i + 16), '=((L'.($i + 16).')-((N'.($i + 16).')+(O'.($i + 16).')+(P'.($i + 16).')+(Q'.($i + 16).')+(R'.($i + 16).')+(S'.($i + 16).')+(T'.($i + 16).')+(U'.($i + 16).')+(V'.($i + 16).')+(W'.($i + 16).')+(X'.($i + 16).')+(Y'.($i + 16).')+(Z'.($i + 16).')+(AA'.($i + 16).')+(AB'.($i + 16).'))/5)')
                ->setCellValue('AE'.($i + 16), (($i + 16)*(.925/.999)))
                ->setCellValue('AH'.($i + 16), $skuc[11])
                ->setCellValue('AI'.($i + 16), '=((J'.($i + 16).' )* (AH'.($i + 16).'))');
                $i++;
              }
             
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('J'.($i + 19), '=SUM(J'.($j + 17).':J'.($i + 18).')') 
                ->setCellValue('L'.($i + 19), '=SUM(L'.($j + 17).':L'.($i + 18).')')
                ->setCellValue('N'.($i + 19), '=SUM(N'.($j + 17).':N'.($i + 18).')')
                ->setCellValue('O'.($i + 19), '=SUM(O'.($j + 17).':O'.($i + 18).')')
                ->setCellValue('P'.($i + 19), '=SUM(P'.($j + 17).':P'.($i + 18).')')
                ->setCellValue('Q'.($i + 19), '=SUM(Q'.($j + 17).':Q'.($i + 18).')')
                ->setCellValue('R'.($i + 19), '=SUM(R'.($j + 17).':R'.($i + 18).')')
                ->setCellValue('S'.($i + 19), '=SUM(S'.($j + 17).':S'.($i + 18).')')
                ->setCellValue('T'.($i + 19), '=SUM(T'.($j + 17).':T'.($i + 18).')')
                ->setCellValue('U'.($i + 19), '=SUM(U'.($j + 17).':U'.($i + 18).')')
                ->setCellValue('V'.($i + 19), '=SUM(V'.($j + 17).':V'.($i + 18).')')
                ->setCellValue('W'.($i + 19), '=SUM(W'.($j + 17).':W'.($i + 18).')')
                ->setCellValue('X'.($i + 19), '=SUM(X'.($j + 17).':X'.($i + 18).')')
                ->setCellValue('Y'.($i + 19), '=SUM(Y'.($j + 17).':Y'.($i + 18).')')
                ->setCellValue('Z'.($i + 19), '=SUM(Z'.($j + 17).':Z'.($i + 18).')')
                ->setCellValue('AA'.($i + 19), '=SUM(AA'.($j + 17).':AA'.($i + 18).')')
                ->setCellValue('AB'.($i + 19), '=SUM(AB'.($j + 17).':AB'.($i + 18).')')
                ->setCellValue('AC'.($i + 19), '=SUM(AC'.($j + 17).':AC'.($i + 18).')')
                ->setCellValue('AD'.($i + 19), '=SUM(AD'.($j + 17).':AD'.($i + 18).')')
                ->setCellValue('AE'.($i + 19), '=SUM(AE'.($j + 17).':AE'.($i + 18).')')
                ->setCellValue('AI'.($i + 19), '=SUM(AI'.($j + 17).':AI'.($i + 18).')');
              
              
              $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 18).':AI'.($i + 18))->applyFromArray($styleThickBorderbottom);
              $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 19).':AI'.($i + 19))->applyFromArray($styleThickBorderbottom);
              $objPHPExcel->getActiveSheet()->getStyle('A2'.':AI'.($i + 19))->applyFromArray($styleArray);
            
            
            $totqty[$name]['name'] = $name;
            $totqty[$name]['qty'] = $objPHPExcel->getActiveSheet()->getCell('J'.($i + 19))->getCalculatedValue();
            $totqty[$name]['description'] = '';
            $totqty[$name]['net_wt_jewl'] = $objPHPExcel->getActiveSheet()->getCell('L'.($i + 19))->getCalculatedValue();
            $totqty[$name]['net_wt_metal'] = $objPHPExcel->getActiveSheet()->getCell('AD'.($i + 19))->getCalculatedValue();
            $totqty[$name]['dia_wt'] = $objPHPExcel->getActiveSheet()->getCell('AB'.($i + 19))->getCalculatedValue();
            $totqty[$name]['pre_wt'] = $objPHPExcel->getActiveSheet()->getCell('N'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('O'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('P'.($i + 19))->getCalculatedValue();
            $totqty[$name]['sem_wt'] = $objPHPExcel->getActiveSheet()->getCell('Q'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('R'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('S'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('T'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('U'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('V'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('W'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('X'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('Y'.($i + 19))->getCalculatedValue() + $objPHPExcel->getActiveSheet()->getCell('Z'.($i + 19))->getCalculatedValue()+ $objPHPExcel->getActiveSheet()->getCell('AA'.($i + 19))->getCalculatedValue();
            $totqty[$name]['amount'] = $objPHPExcel->getActiveSheet()->getCell('AI'.($i + 19))->getCalculatedValue();
            
            $i = $i + 4;
            $j = $i;
          }
         
            
          $objPHPExcel->getActiveSheet()->getStyle('AI13:AI'.($i + 15))->applyFromArray($styleThickBlackBorderright);
          

          // Rename sheet
          $objPHPExcel->getActiveSheet()->setTitle('Packaging Sheet');

          
          // For creating a new sheet
          $objPHPExcel->createSheet();

          $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('D1', 'INVOICE')
            ->setCellValue('A2', 'Exporter')
            ->setCellValue('F2', 'Invoice No.')
            ->setCellValue('L2', 'Date')
            ->setCellValue('M2', "Exporter's Ref. IEC No.:")
            ->setCellValue('N3', '')
            ->setCellValue('F4', 'Buyers Order No. Date')
            ->setCellValue('F5', 'GR Form No:')
            ->setCellValue('F6', 'Other Reference(s)')
            ->setCellValue('L6', 'SB/JSEZ:')
            ->setCellValue('L7', 'Dated:')
            ->setCellValue('A8', 'Consignee')
            ->setCellValue('F8', 'Buyer(If other than consignee)')
            ->setCellValue('F9', 'PAN No.')
            ->setCellValue('F11', 'Country of Origin of Goods')
            ->setCellValue('M11', 'Country of Final Destination')
            ->setCellValue('F13', 'Terms of Delivery and Payment')
            ->setCellValue('A14', 'Bill To')
            ->setCellValue('F18', 'OUTRIGHT SALE')
            ->setCellValue('A20', 'Pre-Carriage By')
            ->setCellValue('C20', 'Place of Receipt by Pre-Carrier')
            ->setCellValue('A22', 'Vessel/Flight No.')
            ->setCellValue('C22', 'Port of Loading')
            ->setCellValue('F20', 'Bankers:')
            ->setCellValue('A26', 'Marks and Container No.')
            ->setCellValue('C26', 'No. and Kind of Pkgs')
            ->setCellValue('E26', 'Description of Goods')
            ->setCellValue('L26', 'Net Wt.')
            ->setCellValue('M26', 'Rate')
            ->setCellValue('N26', 'Amount')
            ->setCellValue('B31', 'Lot')
            ->setCellValue('C31', 'Pcs')
            ->setCellValue('D31', 'Particulars')
            ->setCellValue('L31', 'Gms')
            ->setCellValue('M31', 'US$')
            ->setCellValue('N31', 'US$');
            $i = 0;
            foreach($totalsku as $name => $skucontent){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.($i + 32), ($i + 1))
                    ->setCellValue('C'.($i + 32), $totqty[$name]['name'])
                    ->setCellValue('D'.($i + 32), $totqty[$name]['name'])
                    ->setCellValue('L'.($i + 32), $totqty[$name]['net_wt_jewl'])
                    ->setCellValue('N'.($i + 32), $totqty[$name]['amount'])
                    ->setCellValue('A'.($i + 33), $totqty[$name]['description']);
                $i = $i + 2;
            }
            
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L'.($i + 26+ 35), '=SUM(L'.(32).':L'.($i + 35).')');
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N'.($i + 22+ 35), '=SUM(N'.(32).':N'.($i + 35).')');
            $i = $i + 35;
           
            $j = 0;
            $total_amount = 0;
            foreach($totalsku as $name => $skucontent){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue(chr(68 + $j).($i), $name)
                    ->setCellValue(chr(68 + $j).($i + 2), $totqty[$name]['net_wt_jewl'])
                    ->setCellValue(chr(68 + $j).($i + 3), $totqty[$name]['net_wt_metal'])
                    ->setCellValue(chr(68 + $j).($i + 6), '=(('.chr(68 + $j).($i + 2).' )* '.(0.925/0.999).')')
                    ->setCellValue(chr(68 + $j).($i + 8), '=(('.chr(68 + $j).($i + 6).' )* '.(0.07).')')
                    ->setCellValue(chr(68 + $j).($i + 9), '=(('.chr(68 + $j).($i + 6).' )+ ('.chr(68 + $j).($i + 7).')+ ('.chr(68 + $j).($i + 8).' ))')
                    ->setCellValue(chr(68 + $j).($i + 10), $totqty[$name]['dia_wt'])
                    ->setCellValue(chr(68 + $j).($i + 11), $totqty[$name]['pre_wt'])
                    ->setCellValue(chr(68 + $j).($i + 12), $totqty[$name]['sem_wt'])
                    ->setCellValue(chr(68 + $j).($i + 13), '=(('.chr(68 + $j).($i + 10).' )+ ('.chr(68 + $j).($i + 11).')+ ('.chr(68 + $j).($i + 12).' ))')
                    ->setCellValue(chr(68 + $j).($i + 14), '=(('.chr(68 + $j).($i + 9).' )* '.(1.183).')')
                    ->setCellValue(chr(68 + $j).($i + 16), $skucontent['diamond_amt'])
                    ->setCellValue(chr(68 + $j).($i + 17), $skucontent['pre_stones_amt'])
                    ->setCellValue(chr(68 + $j).($i + 18), $skucontent['semi_stones_amt'])
                    ->setCellValue(chr(68 + $j).($i + 19), $skucontent['labor_cost'])
                    ->setCellValue(chr(68 + $j).($i + 20), ($totqty[$name]['amount']-(chr(68 + $j).($i + 19) + chr(68 + $j).($i + 18) + chr(68 + $j).($i + 17) + chr(68 + $j).($i + 16) + chr(68 + $j).($i + 15) + chr(68 + $j).($i + 14))))
                    ->setCellValue(chr(68 + $j).($i + 21), $totqty[$name]['amount']);
                $total_amount += $totqty[$name]['amount'];
                //echo('<pre>'); print_r($totqty[$name]['amount']);die();
                $j++;
            }
          
            
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$i, '.925 Silver')
            ->setCellValue('A'.($i + 2), 'Net Weight(Jewelry)')
            ->setCellValue('C'.($i + 2), 'Gms')
            ->setCellValue('A'.($i + 3), 'Net Weight(Metal)')
            ->setCellValue('C'.($i + 3), 'Gms')
            ->setCellValue('A'.($i + 4), 'Net Weight(Findings)')
            ->setCellValue('C'.($i + 4), 'Gms')
            ->setCellValue('A'.($i + 6), 'Net Weight .995/.999')
            ->setCellValue('C'.($i + 6), 'Gms')
            ->setCellValue('A'.($i + 7), 'Net Weight FIndings .995/.999')
            ->setCellValue('C'.($i + 7), 'Gms')
            ->setCellValue('A'.($i + 8), 'Wastage .995/.999')
            ->setCellValue('C'.($i + 8), 'Gms')
            ->setCellValue('A'.($i + 9), 'Total Fine Wt.')
            ->setCellValue('C'.($i + 9), 'Gms')
            ->setCellValue('A'.($i + 10), 'Weight of Diamond')
            ->setCellValue('C'.($i + 10), 'Cts')
            ->setCellValue('A'.($i + 11), 'Weight of Precious Stones')
            ->setCellValue('C'.($i + 11), 'Cts')
            ->setCellValue('A'.($i + 12), 'Weight of Semi-Precious Stones')
            ->setCellValue('C'.($i + 12), 'Cts')
            ->setCellValue('A'.($i + 13), 'Total Stone/Diamond Wt.')
            ->setCellValue('C'.($i + 13), 'Cts')
            ->setCellValue('A'.($i + 14), 'Value of Gold/Silver(Fine)')
            ->setCellValue('C'.($i + 14), 'US$')
            ->setCellValue('A'.($i + 15), 'Value of Findings(Fine)')
            ->setCellValue('C'.($i + 15), 'US$')
            ->setCellValue('A'.($i + 16), 'Value of Diamonds')
            ->setCellValue('C'.($i + 16), 'US$')
            ->setCellValue('A'.($i + 17), 'Value of Precious Stones')
            ->setCellValue('C'.($i + 17), 'US$')
            ->setCellValue('A'.($i + 18), 'Value of Semi Precious Stones')
            ->setCellValue('C'.($i + 18), 'US$')
            ->setCellValue('A'.($i + 19), 'Value of Labor Charges')
            ->setCellValue('C'.($i + 19), '')
            ->setCellValue('A'.($i + 20), 'Value Addition')
            ->setCellValue('C'.($i + 20), 'US$')
            ->setCellValue('A'.($i + 21), 'Total Amount')
            ->setCellValue('C'.($i + 21), 'US$')
            ->setCellValue('A'.($i + 22), 'Total Value Addition')
            ->setCellValue('D'.($i + 22), $total_amount)
            ->setCellValue('C'.($i + 22), 'US$')
            ->setCellValue('A'.($i + 23), 'Silver 0.999')
            ->setCellValue('D'.($i + 23), 'Gms')
            ->setCellValue('A'.($i + 24), 'Gold 0.995')
            ->setCellValue('D'.($i + 24), 'Gms')
            ->setCellValue('L'.($i + 22), 'FOB Value')
            ->setCellValue('N'.($i + 22), '$')
            ->setCellValue('L'.($i + 24), 'GSP Charges')
            ->setCellValue('A'.($i + 25), 'Insurance Covered: ')
            ->setCellValue('L'.($i + 25), 'Shipping Charges')
            ->setCellValue('A'.($i + 26), 'Amount Chargeable')
            ->setCellValue('M'.($i + 26), 'C & F Value')
            ->setCellValue('N'.($i + 26), '$')
            ->setCellValue('A'.($i + 27), '(US$ Only)')
            ->setCellValue('A'.($i + 28), 'Declaration')
            ->setCellValue('L'.($i + 28), 'For Gallant Jewelry')
            ->setCellValue('A'.($i + 29), 'We hereby declare that we have fulfilled the minimum value addition condition')
            ->setCellValue('A'.($i + 30), 'Declaration')
            ->setCellValue('A'.($i + 31), 'We declare that this invoice shows the actual price of the goods described')
            ->setCellValue('A'.($i + 32), 'and that all particulars are true and correct')
            ->setCellValue('M'.($i + 33), 'Authorized Signatory'.chr(65));
            
            
            
            //filling variable values in the cells
            $objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue('F3', $id)
                    ->setCellValue('L3', $totalsku[0][7]);
            
            $objPHPExcel->getActiveSheet()->mergeCells('D1:G1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:E7');
            $objPHPExcel->getActiveSheet()->mergeCells('F6:K7');
            $objPHPExcel->getActiveSheet()->mergeCells('L6:N6');    
            $objPHPExcel->getActiveSheet()->mergeCells('L7:N7');
            $objPHPExcel->getActiveSheet()->mergeCells('A8:E13');
            $objPHPExcel->getActiveSheet()->mergeCells('F8:N8');
            $objPHPExcel->getActiveSheet()->mergeCells('F9:N10');
            $objPHPExcel->getActiveSheet()->mergeCells('F18:N19');
            $objPHPExcel->getActiveSheet()->mergeCells('A14:E19');
            $objPHPExcel->getActiveSheet()->mergeCells('F13:N17');
            $objPHPExcel->getActiveSheet()->mergeCells('A20:B21');
            $objPHPExcel->getActiveSheet()->mergeCells('L26:L30');
            $objPHPExcel->getActiveSheet()->mergeCells('M26:M30');
            $objPHPExcel->getActiveSheet()->mergeCells('N26:N30');
            $objPHPExcel->getActiveSheet()->mergeCells('E'.($i + 22).':K'.($i + 24));
            
            
            $styleArray = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                    ),
            );
            
            $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A2:N'.($i + 33))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D1:G1')->applyFromArray($styleArray2);
           

          //setting style for thick border
          $styleThickBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),

                        ),
                    ),
           );
          
          //setting style for thick border
          $styleThickBorderbottom = array(
                    'borders' => array(
                        'bottom' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),

                        ),
                    ),
           );

          //setting style for thin bottom
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
          
           //setting style for thin right
          $styleThinBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );

          $objPHPExcel->getActiveSheet()->getStyle('A2:N'.($i + 33))->applyFromArray($styleThickBorderOutline);
          $objPHPExcel->getActiveSheet()->getStyle('A2:E25')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('L2:L3')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G2:G3')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('L11:L12')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A20:B31')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C26:D30')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A26:K'.($i + 33))->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('L26:L'.($i + 26))->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('M26:M'.($i + 26))->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A31')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B31')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C31')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 22).':D'.($i + 24))->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F3:N3')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F5:N5')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A7:N7')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F8:N8')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F10:N10')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F12:N12')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F17:N17')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('F19:N19')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A13:E13')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A19:E19')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A21:E21')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A23:E23')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A25:N25')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('C26:K26')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('C27:B27')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A30:N30')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A31:N31')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i).':K'.($i))->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 8).':K'.($i + 8))->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 9).':K'.($i + 9))->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 12).':K'.($i + 12))->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 13).':K'.($i + 13))->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i +20).':K'.($i + 20))->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('D'.($i + 21).':K'.($i + 21))->applyFromArray($styleThickBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E'.($i + 24).':K'.($i + 24))->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 25).':N'.($i + 25))->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('L'.($i + 8).':N'.($i + 26))->applyFromArray($styleThinBlackBorderbottom);
          



          // Rename sheet
          $objPHPExcel->setActiveSheetIndex(1);
          $objPHPExcel->getActiveSheet()->setTitle('Invoice');
          
          
          
          // For creating a new sheet
          $objPHPExcel->createSheet();

          $objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A1', 'INVOICE & PACKING SHEET')
            ->setCellValue('A2', 'Exporter')
            ->setCellValue('A3', 'GALLANT JEWELRY CREATIONS')
            ->setCellValue('A4', 'S 10, JEEVAN VIHAR, NEW COLONY')
            ->setCellValue('A5', "JAIPUR.")
            ->setCellValue('A6', 'RAJASTHAN - 302001 (INDIA)')
            ->setCellValue('A7', 'Tel. :- 0141 - 2377288 , 2377592')
            ->setCellValue('H2', 'Invoice No. & Date : '. $id.' & '. date('d-m-y', strtotime($Invoice->mdate) ))
            ->setCellValue('H4', "Buyer's Order No. & Date")
            ->setCellValue('H6', 'Other Reference(s)')
            ->setCellValue('L2', "Exporter's Reference")
            ->setCellValue('L4', 'PAN: ')
            ->setCellValue('L6', 'G.R. NO : ')
            ->setCellValue('A8', 'Consignee')
            ->setCellValue('H8', 'Buyer(if other then consignee)')
            ->setCellValue('L8', 'Terms of Delivery and Payment')
            ->setCellValue('A15', 'Pre Carriage by')
            ->setCellValue('A17', 'Vessel/Flight No.')
            ->setCellValue('A19', 'Port of Discharge')
            ->setCellValue('D15', 'Place of Receipt by Pre-Carrier')
            ->setCellValue('D17', 'Port of Loading')
            ->setCellValue('D19', 'Final Destination')
            ->setCellValue('H15', 'Country of Origin of Goods ')
            ->setCellValue('L15', 'Country of Final Destination')
            ->setCellValue('A21', 'Marks & Containers No.')
            ->setCellValue('D21', 'Description of Goods')
            ->setCellValue('A25', 'S.No')
            ->setCellValue('B25', 'Code')
            ->setCellValue('C25', 'Size')
            ->setCellValue('D25', 'GJ No')
            ->setCellValue('E25', 'Ref #')
            ->setCellValue('F25', 'Order #')
            ->setCellValue('G25', 'Pcs')
            ->setCellValue('H25', 'Particular')
            ->setCellValue('I25', 'Pcs')
            ->setCellValue('I26', 'Particular')
            ->setCellValue('J25', 'Stone Wt')
            ->setCellValue('J26', '(Gms)')
            ->setCellValue('K25', "Dia Wt ")
            ->setCellValue('K26', '(Gms)')
            ->setCellValue('L25', "NET Metal ")
            ->setCellValue('L26', '(Gms)')
            ->setCellValue('M25', ' FINE ')
            ->setCellValue('M26', 'Metal')
            ->setCellValue('N25', 'US$')
            ->setCellValue('N26', 'P.Pc')
            ->setCellValue('O25', 'Amount')
            ->setCellValue('O26', 'US$');
          
          
                  $styleArray = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                    ),
            );
                  
            
            $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
            );
            
            
             $styleArray3 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    
            );
             
             
           $objPHPExcel->getActiveSheet()->getStyle('A2:O26')->applyFromArray($styleArray3);
             
           $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray2);
           

          //setting style for thick border
          $styleThickBorderOutline = array(
                    'borders' => array(
                        'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),
                        ),
                    ),
           );
          
          
          //setting style for thick border
          $styleThickBorderbottom = array(
                    'borders' => array(
                        'bottom' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THICK,
                                'color' => array('argb' => 'FF000000'),
                        ),
                    ),
           );
          
          
          
          //setting style for thin bottom
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
          
           //setting style for thin right
          $styleThinBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );

          
          
            $objPHPExcel->getActiveSheet()->getStyle('A25:O26')->applyFromArray($styleThickBorderOutline);
            
           
          
            $i = 0; $j = 0; $total_sum=0;
            foreach($totalsku as $name => $skucontent){
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.($i + 27), 'LOT #'.($i+1).' '.$name);
                $i++;
                $skuvariable = array();
                foreach($skucontent as $skuc){
                    $objPHPExcel->setActiveSheetIndex(2)
                        ->setCellValue('A'.($i + 27), $i)
                        ->setCellValue('B'.($i + 27), $skuc[13])
                        ->setCellValue('C'.($i + 27), $skuc[1]['size'])
                        ->setCellValue('D'.($i + 27), $skuc[0]['skucode'])
                        ->setCellValue('E'.($i + 27), $skuc[0]['skucode'])
                        ->setCellValue('F'.($i + 27), $skuc[0]['refpo'])
                        ->setCellValue('G'.($i + 27), $skuc[10])
                        ->setCellValue('H'.($i + 27), $skuc[1]['type'])
                        ->setCellValue('I'.($i + 27), ($skuc[10] * $skuc[0]['grosswt']))
                        ->setCellValue('J'.($i + 27), ($skuc[10] * $skuc[0]['totstowei']))
                        ->setCellValue('K'.($i + 27), $skuc['diamond_wt'])
                        ->setCellValue('L'.($i + 27), '=(I'.($i + 27).' - J'.($i + 27).'- K'.($i + 27).')')
                        ->setCellValue('M'.($i + 27), '=round((L'.($i + 27).'* 0.925),2)')
                        ->setCellValue('N'.($i + 27), round($skuc[11] ,2))
                        ->setCellValue('O'.($i + 27), '=(N'.($i + 27).' * G'.($i + 27).')');
                    $i++;
                    
                }
             
                $objPHPExcel->setActiveSheetIndex(2)
                        ->setCellValue('G'.($i + 27), '=SUM(G'.($i + 26 - $k ).':G'.($i + 26).')')
                        ->setCellValue('I'.($i + 27), '=SUM(I'.($i + 26 - $k ).':I'.($i + 26).')')
                        ->setCellValue('J'.($i + 27), '=SUM(J'.($i + 26 - $k ).':J'.($i + 26).')')
                        ->setCellValue('K'.($i + 27), '=SUM(K'.($i + 26 - $k ).':K'.($i + 26).')')
                        ->setCellValue('L'.($i + 27), '=SUM(L'.($i + 26 - $k ).':L'.($i + 26).')')
                        ->setCellValue('M'.($i + 27), '=SUM(M'.($i + 26 - $k ).':M'.($i + 26).')')
                        ->setCellValue('O'.($i + 27), '=SUM(O'.($i + 26 - $k ).':O'.($i + 26).')');
                $skuvariable['LOT #'.($i-1).' '.$name]['name'] = 'A'.($i + 27);
                $skuvariable['LOT #'.($i-1).' '.$name]['fine'] = 'M'.($i + 27);
                $skuvariable['LOT #'.($i-1).' '.$name]['net'] = 'L'.($i + 27);
                $skuvariable['LOT #'.($i-1).' '.$name]['stone'] = 'J'.($i + 27);
                $skuvariable['LOT #'.($i-1).' '.$name]['diamond'] = 'K'.($i + 27);
                $skuvariable['LOT #'.($i-1).' '.$name]['total'] = 'O'.($i + 27);
                $total_sum +=  $objPHPExcel->setActiveSheetIndex(2)->getCell('O'.($i + 27))->getCalculatedValue(); 
                
               
                
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 27).':O'.($i + 27))->applyFromArray($styleThinBlackBorderbottom);
                $objPHPExcel->getActiveSheet()->getStyle('G'.($i + 27).':O'.($i + 27))->applyFromArray($styleThickBorderOutline);
                $objPHPExcel->getActiveSheet()->getStyle('G'.($i + 27).':O'.($i + 27))->applyFromArray($styleArray3);
                $objPHPExcel->getActiveSheet()->getStyle('A25:A'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('B25:B'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('C25:C'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('D25:D'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('E25:E'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('F25:F'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('G25:G'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('H25:H'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('I25:I'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('J25:J'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('K25:K'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('L25:L'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('M25:M'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('N25:N'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                $objPHPExcel->getActiveSheet()->getStyle('O25:O'.($i + 27))->applyFromArray($styleThinBlackBorderright);
                
                    $i++;
                    $j++;
            }
            
            $i = $i + 20;
            $objPHPExcel->setActiveSheetIndex(2)
                        ->setCellValue('A'.($i + 27), "(Insurance Covered By Banks)")
                        ->setCellValue('A'.($i + 28), "Amount Chargeable(In words)")
                        ->setCellValue('A'.($i + 30), "Declaration:")
                        ->setCellValue('A'.($i + 31), "We declare that this invoice shows the actual price of the")
                        ->setCellValue('A'.($i + 32), "goods described and that all particulars are true and correct.")
                        ->setCellValue('K'.($i + 28), "For GALLANT JEWELRY CREATIONS")
                        ->setCellValue('L'.($i + 32), "Authorised Signatory")
                        ->setCellValue('A'.($i + 33), "Marks & Containers No.")
                        ->setCellValue('D'.($i + 33), "Description of Goods");
            
            //print_r($i);die();
            $objPHPExcel->getActiveSheet()->getStyle('C'.($i + 33).':C'.($i + 36))->applyFromArray($styleThinBlackBorderright);
            $objPHPExcel->getActiveSheet()->getStyle('H'.($i + 33).':H'.($i + 36))->applyFromArray($styleThinBlackBorderright);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 33).':O'.($i + 36))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 28).':J'.($i + 32))->applyFromArray($styleThickBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('K'.($i + 28).':O'.($i + 32))->applyFromArray($styleThickBorderOutline);
              
          
            $l = $i+38;
            $m = $i + 38;
            $k = 0;
            //echo('<pre>');print_r($skuvariable);die();
            foreach($skuvariable as $key=>$value){
                if($k%2 == 0){
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.($l), $key)
                        ->setCellValue('D'.(++$l), "Gross Wt")
                        ->setCellValue('E'.($l), "Value(US$)")
                        ->setCellValue('A'.(++$l), "Silver(0.995)")
                        ->setCellValue('D'.($l), '=('.$value['fine'].')')
                        ->setCellValue('A'.(++$l), "Wastage(7%)")
                        ->setCellValue('D'.($l), '=round(('.$value['fine'] .'*' .(.07).'),2)')
                        ->setCellValue('A'.(++$l), "Total Admisable")
                        ->setCellValue('D'.($l), '=(D'.($l-1).' + D'.($l-2).')')
                        ->setCellValue('A'.(++$l), "Metal")
                        ->setCellValue('D'.($l), '=round(('.$value['net'].'-'.$value['fine'].'),2)')
                        ->setCellValue('A'.(++$l), "Stones")
                        ->setCellValue('D'.($l), '=('.$value['stone'].')')
                        ->setCellValue('A'.(++$l), "Diamond")
                        ->setCellValue('D'.($l), '=('.$value['diamond'].')')
                        ->setCellValue('A'.(++$l), "Value Addition")
                        ->setCellValue('E'.($l), '=round(('.$value['total'].'*'.(.16).'),2)');
                    $l += 2;
                }else{
                    $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H'.($m), $key)
                        ->setCellValue('K'.(++$m), "Gross Wt")
                        ->setCellValue('L'.($m), "Value(US$)")
                        ->setCellValue('H'.(++$m), "Silver(0.995)")
                        ->setCellValue('K'.($m), '=('.$value['fine'].')')
                        ->setCellValue('H'.(++$m), "Wastage(7%)")
                        ->setCellValue('K'.($m), '=round(('.$value['fine'] .'*' .(.07).'),2)')
                        ->setCellValue('H'.(++$m), "Total Admisable")
                        ->setCellValue('K'.($m), '=(D'.($m-1).' + D'.($m-2).')')
                        ->setCellValue('H'.(++$m), "Metal")
                        ->setCellValue('K'.($m), '=round(('.$value['net'].'-'.$value['fine'].'),2)')
                        ->setCellValue('H'.(++$m), "Stones")
                        ->setCellValue('K'.($m), '=('.$value['stone'].')')
                        ->setCellValue('H'.(++$m), "Diamond")
                        ->setCellValue('K'.($m), '=('.$value['diamond'].')')
                        ->setCellValue('H'.(++$m), "Value Addition")
                        ->setCellValue('L'.($l), '=round(('.$value['total'].'*'.(.16).'),2)');
                    $m += 2;
                }
                $k++;
            }
            
            
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.($l + 9), "(Insurance Covered By Brink's)")
                        ->setCellValue('K'.($l + 9), "FOB US $")
                        ->setCellValue('O'.($l + 9), $total_sum)
                        ->setCellValue('A'.($l + 12), "Declaration:")
                        ->setCellValue('A'.($l + 13), "We declare that this invoice shows the actual price of the")
                        ->setCellValue('A'.($l + 14), "goods described and that all particulars are true and correct.")
                        ->setCellValue('K'.($l + 10), "For GALLANT JEWELRY CREATIONS")
                        ->setCellValue('K'.($l + 9), "FOB US$")
                        ->setCellValue('K'.($l + 14), "Authorised Signatory")
                        ->setCellValue('A'.($l + 10), "Amount Chargeable(In words)");
            
            
             $objPHPExcel->getActiveSheet()->getStyle('A'.($i + 27).':O'.($l+14))->applyFromArray($styleArray3);
           
            
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:G7');
            $objPHPExcel->getActiveSheet()->mergeCells('H2:K3');
            $objPHPExcel->getActiveSheet()->mergeCells('L2:O3');    
            $objPHPExcel->getActiveSheet()->mergeCells('H4:K5');
            $objPHPExcel->getActiveSheet()->mergeCells('L4:O5');
            $objPHPExcel->getActiveSheet()->mergeCells('H6:K7');
            $objPHPExcel->getActiveSheet()->mergeCells('L6:O7');
            $objPHPExcel->getActiveSheet()->mergeCells('A8:G14');
            $objPHPExcel->getActiveSheet()->mergeCells('H8:K14');
            $objPHPExcel->getActiveSheet()->mergeCells('L8:O14');
            $objPHPExcel->getActiveSheet()->mergeCells('A15:C15');
            $objPHPExcel->getActiveSheet()->mergeCells('A16:C16');
            $objPHPExcel->getActiveSheet()->mergeCells('A17:C17');
            $objPHPExcel->getActiveSheet()->mergeCells('A18:C18');
            $objPHPExcel->getActiveSheet()->mergeCells('A19:C19');
            $objPHPExcel->getActiveSheet()->mergeCells('A20:C20');
            $objPHPExcel->getActiveSheet()->mergeCells('D15:G16');
            $objPHPExcel->getActiveSheet()->mergeCells('D17:G18');
            $objPHPExcel->getActiveSheet()->mergeCells('D19:G20');
            $objPHPExcel->getActiveSheet()->mergeCells('H15:K20');
            $objPHPExcel->getActiveSheet()->mergeCells('L15:O20');
            $objPHPExcel->getActiveSheet()->mergeCells('A21:C24');
            $objPHPExcel->getActiveSheet()->mergeCells('D21:H24');
            
            
    
          $objPHPExcel->getActiveSheet()->getStyle('A'.($l + 10).':O'.($l + 14))->applyFromArray($styleThickBorderOutline);
          $objPHPExcel->getActiveSheet()->getStyle('K'.($l + 4).':O'.($l + 14))->applyFromArray($styleThickBorderOutline);
          $objPHPExcel->getActiveSheet()->getStyle('A2:O'.($l + 14))->applyFromArray($styleThickBorderOutline);
          $objPHPExcel->getActiveSheet()->getStyle('C15:C25')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G2:G20')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('K2:K20')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('H21:H24')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A25:A26')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('H3:O3')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('H5:O5')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A7:O7')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A14:O14')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A16:G16')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A18:G18')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A20:O20')->applyFromArray($styleThinBlackBorderbottom);
         
          // Rename sheet
          $objPHPExcel->setActiveSheetIndex(2);
          $objPHPExcel->getActiveSheet()->setTitle('Invoice2');
     
          // Set active sheet index to the first sheet,
          // so Excel opens this as the first sheet
          $objPHPExcel->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Combined Invoice.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));


        }}
        
       
        public function actionExternalInvoice($id){
             
            $Invoice = Invoice::model()->findbypk($id);
            
            //echo('<pre>');print_r($id.'-');die();
            $Invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice' => $id, 'activ'=>1,'movements'=>1)) ;         //   ("idinvoice=:idinvoice AND activ=:activ", array(":idinvoice"=>$id, "activ"=>1));
            if(!isset($Invoiceposkus))
                $Invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice' => $id, 'activ'=>1,'movements'=>2)) ;         //   ("idinvoice=:idinvoice AND activ=:activ", array(":idinvoice"=>$id, "activ"=>1));
            
            $locinvoice = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$id));
           
            $data = array();
            foreach($Invoiceposkus as $invoiceposku){
//                print_r($invoiceposku->idpo);
//            die();
                 if(!(isset($invoiceposku->idpo))){$po = "is Null";}else{$po = "= ". $invoiceposku->idpo;}
                 $sql = 'SELECT * FROM `tbl_locationstocks` where idsku = '.$invoiceposku->idsku.' and idlocationstocks='.$invoiceposku->idlocationstocks;
             //echo "<pre>";print_r($sql);die;
                $rows = Yii::app()->db->createCommand($sql)->queryRow();
                
                $data[$invoiceposku->idinvoiceposkus]['qty'] = $invoiceposku->shipqty;
                $data[$invoiceposku->idinvoiceposkus]['itemtype'] = $rows['item'];
                $data[$invoiceposku->idinvoiceposkus]['procode'] = $rows['locref'];
                $data[$invoiceposku->idinvoiceposkus]['totprice'] = $rows['pricepp'];
                
            }
            //echo('<pre>'); print_r($data); die();
             // get a reference to the path of PHPExcel classes
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
              spl_autoload_unregister(array('YiiBase','autoload'));

             
             // making use of our reference, include the main class
             // when we do this, phpExcel has its own autoload registration
             // procedure (PHPExcel_Autoloader::Register();)
             include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

             // Create new PHPExcel object
             $objPHPExcel = new PHPExcel();

             // Set properties
            $objPHPExcel->getProperties()->setCreator("GJMIS")
            ->setLastModifiedBy("GJMIS")
            ->setTitle("Excel Export Document")
            ->setSubject("Excel Export Document")
            ->setDescription("Exporting documents to Excel using php classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Excel export file");
              
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Jewels Corporation Ltd.')
            ->setCellValue('A3', 'Suite 7,Kajaine House,')
            ->setCellValue('A4', '57-67, High Street')
            ->setCellValue('A5', "Edgware, Middlesex HA8 7DD")
            ->setCellValue('A6', 'Phone +44 (0) 2036574982   Fax +44 (0) 2087324555')
            ->setCellValue('A8', 'Tel : +44 (0) 2036574982')
            ->setCellValue('C8', 'Fax : +44 (0) 2087324555')
            ->setCellValue('A9', 'Cust. No. : ')
            ->setCellValue('C9', 'Vat : ')
            ->setCellValue('C10', 'Date : '.date('d-m-y', strtotime($Invoice->mdate)))
            ->setCellValue('A10', 'Invoice No.: '.$id)
            ->setCellValue('A11', 'Representative:')
            ->setCellValue('A12', 'Tax Point : ')
            ->setCellValue('C12', 'Payment Terms : Advance')
            ->setCellValue('E2',  'Concern Person: '.$locinvoice->dperson)
            ->setCellValue('E4',  'Country: '.$locinvoice->dcountry)
            ->setCellValue('E5',  'Street: '.$locinvoice->dstreet)
            ->setCellValue('E6',  'Pincode: '.$locinvoice->dpincode)        
            ->setCellValue('E7',  'Phone: '.$locinvoice->dphone)
            ->setCellValue('E8',  'Concern Person: '.$locinvoice->sperson)
            ->setCellValue('E10', 'Country: '.$locinvoice->scountry)
            ->setCellValue('E11', 'Street: '.$locinvoice->sstreet)
            ->setCellValue('E12', 'Pincode: '.$locinvoice->spincode)
            ->setCellValue('E13', 'Phone: '.$locinvoice->sphone)
            ->setCellValue('A18', 'Product Code')
            ->setCellValue('B18', 'Quantity Delivered')
            ->setCellValue('C18', 'Product Description')
            ->setCellValue('D18', 'VAT%')
            ->setCellValue('E18', 'VAT GBP')
            ->setCellValue('F18', 'Unit Net Price Incl. Vat')
            ->setCellValue('G18', 'Total Net Price Incl. Vat')
            ->setCellValue('H18', 'VAT Code')
            ->setCellValue('A54', 'See our general terms and conditions of sale in our catalogue.')
            ->setCellValue('A55', '*** IF YOU HAVE A QUERY ON THIS INVOICE PLEASE CALL OUR CUSTOMER SERVICE DEPARTMENT***')
            ->setCellValue('A56', 'VAT Code % rate')
            ->setCellValue('A57', '')
            ->setCellValue('A58', '')
            ->setCellValue('A59', '')
            ->setCellValue('F54', 'Total Excl.VAT')
            ->setCellValue('F55', 'P&P')
            ->setCellValue('E58', 'Amount Due Inc. VAT:')
            ->setCellValue('E59', 'GBP')
            ->setCellValue('A61', 'Note:- This is  Included VAT Inoivce')
            ->setCellValue('E60', 'For Jewels Corporation Ltd.')
            ->setCellValue('E62', 'Auth. Signatory');
            //echo "<pre>";print_r($data);die;
            $i = 1;
            foreach($data as $item){
                if(isset($item['qty'])){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 18), $item['qty']);}else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 18),"");
                }
                if(isset($item['itemtype'])){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 18), $item['itemtype']);}else{
                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 18), '');
                }
                if(isset( $item['procode'])){
                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 18), $item['procode']);}else{
                  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 18), '');
                }
                if(isset($item['totprice'])){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 18), number_format($item['totprice'], 2, '.', ''));}else{
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($i + 18),'');
                }
                $objPHPExcel->getActiveSheet()->getStyle('F'.($i + 18))->getNumberFormat()->setFormatCode('0.00'); 
                $objPHPExcel->getActiveSheet()->getStyle('G'.($i + 18))->getNumberFormat()->setFormatCode('0.00');

                if(isset( $item['qty']) && isset($item['totprice'])){
                $objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G'.($i + 18), '=('.$item['totprice'].'*'.$item['qty'].')');}else{
                    $objPHPExcel->setActiveSheetIndex(0) ->setCellValue('G'.($i + 18), '');
                }
                 $i++;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G55', '=SUM(E19:E53)')
                    ->setCellValue('G54', '=(SUM(G19:G53) - SUM(E19:E53))')
                    ->setCellValue('G58', '=SUM(G19:G53)');
            
            $objPHPExcel->getActiveSheet()->getStyle('G55')->getNumberFormat()->setFormatCode('0.00');
            $objPHPExcel->getActiveSheet()->getStyle('G54')->getNumberFormat()->setFormatCode('0.00');
            $objPHPExcel->getActiveSheet()->getStyle('G58')->getNumberFormat()->setFormatCode('0.00');
          
            $styleArray = array(
                    'font' => array(
                            'bold' => true,
                            'italic' => true,
                            'font size' => '12'
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
            
            $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
             $styleArray3 = array(
                    'font' => array(
                            'bold' => true,
                            'font size' => '10'
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
          
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A18:H18')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A55:B55')->applyFromArray($styleArray3);
            $objPHPExcel->getActiveSheet()->getStyle('A56:A61')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('E56:H62')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('F54:H55')->applyFromArray($styleArray2);
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
            
            $objPHPExcel->getActiveSheet()->getStyle('F18')->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('G18')->getAlignment()->setWrapText(true);
            
            
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('image');
            $objDrawing->setDescription('image');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' . "/images/jewel_logo.jpg");
            $objDrawing->setCoordinates('A1');
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('deliver');
            $objDrawing->setDescription('deliver');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/deliver.jpg");
            $objDrawing->setCoordinates('D3');
            $objDrawing->setOffsetX(10); 
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('ship');
            $objDrawing->setDescription('ship');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/ship.jpg");
            $objDrawing->setCoordinates('D9');
            $objDrawing->setOffsetX(10); 
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Ref');
            $objDrawing->setDescription('ref');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/ref.jpg");
            $objDrawing->setCoordinates('A15');
            $objDrawing->setRotation(25);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
            $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
            $objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('E2:H2');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:H3');
            $objPHPExcel->getActiveSheet()->mergeCells('E4:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:H5');
            $objPHPExcel->getActiveSheet()->mergeCells('E6:H6'); 
            $objPHPExcel->getActiveSheet()->mergeCells('A7:C7');
            $objPHPExcel->getActiveSheet()->mergeCells('E7:H7');
            $objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
            $objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
            $objPHPExcel->getActiveSheet()->mergeCells('D2:D7');
            $objPHPExcel->getActiveSheet()->mergeCells('D8:D13');
            $objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
            $objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
            $objPHPExcel->getActiveSheet()->mergeCells('A12:B12');
            $objPHPExcel->getActiveSheet()->mergeCells('A13:C13');
            $objPHPExcel->getActiveSheet()->mergeCells('E8:H8');
            $objPHPExcel->getActiveSheet()->mergeCells('E9:H9');
            $objPHPExcel->getActiveSheet()->mergeCells('E10:H10');
            $objPHPExcel->getActiveSheet()->mergeCells('E11:H11');
            $objPHPExcel->getActiveSheet()->mergeCells('E12:H12');
            $objPHPExcel->getActiveSheet()->mergeCells('E13:H13');
            $objPHPExcel->getActiveSheet()->mergeCells('A14:C17');
            $objPHPExcel->getActiveSheet()->mergeCells('D14:H17');
            $objPHPExcel->getActiveSheet()->mergeCells('A55:E55');
         
             $styleThinBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
             
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                    ),
                ),
          );   
             
          $objPHPExcel->getActiveSheet()->getStyle('D1:H1')->applyFromArray($styleThinBlackBorderbottom);   
          $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->applyFromArray($styleThinBlackBorderbottom);   
          $objPHPExcel->getActiveSheet()->getStyle('A13:H13')->applyFromArray($styleThinBlackBorderbottom); 
          
          $objPHPExcel->getActiveSheet()->getStyle('A17:H17')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A18:H18')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A53:H53')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A55:H55')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A56:D56')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A59:H59')->applyFromArray($styleThinBlackBorderbottom);
          
          $objPHPExcel->getActiveSheet()->getStyle('C2:C17')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('H1:H59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G18:G53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F18:F53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('E18:E53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D18:D53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C18:C53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B18:B53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A18:A53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D56:D59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C56:C59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B56:B59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A56:A59')->applyFromArray($styleThinBlackBorderright);

          // Rename sheet
          //$objPHPExcel->setActiveSheetIndex(0);
          $objPHPExcel->getActiveSheet()->setTitle('VAT Inclusive Invoice');
          
          
          // For creating a new sheet
          $objPHPExcel->createSheet();
           $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A2', 'Jewels Corporation Ltd.')
            ->setCellValue('A3', 'Suite 7,Kajaine House,')
            ->setCellValue('A4', '57-67, High Street')
            ->setCellValue('A5', "Edgware, Middlesex HA8 7DD")
            ->setCellValue('A6', 'Phone +44 (0) 2036574982   Fax +44 (0) 2087324555')
            ->setCellValue('A8', 'Tel : +44 (0) 2036574982')
            ->setCellValue('C8', 'Fax : +44 (0) 2087324555')
            ->setCellValue('A9', 'Cust. No. : ')
            ->setCellValue('C9', 'Vat : ')
            ->setCellValue('C10', 'Date : '.date('d-m-y', strtotime($Invoice->mdate)))
            ->setCellValue('A10', 'Invoice No.: '.$id)
            ->setCellValue('A11', 'Representative:')
            ->setCellValue('A12', 'Tax Point : ')
            ->setCellValue('C12', 'Payment Terms : Advance')
            ->setCellValue('E2',  'Concern Person: '. $locinvoice->dperson)
            ->setCellValue('E4',  'Country: '.$locinvoice->dcountry)
            ->setCellValue('E5',  'Street: '.$locinvoice->dstreet)
            ->setCellValue('E6',  'Pincode: '.$locinvoice->dpincode)
            ->setCellValue('E7',  'Phone: '.$locinvoice->dphone)
            ->setCellValue('E8',  'Concern Person: '.$locinvoice->sperson)
            ->setCellValue('E10', 'Country: '.$locinvoice->scountry)
            ->setCellValue('E11', 'Street: '.$locinvoice->sstreet)
            ->setCellValue('E12', 'Pincode: '.$locinvoice->spincode)
            ->setCellValue('E13', 'Phone: '.$locinvoice->sphone)
            ->setCellValue('A18', 'Product Code')
            ->setCellValue('B18', 'Quantity Delivered')
            ->setCellValue('C18', 'Product Description')
            ->setCellValue('D18', 'Unit Gross Price Excl. Vat')
            ->setCellValue('E18', 'VAT GBP')
            ->setCellValue('F18', 'Unit Net Price Excl. Vat')
            ->setCellValue('G18', 'Total Net Price Excl. Vat')
            ->setCellValue('H18', 'VAT Code')
            ->setCellValue('A54', 'See our general terms and conditions of sale in our catalogue.')
            ->setCellValue('A55', '*** IF YOU HAVE A QUERY ON THIS INVOICE PLEASE CALL OUR CUSTOMER SERVICE DEPARTMENT***')
            ->setCellValue('A56', 'VAT Code % rate')
            ->setCellValue('A57', '')
            ->setCellValue('A58', '')
            ->setCellValue('A59', '')
            ->setCellValue('F54', 'Total Excl.VAT')
            ->setCellValue('F55', 'Total VAT')
            ->setCellValue('E58', 'Amount Due Inc. VAT:')
            ->setCellValue('E59', 'GBP')
            ->setCellValue('A61', 'Note:- This is  Included VAT Inoivce')
            ->setCellValue('E60', 'For Jewels Corporation Ltd.')
            ->setCellValue('E61', 'Auth. Signatory');
            $i = 1;
           foreach($data as $item){
                if(isset( $item['qty'])){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.($i + 18), $item['qty']);}else{
                    $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.($i + 18),"");
                }
                if(isset($item['itemtype'])){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.($i + 18), $item['itemtype']);}else{
                     $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.($i + 18), '');
                }
                if(isset( $item['procode'])){
                 $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($i + 18), $item['procode']);}else{
                  $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.($i + 18), '');
                }
                if(isset($item['totprice'])){
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.($i + 18), number_format($item['totprice'], 2, '.', ''));}else{
                   $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.($i + 18),'');
                }
                $objPHPExcel->getActiveSheet()->getStyle('F'.($i + 18))->getNumberFormat()->setFormatCode('0.00');
                
                if(isset( $item['qty']) && isset($item['totprice'])){
                $objPHPExcel->setActiveSheetIndex(1) ->setCellValue('G'.($i + 18), '=('.$item['totprice'].'*'.$item['qty'].')');}else{
                    $objPHPExcel->setActiveSheetIndex(1) ->setCellValue('G'.($i + 18), '');
                }
                $objPHPExcel->getActiveSheet()->getStyle('G'.($i + 18))->getNumberFormat()->setFormatCode('0.00');
                
                 $i++;
            }
           $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G55', '=SUM(E19:E53)')
                    ->setCellValue('G54', '=(SUM(G19:G53) - SUM(E19:E53))')
                    ->setCellValue('G58', '=SUM(G19:G53)');
            
           $objPHPExcel->getActiveSheet()->getStyle('G55')->getNumberFormat()->setFormatCode('0.00');
           $objPHPExcel->getActiveSheet()->getStyle('G54')->getNumberFormat()->setFormatCode('0.00');
           $objPHPExcel->getActiveSheet()->getStyle('G58')->getNumberFormat()->setFormatCode('0.00');
            
            
            $styleArray = array(
                    'font' => array(
                            'bold' => true,
                            'italic' => true,
                            'font size' => '12'
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
            
            $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
            
           
          
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A18:H18')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A55:A61')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('E56:H61')->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('F54:H55')->applyFromArray($styleArray2);
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
            
            $objPHPExcel->getActiveSheet()->getStyle('F18')->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('G18')->getAlignment()->setWrapText(true);
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('image');
            $objDrawing->setDescription('image');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' . "/images/jewel_logo.jpg");
            $objDrawing->setCoordinates('A1');
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('deliver');
            $objDrawing->setDescription('deliver');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/deliver.jpg");
            $objDrawing->setCoordinates('D3');
            $objDrawing->setOffsetX(10); 
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('ship');
            $objDrawing->setDescription('ship');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/ship.jpg");
            $objDrawing->setCoordinates('D9');
            $objDrawing->setOffsetX(10); 
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Ref');
            $objDrawing->setDescription('ref');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' ."/images/ref.jpg");
            $objDrawing->setCoordinates('A15');
            $objDrawing->setRotation(25);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            
            $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
            $objPHPExcel->getActiveSheet()->mergeCells('A4:C4');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
            $objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('E2:H2');
            $objPHPExcel->getActiveSheet()->mergeCells('E3:H3');
            $objPHPExcel->getActiveSheet()->mergeCells('E4:H4');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:H5');
            $objPHPExcel->getActiveSheet()->mergeCells('E6:H6'); 
            $objPHPExcel->getActiveSheet()->mergeCells('A7:C7');
            $objPHPExcel->getActiveSheet()->mergeCells('E7:H7');
            $objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
            $objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
            $objPHPExcel->getActiveSheet()->mergeCells('D2:D7');
            $objPHPExcel->getActiveSheet()->mergeCells('D8:D13');
            $objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
            $objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
            $objPHPExcel->getActiveSheet()->mergeCells('A12:B12');
            $objPHPExcel->getActiveSheet()->mergeCells('A13:C13');
            $objPHPExcel->getActiveSheet()->mergeCells('E8:H8');
            $objPHPExcel->getActiveSheet()->mergeCells('E9:H9');
            $objPHPExcel->getActiveSheet()->mergeCells('E10:H10');
            $objPHPExcel->getActiveSheet()->mergeCells('E11:H11');
            $objPHPExcel->getActiveSheet()->mergeCells('E12:H12');
            $objPHPExcel->getActiveSheet()->mergeCells('E13:H13');
            $objPHPExcel->getActiveSheet()->mergeCells('A14:C17');
            $objPHPExcel->getActiveSheet()->mergeCells('D14:H17');
            $objPHPExcel->getActiveSheet()->mergeCells('A54:E54');
            $objPHPExcel->getActiveSheet()->mergeCells('A55:E55');
         
             $styleThinBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
             
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );   
             
          $objPHPExcel->getActiveSheet()->getStyle('D1:H1')->applyFromArray($styleThinBlackBorderbottom);   
          $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->applyFromArray($styleThinBlackBorderbottom);   
          $objPHPExcel->getActiveSheet()->getStyle('A13:H13')->applyFromArray($styleThinBlackBorderbottom); 
          
          $objPHPExcel->getActiveSheet()->getStyle('A17:H17')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A18:H18')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A53:H53')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A55:H55')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A56:D56')->applyFromArray($styleThinBlackBorderbottom); 
          $objPHPExcel->getActiveSheet()->getStyle('A59:H59')->applyFromArray($styleThinBlackBorderbottom);
          
          $objPHPExcel->getActiveSheet()->getStyle('C2:C17')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('H1:H59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G18:G53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F18:F53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('E18:E53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D18:D53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C18:C53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B18:B53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A18:A53')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D56:D59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C56:C59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B56:B59')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A56:A59')->applyFromArray($styleThinBlackBorderright);
     
          $objPHPExcel->setActiveSheetIndex(1);
          $objPHPExcel->getActiveSheet()->setTitle('VAT Exclusive Invoice');
          
          
          // Set active sheet index to the first sheet,
          // so Excel opens this as the first sheet
          $objPHPExcel->setActiveSheetIndex(0);
          
            
            $pageMargins = $objPHPExcel->getActiveSheet(1)->getPageMargins();

            // margin is set in inches (0.5cm)
            $margin = .393;

            $pageMargins->setTop($margin);
            $pageMargins->setBottom($margin);
            $pageMargins->setLeft($margin);
            $pageMargins->setRight($margin);
            
            
            $objPHPExcel->getActiveSheet(0)->getPageSetup()->setFitToWidth(1);
            $objPHPExcel->getActiveSheet(1)->getPageSetup()->setFitToWidth(1);
            
            
          // Redirect output to a client's web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Invoice.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));
        }
        
        
        
        
        public function actionInvoiceaction(){
           $model = Invoice::model()->findByPk($_POST['idinvoice']);
           $dept = Dept::model()->findByPk($_POST['idlocation']);
           $skus = Locationstocks::model()->findAllByAttributes(array('iddept'=>$_POST['idlocation']));
           $skucodes = array();
           foreach($skus as $sku){
               $skucodes[] = $sku->idsku0->skucode;
           }
           $skucodes = array_unique($skucodes);
           //echo('<pre>');print_r(array_unique($skucodes));
           
            if($_POST['newdocument'] == 1){ 
                if($dept->idlocation == 1){
                echo ('<div class="ctrlHolder">
                       <label for="Invoice_idpo">Idpo</label>		
                       <input style="width:150px;" type="text" name="idpo" id="idpo">                
                       <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                       </div>');
             }else{
                 echo ('<div class="ctrlHolder">
                        <label for="Invoice_createdby">Created By</label>		
                        <input name="Invoice[createdby]" id="Invoice_createdby" type="text">			
                        </div>
                        <div class="ctrlHolder">
                        <label for="Invoice_SKU Codes"  class="required">Sku Code*</label>		
                        <input type="text" value="" name="Skus" id="Skus">            
                        <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                        </div>');
             }
            }else{
                if($dept->idlocation == 1){
                echo ('<div class="ctrlHolder">
                       <label for="Invoice_idpo">Idpo</label>		
                       <input style="width:150px;" type="text" name="idpo" id="idpo" value="'.$_POST['pos'].'" disabled="disabled">                
                       <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                       </div>');
             }else{
                 echo ('<div class="ctrlHolder">
                        <label for="Invoice_createdby">Created By</label>		
                        <input name="Invoice[createdby]" id="Invoice_createdby" type="text" disabled="disabled" value="'.$model->createdby.'">			
                        </div>
                        <div class="ctrlHolder">
                        <label for="Invoice_SKU IDs"  class="required">Sku  Ids*</label>		
                        <input type="text" name="Skus" id="Skus" disabled="disabled" value="'.$_POST['skus'].'" >            
                        <p class="formHint" style="display:inline-block; padding-left:0%; margin-left:1%; margin-right:2%">comma-separated</p>
                        </div>');
             }
            }
            
         }
         
         protected function availAmount($data, $row){
            if(!(isset($data->idpo))){$po = "is Null";}else{$po = "= ". $data->idpo;}
            $sql = 'SELECT * FROM `tbl_locationstocks` where idsku = '.$data->idsku.' and idpo '.$po;
            $rows = Yii::app()->db->createCommand($sql)->queryRow();
            //print_r($rows);die();
              if(!empty($rows)){
                    return ($rows['totqty']); 
               }
         }
         
         public function actionreturnInvoice($id){
             $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(53, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
             $model = Invoice::model()->findByPk($id);
             $locationmodel = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$model->idinvoice));
             $invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$model->idinvoice,'movements'=>1));
             $returninvoices = Invoicereturn::model()->findAllByAttributes(array('idinvoice'=>$id));
             if($model->iddept0->idlocation == 0){
                  Yii::app()->user->setFlash('fail', "This invoice cannot be returned.");
                  $this->redirect(array('admin'));
             }
             
             if(isset($_POST['Invoice'])){
                
             
                 if($_POST['Invoice']['retrn']){
                     $model->retrn = $_POST['Invoice']['retrn'];
                     $model->save();
                     $locationmodel->duedate = date("Y-m-d H:i:s");
                     $locationmodel->creditnum = 'GJ'.date("ymdhis", strtotime($locationmodel->duedate));
                     $locationmodel->save();
                     $display = 1;
                     
                     foreach($invoiceposkus as $invoiceposku){
                         $returninvoice = Invoicereturn::model()->findByAttributes(array('idinvoiceposku' => $invoiceposku->idinvoiceposkus, 'idinvoice'=>$invoiceposku->idinvoice));
                         if(!isset($returninvoice)){
                             $returninvoice = new Invoicereturn();
                             $returninvoice->idinvoice = $invoiceposku->idinvoice;
                             $returninvoice->idpo = $invoiceposku->idpo;
                             $returninvoice->idsku = $invoiceposku->idsku;
                             $returninvoice->idinvoiceposku =  $invoiceposku->idinvoiceposkus;
                             $returninvoice->save();
                             
                         }
                     }
                 
                 }
             } 
             
             if(isset($returninvoices)){
                 $poskus = new CActiveDataProvider('Invoicereturn', array(
                            'criteria'=>array(
                                'condition'=>'idinvoice='.$id,
                                ),
                            'pagination'=>array(
                                'pageSize'=>30,
                     )));
             }
             
             if(!isset($poskus)){
                         $poskus = (object)array();
             }
                     
             
             if(isset($_POST['returninvoice'])){
                 foreach($_POST['returninvoice'] as $key=>$value){
                     $returninvoice = Invoicereturn::model()->findByPk($key);
                     $invoiceposku = Invoiceposkus::model()->findByPk($returninvoice->idinvoiceposku);
					 $invoiceposku2 = Invoiceposkus::model()->findByAttributes(array('idinvoice'=>$model->idinvoice,'movements'=>2,'idsku' =>$returninvoice->idinvoicespokus0->idsku));
             
                     $locationstock = Locationstocks::model()->findByAttributes(array('idsku'=>$invoiceposku->idsku, 'po_num'=>$invoiceposku->idpo, 'iddept'=>$returninvoice->idinvoice0->idlocation));
					 $locationstock2 = Locationstocks::model()->findByAttributes(array('idsku'=>$invoiceposku2->idsku, 'po_num'=>$invoiceposku2->idpo, 'iddept'=>$model->deptto));
                     $sku = Sku::model()->findByPk($invoiceposku->idsku);    
                     if(($value - $returninvoice->returnqty) > $returninvoice->idinvoicespokus0->shipqty){
                           Yii::app()->user->setFlash('fail', "Cannot return more than shipped value.");
                           $this->redirect(array('returnInvoice','id'=>$id));
                     }
                     
                     if($returninvoice->returnqty != $value){
                         
                         $invoiceposku->shipqty = $invoiceposku->shipqty - ($value - $returninvoice->returnqty);

						 if(isset($invoiceposku2->shipqty)){
							$invoiceposku2->shipqty = $invoiceposku2->shipqty - ($value - $returninvoice->returnqty);
							$invoiceposku2->save();
						 }

                         $locationstock->qtyship = $locationstock->qtyship - ($value - $returninvoice->returnqty);
                         $locationstock->totwt = ($locationstock->totqty - $locationstock->qtyship)* $sku->grosswt;
                         $locationstock->totstone = ($locationstock->totqty - $locationstock->qtyship)* $sku->totstowei;
                         $locationstock->totmetwt = ($locationstock->totqty - $locationstock->qtyship)* $sku->totmetalwei;

						if(isset($locationstock2)){
							 $locationstock2->totqty = $locationstock2->totqty - ($value - $returninvoice->returnqty);
							 $locationstock2->totwt = ($locationstock2->totqty - $locationstock2->qtyship)* $sku->grosswt;
							 $locationstock2->totstone = ($locationstock2->totqty - $locationstock2->qtyship)* $sku->totstowei;
							 $locationstock2->totmetwt = ($locationstock2->totqty - $locationstock2->qtyship)* $sku->totmetalwei;
							 $locationstock2->save();
						}

                         $locationstock->save();
                         $invoiceposku->save();
                         $returninvoice->returnqty = $value;
                         $returninvoice->save();
                         
                         Deptskulog::feedInvoicereturndata($model);
                     }
                 }
                 
                 
                     
             }
             
             if($model->retrn == 1){
                 $display = 1;
             }else{
                 $display = 0;
             }
             $this->render('return',array(
			'model'=>$model, 'locationmodel'=>$locationmodel, 'display'=>$display, 'poskus'=>$poskus
		));
             
         }
         
         
         /**
          * This action is to generate credi note
          */
         public function actiongenCreditnote($id){
             
             $model = Invoice::model()->findByPk($id);
             $locationmodel = Locationinvoice::model()->findByAttributes(array('idinvoice'=>$model->idinvoice));
             $Invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice' => $id, 'activ'=>1)) ;         //   ("idinvoice=:idinvoice AND activ=:activ", array(":idinvoice"=>$id, "activ"=>1));
             $returninvoice = Invoicereturn::model()->findAllByAttributes(array('idinvoice'=>$id));
             $data = array();
             
             foreach($returninvoice as $invoice){
                 if(!(isset($invoice->idpo))){$po = "is Null";}else{$po = "= ". $invoice->idpo;}
                 $sql = 'SELECT re.idsku as idsku, lo.locref as code, lo.item as item, re.returnqty as qty, lo.pricepp as price FROM `tbl_invoicereturn` re, `tbl_locationstocks` lo where re.idinvoice = '.$id.' and re.idinvoicereturn = '.$invoice->idinvoicereturn.' and lo.idsku = re.idsku and re.returnqty != 0 and lo.iddept = '.$invoice->idinvoice0->idlocation.' and lo.idpo '.$po;
                 $rows = Yii::app()->db->createCommand($sql)->queryRow();
                 if($rows['qty'] != 0){
                 $data[$invoice->idinvoicereturn]['qty'] = $rows['qty'];
                 $data[$invoice->idinvoicereturn]['item'] = $rows['item'];
                 $data[$invoice->idinvoicereturn]['procode'] = $rows['code'];
                 $data[$invoice->idinvoicereturn]['amount'] = $rows['qty'] * $rows['price'];
                 }
             }
             
             // echo('<pre>');print_r($data);die();
             
              // get a reference to the path of PHPExcel classes
             $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');

             // Turn off our amazing library autoload
              spl_autoload_unregister(array('YiiBase','autoload'));

             
             // making use of our reference, include the main class
             // when we do this, phpExcel has its own autoload registration
             // procedure (PHPExcel_Autoloader::Register();)
             include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

             // Create new PHPExcel object
             $objPHPExcel = new PHPExcel();

             // Set properties
            $objPHPExcel->getProperties()->setCreator("GJMIS")
            ->setLastModifiedBy("GJMIS")
            ->setTitle("Excel Export Document")
            ->setSubject("Excel Export Document")
            ->setDescription("Exporting documents to Excel using php classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Excel export file");
            
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E1', 'CREDIT NOTE')
            ->setCellValue('D2', 'Jewels Corporation Ltd.')
            ->setCellValue('D3', 'SUITE NO-7, Kajaine House, 57-67, ')
            ->setCellValue('D4', "High Street")
            ->setCellValue('D5', 'Edgware, Middlesex ')
            ->setCellValue('D6', 'HA8 7DD')
            ->setCellValue('D7', 'Vat reg no: GB 125 2154 22')
            ->setCellValue('F7', 'Tel:  +44 (0) 2036574982')
            ->setCellValue('A11', 'Name: '.$locationmodel->dperson)
            ->setCellValue('A12', 'Company Name: ')
            ->setCellValue('A13', $locationmodel->dcountry.$locationmodel->dstreet.$locationmodel->dpincode)
            ->setCellValue('A15', 'Phone: '.$locationmodel->dphone)
            ->setCellValue('D10',  'Credit Note No.: '.$locationmodel->creditnum)
            ->setCellValue('D11',  'Page:-')
            ->setCellValue('D13',  'Invoice no: '.$id)
            ->setCellValue('D14',  'Payment terms:')
            ->setCellValue('D15', 'All Amount in:')
            ->setCellValue('E11', '1 of 1')
            ->setCellValue('E14', 'Credit note')
            ->setCellValue('F10', 'Date: '.date('d-m-y', strtotime($locationmodel->duedate)))
            ->setCellValue('F11', 'Due date: '.date('d-m-y',strtotime($locationmodel->duedate)))
            ->setCellValue('A17', 'Item Code')
            ->setCellValue('B17', 'Description')
            ->setCellValue('C17', 'Qty')
            ->setCellValue('D17', 'Net Amount')
            ->setCellValue('E17', 'Vat Details')
            ->setCellValue('E18', '%')
            ->setCellValue('F18', 'Amount')
            ->setCellValue('G17', 'Total')
            ->setCellValue('A33', 'Sub Total: VAT Total Prepayments received:')
            ->setCellValue('E33', 'VAT Rate')
            ->setCellValue('F33', 'VAT Amount')
            ->setCellValue('G33', 'Net Amount')
            ->setCellValue('A36', 'Total Excl.VAT')
            ->setCellValue('A38', 'Please remit payment (and all financial correspondence) to: SUITE NO-7, KAJAINE HOUSE, 57-67,  HIGH STREET EDGWARE, MIDDLESEX HA8 7DD UK')
            ->setCellValue('A44', 'Phone +44 (0) 2036574982')
            ->setCellValue('D39', 'Please make cheques payable to: Jewels Coporation Ltd.')
            ->setCellValue('D40', 'Note:- This is  Included VAT Inoivce')
            ->setCellValue('E41', 'Customer no.')
            ->setCellValue('F41', 'Credit note no.')
            ->setCellValue('G41', 'Total amount')
            ->setCellValue('D44', 'Bank: UK Bank Ltd')
            ->setCellValue('D45', 'Sort Code: 20-05-06')
            ->setCellValue('F45', 'Account No: 9800007');
            
            $i = 0;
            foreach($data as $values){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($i + 19), $values['procode']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($i + 19), $values['item']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($i + 19), $values['qty']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($i + 19), $values['amount'] );
                $i++;
            }
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G34','=SUM(F19:F32)');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G42','=SUM(F19:F32)');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F42',$locationmodel->creditnum);
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            
             
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('image');
            $objDrawing->setDescription('image');
            $objDrawing->setPath(Yii::app()->basePath  . '/..' . "/images/jewel_logo.jpg");
            $objDrawing->setCoordinates('A1');
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            
            
         $styleThinBlackBorderright = array(
                'borders' => array(
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
          );
             
          $styleThinBlackBorderbottom = array(
                'borders' => array(
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),
                    ),
                ),
          );   
          
          
          $objPHPExcel->getActiveSheet()->getStyle('G17:G36')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F17:F32')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('E17:E32')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D17:D36')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('B17:B36')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C17:C36')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A17:A35')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('E41:E42')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('F41:F42')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('G41:G42')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('C10:C15')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('D41:D42')->applyFromArray($styleThinBlackBorderright);
          $objPHPExcel->getActiveSheet()->getStyle('A9:C9')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A15:C15')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A16:G16')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A18:G18')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A32:G32')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E33:G33')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A35:C35')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('A36:G36')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E40:G40')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E41:G41')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E42:G42')->applyFromArray($styleThinBlackBorderbottom);
          $objPHPExcel->getActiveSheet()->getStyle('E17:F17')->applyFromArray($styleThinBlackBorderbottom);
          
          
           $styleArray = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
           
           $styleArray2 = array(
                    'font' => array(
                            'bold' => true,
                            'size' => '14',
                            'color' => array('rgb'=>'787878')
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
           
           
           $styleArray3 = array(
                    'font' => array(
                            'bold' => true,
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
            );
           
           
           $styleArray4 = array(
                    'font' => array(
                            'size' => '9',
                    ),
                    'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    ),
            );
           
           
           $objPHPExcel->getActiveSheet()->getStyle('C2:G7')->applyFromArray($styleArray);
           $objPHPExcel->getActiveSheet()->getStyle('A17:G18')->applyFromArray($styleArray);
           $objPHPExcel->getActiveSheet()->getStyle('A33:G36')->applyFromArray($styleArray);
           $objPHPExcel->getActiveSheet()->getStyle('D39:G41')->applyFromArray($styleArray);
           $objPHPExcel->getActiveSheet()->getStyle('E1:G1')->applyFromArray($styleArray2);
           $objPHPExcel->getActiveSheet()->getStyle('D17:F17')->applyFromArray($styleArray3); 
           $objPHPExcel->getActiveSheet()->getStyle('A38:B38')->applyFromArray($styleArray4); 
          
          $objPHPExcel->getActiveSheet()->mergeCells('A13:B14');
          $objPHPExcel->getActiveSheet()->mergeCells('E17:F17');
          
          
          $pageMargins = $objPHPExcel->getActiveSheet()->getPageMargins();

            // margin is set in inches (0.5cm)
            $margin = .393;

            $pageMargins->setTop($margin);
            $pageMargins->setBottom($margin);
            $pageMargins->setLeft($margin);
            $pageMargins->setRight($margin);
            $objPHPExcel->getActiveSheet(0)->getPageSetup()->setFitToWidth(1);
            
            
          // Set active sheet index to the first sheet,
          // so Excel opens this as the first sheet
          $objPHPExcel->setActiveSheetIndex(0);

          // Redirect output to a client's web browser (Excel2007)
          header('Content-Type: application/xlsx');
          header('Content-Disposition: attachment;filename="Credinote.xlsx"');
          header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          $objWriter->save('php://output');
          Yii::app()->end();

           // Once we have finished using the library, give back the
           // power to Yii...
           spl_autoload_register(array('YiiBase','autoload'));
              
            
            
         }
         
       
         /**
         * function to display sku stocks
         */
        protected function gridSkuStocks($data, $row){
            $locationstocks = Locationstocks::model()->findByAttributes(array('idsku'=>$data->idsku, 'idpo'=>$data->idpo, 'iddept'=>$data->idinvoice0->idlocation));
            
              if(!empty($locationstocks)){
                    return ($locationstocks->totqty - $locationstocks->qtyship); 
               }
        }
        
        protected function gridTotalSkus($data, $row){
            $invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$data->idinvoice,'movements'=>1));
            if(!isset($invoiceposkus))
                $invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$data->idinvoice,'movements'=>2));
            
            $totalsku = 0;
            
            foreach($invoiceposkus as $invoiceposku){
                if($invoiceposku->activ == 1)
                $totalsku +=  $invoiceposku->shipqty;
            }
            if(!empty($totalsku)){
            return($totalsku);
            }
        }
        
        
        protected function gridTotalAmount($data, $row){
            $invoiceposkus = Invoiceposkus::model()->findAllByAttributes(array('idinvoice'=>$data->idinvoice, 'movements'=>1));
            $invoice = Invoice::model()->findByPk($data->idinvoice);
            $totalskuprice = 0;
            
            foreach($invoiceposkus as $invoiceposku){
                if($invoiceposku->activ == 1){{
                    $locationstocks = Locationstocks::model()->findByAttributes(array('idsku'=>$invoiceposku->idsku,'iddept'=>$invoice->idlocation,'idpo'=>$invoiceposku->idpo));
                    $totalskuprice +=  ($invoiceposku->shipqty * ($locationstocks->pricepp));
                     
                 }
                }
            }
            if(!empty($totalskuprice)){
            return(round($totalskuprice ,2));
            }
        }
        
}
