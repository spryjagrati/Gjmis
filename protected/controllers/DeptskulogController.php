<?php

class DeptskulogController extends Controller
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
				'actions'=>array('admin','delete','getskucode','getreference'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update' , 'uploadStocks'),
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
        $uid = Yii::app()->user->getId(); 
        if($uid != 1){
            $value = ComSpry::getUnserilizedata($uid);
            if(empty($value) || !isset($value)){
                throw new CHttpException(403,'You are not authorized to perform this action.');
            }
            if(!in_array(23, $value)){
                throw new CHttpException(403,'You are not authorized to perform this action.');
            }
        }   
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
            if(!in_array(23, $value)){
                throw new CHttpException(403,'You are not authorized to perform this action.');
            }
        }
            
		$model=new Deptskulog;
        $modelsku=new Sku('search');
		$modelsku->unsetAttributes();  // clear any default values
                
		if(isset($_GET['Sku']))
			$modelsku->attributes=$_GET['Sku'];
	
		if(isset($_POST['Deptskulog']) && isset($_POST['skucode']) && $_POST['skucode']){    
            $sku = Sku::model()->findByAttributes(array('idsku'=>$_POST['skucode']));
            $model->idsku = $sku->idsku;
			$model->attributes=$_POST['Deptskulog'];
                        
            if(isset($_POST['Deptskulog']['refsent']) && $_POST['Deptskulog']['refsent']){
                $model->qty = $model->qty * (-1);
            }
                        
			if($model->save()){
                if((isset($model->refrcvd) && $model->refrcvd) || (isset($model->refsent) && $model->refsent)){
                    $model->reverseStock();
                    $model->showdata = 1;
                    $model->save();
                }

                Locationstocks::locationupdate($model->iddeptskulog, 1);
                $this->redirect(array('admin'));
            }
        }

		$this->render('create',array(
			'model'=>$model,'modelsku'=>$modelsku
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
                if(!in_array(23, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $model=$this->loadModel($id);

            if(isset($_POST['Deptskulog']))
            {
                $sku = Sku::model()->findByAttributes(array("idsku"=>$_POST["skucode"]));
                $model->lastqty = $model->qty;
                $model->attributes=$_POST['Deptskulog'];
                $model->idsku = $sku->idsku;

                if($model->save()) {
                    if((isset($model->refrcvd) && $model->refrcvd) || (isset($model->refsent) && $model->refsent)){
                        $model->reverseStock();
                    }
                    Locationstocks::locationupdate($model->iddeptskulog, 1);
                    $this->redirect(array('update','id'=>$model->iddeptskulog));
                }
            }

            $this->render('update',array(
                    'model'=>$model,
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
                if(!in_array(23, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
                        Locationstocks::locationupdate($model->iddeptskulog, -1);
                        
                        if(isset($model->refrcvd) && isset($model->refrcvd)){
                            $dept = $model->refrcvd;
                            Deptskulog::model()->findByAttributes(array( 'iddept' => $dept, 'idsku' => $model->idsku, 'po_num' => $model->po_num))->delete();
                        }else if(isset($model->refsent) && isset($model->refsent)){
                            $dept = $model->refsent;
                            Deptskulog::model()->findByAttributes(array( 'iddept' => $dept, 'idsku' => $model->idsku, 'po_num' => $model->po_num))->delete();
                        }
                        
                        $model->delete();

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
		$dataProvider=new CActiveDataProvider('Deptskulog');
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
                    if(!in_array(23, $value)){
                        throw new CHttpException(403,'You are not authorized to perform this action.');
                    }
                }
                
		$model=new Deptskulog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Deptskulog']))
			$model->attributes=$_GET['Deptskulog'];

                
		$this->render('admin',array(
			'model'=>$model,
		));
               
	}

        public function actionGetskucode(){	      
 		$lista=Sku::model()->findAll(
                    array(
                          'select'=>'idsku, skucode',
                          'condition'=>"skucode LIKE '%" .$_GET['q']. "%'"
                         ));    
                    $reusults = array();
                    foreach ($lista as $list){
                    $reusults[] = array(
                        'id'=>$list->idsku,
                        'skucode'=>  $list->skucode,
           ); 
        }
         
                echo CJSON::encode($reusults);  

   }    

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Deptskulog::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='deptskulog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
   public function actionGetreference(){
       $iddept = $_POST['id'];
       $items = Dept::model()->findAll('iddept <>'.$iddept);
       $a[] = "<option value=''></option>";
       foreach($items as $item){
            $a[].= "<option value='$item->iddept'>".$item->idlocation0->name.'-'.$item->name."</option>";
        }
        echo json_encode($a);
    }	


    public function actionUploadStocks(){
    	$model=new Deptskulog;
    	$currencyarr = ['Dollar' => 1 , 'Rupee' => 2,'Pound' => 3];
    	if(isset($_POST['Deptskulog'])){
    		$deptsku = $_POST['Deptskulog'];
    		$uploadFile=CUploadedFile::getInstance($model,'inputfile');
    		if(!isset($uploadFile)){
    			Yii::app()->user->setFlash('uploadfile', 'File can not be blank');
		       	$this->redirect('uploadStocks');
    		}
            $tempname=$uploadFile->getTempName(); $filename =$uploadFile->name;
            $new_path = Yii::app()->getBasePath() . '/../images/temp/'.$filename;
            move_uploaded_file($tempname, $new_path);
            $extension = strtoupper(pathinfo($uploadFile, PATHINFO_EXTENSION));
           	$inputFileName = $new_path;
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
    		spl_autoload_unregister(array('YiiBase', 'autoload'));
    		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
    		
            if($extension == 'XLSX' || $extension == 'CSV' || $extension == 'XLS'){
            	try {
		            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
				    $objPHPExcel = $objReader->load($inputFileName);
				    spl_autoload_register(array('YiiBase','autoload'));
		        } catch(Exception $e) {
		            die($e->getMessage());
		        }
		        $sheet = $objPHPExcel->getSheet(0); 
		        $highestRow = $sheet->getHighestDataRow();
		        $highestColumn = 'G';
		        $headings = $sheet->rangeToArray('A2:G2');
		        
		        //check for empty value 
		        $check =array();
		        for($row = 2; $row <= $highestRow; $row++){
		        	for ($column = 0; $column < 7; $column++) {
		        		$header = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow($column, '1')->getValue();
		        	 	$value = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow($column, $row)->getValue();
		        	 	if($column < 3 && $value == ''){
		        	 	 	Yii::app()->user->setFlash('uploadfile', 'There was some problem with your uploaded file');
		        	 	 	$this->redirect('uploadStocks');
		        	 	}
		        	 	if($column == 0 && $value !== '' ){
		        	 		$sku = Sku::model()->findByAttributes(array('skucode'=>$value));
		        	 		if(empty($sku)){ //changed isset condition to empty
		        	 			Yii::app()->user->setFlash('uploadfile', 'Please check uploaded file Sku values');
		        	 	 		$this->redirect('uploadStocks');
		        	 		}
		        	 	}
		        	 	$new[$row][$header] = $value;
		        	}
		        }

		        if(!isset($new)){
		        	Yii::app()->user->setFlash('uploadfile', 'Uploaded file can not be blank');
		        	$this->redirect('uploadStocks');
		        }

		        //read and insert data 
		        foreach ($new as $key => $value) {
		        	$model=new Deptskulog;$currency = '';	
		        	$model->attributes = $_POST['Deptskulog'];
		        	$sku = Sku::model()->findByAttributes(array('skucode'=>$value['SKU #']));
            		$model->idsku = $sku->idsku;
		        	$model->qty = $value['Quantity'];
		        	$model->po_num = $value['PO #'];
		        	if(isset($value['Currency'])){
		        		$curncy = ucfirst(trim($value['Currency']));
		        		if(array_key_exists($curncy, $currencyarr))
		        			$currency = $currencyarr[$curncy];	
		        	}
		        	if(isset($_POST['Deptskulog']['refsent']) && $_POST['Deptskulog']['refsent']){
		                $model->qty = $model->qty * (-1);
		            }
		        	$model->pricepp = $value['Price Per Piece'];
		        	if($model->save()){
		        		$model->uploadreverseStock($model->idsku , $model->po_num, $model->qty, $model->pricepp);
	                    $model->showdata = 1;
	                    $model->save();
	                    Locationstocks::uploadlocationupdate($model->iddeptskulog, 1 ,$value['Location Ref.'] ,$value['Currency'],$value['Price PP'] );
		        	}
		        }
		        Yii::app()->user->setFlash('uploadfile', 'Sku stock is uploaded successfully');
		        $this->redirect(array('uploadStocks'));
			}else{
				Yii::app()->user->setFlash('uploadfile', 'Invalid extension, only xlsv,xls,csv file formats are allowed.');
		       	$this->redirect('uploadStocks');
			}	
		}
    	
    	$this->render('uploadstocks',array('model'=>$model));
    }
}
