<?php

class CostaddController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
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
                if(!in_array(35, $value)){
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
                if(!in_array(35, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Costadd;
                $models = '';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Costadd']))
		{
			$model->attributes=$_POST['Costadd'];
			if($model->save())
				$this->redirect(array('create'));
		}else{
                    $models=new Costadd('search');
                    $models->unsetAttributes();  // clear any default values
                    if(isset($_GET['Costadd']))
                            $models->attributes=$_GET['Costadd'];
                }

		$this->render('create',array(
			'model'=>$model,'models'=>$models,
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
                if(!in_array(35, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Costadd']))
		{
			$model->attributes=$_POST['Costadd'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idcostadd));
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
                if(!in_array(35, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
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
		$dataProvider=new CActiveDataProvider('Costadd');
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
                if(!in_array(35, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Costadd('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Costadd']))
			$model->attributes=$_GET['Costadd'];

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
		$model=Costadd::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='costadd-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}