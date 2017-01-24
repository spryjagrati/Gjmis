<?php

class MatreqController extends Controller
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
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
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
                if(!in_array(24, $value)){
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
                if(!in_array(24, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Matreq;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Matreq']))
		{
			$model->attributes=$_POST['Matreq'];
                        $model->idstatusm=ComSpry::getDefReqStatusm();
                        $model->sdate=date('Y-m-d H:i:s');
			if($model->save()){
                            $modellog=new Matreqlog('insert');
                            $modellog->idmatreq=$model->idmatreq;
                            $modellog->rqty=$model->rqty;
                            $modellog->fqty=$model->fqty;
                            $modellog->idstatusm=$model->idstatusm;
                            if($modellog->save())
				$this->redirect(array('view','id'=>$model->idmatreq));
                            else
                                Yii::app()->user->setFlash('matreqlog','Status log could not be created.');
                            $this->redirect(array('view','id'=>$model->idmatreq));
                        }
		}

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
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(24, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Matreq']))
		{
			$model->attributes=$_POST['Matreq'];
                        $model->edate=date('Y-m-d H:i:s');
                        $model->idstatusm=ComSpry::getDefReqffStatusm();
			if($model->save()){
                            $this->updateDeptLog($model);
                            
                            $modellog=new Matreqlog('insert');
                            $modellog->idmatreq=$model->idmatreq;
                            $modellog->rqty=$model->rqty;
                            $modellog->fqty=$model->fqty;
                            $modellog->idstatusm=$model->idstatusm;
                            if($modellog->save())
				$this->redirect(array('view','id'=>$model->idmatreq));
                            else
                                Yii::app()->user->setFlash('matreqlog','Status log could not be created.');
                            $this->redirect(array('view','id'=>$model->idmatreq));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
                
	}

        protected function updateDeptLog($model){
            $modellog1='';$modellog2='';
            switch ($model->type) {
                case 'metal':
                    $modellog1=new Deptmetallog('insert');$modellog1->idmetal=$model->idmetal;$modellog1->save();
                    $modellog2=new Deptmetallog('insert');$modellog2->idmetal=$model->idmetal;$modellog2->save();
                    break;
                case 'stone':
                    $modellog1=new Deptstonelog('insert');$modellog1->idstone=$model->idstone;$modellog1->save();
                    $modellog2=new Deptstonelog('insert');$modellog2->idstone=$model->idstone;$modellog2->save();
                    break;
                case 'chemical':
                    $modellog1=new Deptchemlog('insert');$modellog1->idchemical=$model->idchemical;$modellog1->save();
                    $modellog2=new Deptchemlog('insert');$modellog2->idchemical=$model->idchemical;$modellog2->save();
                    break;
                case 'finding':
                    $modellog1=new Deptfindlog('insert');$modellog1->idfinding=$model->idfinding;$modellog1->save();
                    $modellog2=new Deptfindlog('insert');$modellog2->idfinding=$model->idfinding;$modellog2->save();
                    break;
            }
            $modellog1->qty=(-1)*$model->fqty;$modellog2->qty=(1)*$model->fqty;
            $modellog1->idpo=$model->idpo;$modellog2->idpo=$model->idpo;
            if($model->type=='metal' || $model->type=='chemical'){
                $modellog1->cunit=$model->qunit;$modellog2->cunit=$model->qunit;
            }
            //assign departments respectively
            $modellog1->iddept=$model->reqby;$modellog2->iddept=$model->reqto;
            $modellog1->refsent=$model->reqto;$modellog2->refrcvd=$model->reqby;

            if($modellog1->save()&&$modellog2->save()){
               // echo 'Department material log updated successfully\n';return true;
            }else{
               // echo 'Department material log could not be updated\n';return false;
            }
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
                if(!in_array(24, $value)){
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
		$dataProvider=new CActiveDataProvider('Matreq');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

         public function getunserilizedata($uid)
        {
          $usermodel = User::model()->findByPk($uid);
        $values = unserialize($usermodel->accessdetails);
        return $values;
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
                if(!in_array(24, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Matreq('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Matreq']))
			$model->attributes=$_GET['Matreq'];

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
		$model=Matreq::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='matreq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
