<?php

class SkucontentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1_new';

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','create','update','upload'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
                if(!in_array(3, $value)){
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
		$model=new Skucontent;

                // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Skucontent']))
		{
			$model->attributes=$_POST['Skucontent'];
                        if($model->save())
				$this->redirect(array('view','id'=>$model->idskucontent));
		}
                //$model->idsku=$_GET['idsku'];

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Skucontent']))
		{
			$model->attributes=$_POST['Skucontent'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idskucontent));
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
		if(Yii::app()->request->isPostRequest)
		{
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
		$dataProvider=new CActiveDataProvider('Skucontent');
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
               // print_r($value);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(3, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Skucontent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Skucontent']))
			$model->attributes=$_GET['Skucontent'];

		$this->render('admin',array(
			'model'=>$model,
		));
                 
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Skucontent::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='skucontent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	//chaintype and clasp type upload
	
	public function actionUpload(){
        $model=new Skucontent();
        if(isset($_POST['Skucontent'])){
        	$uploadFile=CUploadedFile::getInstance($model,'inputfile');
        	if(!isset($uploadFile)){
    			Yii::app()->user->setFlash('uploadfile', 'File can not be blank');
		       	$this->redirect('upload');
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
		        $colString = $sheet->getHighestDataColumn();
		        $highestColumn =PHPExcel_Cell::columnIndexFromString($colString);
		       
		        for($column = 1; $column <= $highestColumn; $column++){
		        	$header = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow($column, '1')->getValue();
		        	if($header == 'Clasp Type'){
		        		$claspcount = $column;
		        	}
		        	if($header == 'Chain Type'){
		        		$chaincount = $column;
		        	}
		        }
		        for($row = 2; $row <= $highestRow; $row++){
		        	$skuname = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow(1,$row)->getValue();
		        	$clasptype = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow($claspcount,$row)->getValue();
		        	$chaintype = $objPHPExcel->setActiveSheetIndex(0)->getCellByColumnAndRow($chaincount,$row)->getValue();
	        		if(!empty($skuname)){
	        			$content = Skucontent::model()->findByAttributes(array('name'=>$skuname));
	        			if(isset($content)){
	        				$content->chaintype = $chaintype;
	        				$content->clasptype = $clasptype;
	        				$content->save();
	        			}
		        	} 
		        }
		        Yii::app()->user->setFlash('uploadfile', 'File is uploaded successfully');
		        $this->redirect(array('upload'));
    		}
        }
        $this->render('upload',array(
			'model'=>$model,
		));
    }
}
