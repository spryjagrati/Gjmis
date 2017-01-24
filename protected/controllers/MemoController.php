<?php

class MemoController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('createapproval','updateapproval','returnApproval', 'index','view','approval', 
                                    'quote', 'admin', 'search', 'UpdateAjax', 'exportApproval','Createquote','Updatequote',
                                    'returnQuote'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users' => Yii::app()->getModule("user")->getAdmins(),
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
	public function actionCreateapproval()
	{
		$model=new Memo();
                $skumodel = new Memosku();
                $dept = isset($_POST['Memo']['iddptfrom']) ? $_POST['Memo']['iddptfrom'] : 1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Memo']) && isset($_POST['Memosku']))
		{
			$model->attributes=$_POST['Memo'];
                        if($model->approved()->codify()->save() && $skumodel->saveSkus($_POST, $model)){
                            $this->redirect(array('approval'));
                        }	
		}

		$this->render('create',array(
			'model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateapproval($id)
	{
		$model=$this->loadModel($id);
                $skumodel = new Memosku();
                $dept = isset($_POST['Memo']['iddptfrom']) ? $_POST['Memo']['iddptfrom'] : 1;
                $dataprovider = $this->loadSkudataprovider($id);
                
		if(isset($_POST['Memo']))
		{
                    $model->attributes=$_POST['Memo'];
                    if($model->save()){
                        $this->redirect(array('approval'));
                    }	
		}
                
                if(isset($_POST['shipped']) && !empty($_POST['shipped'])){
                    if(Memosku::updateSkuqty($id, $_POST['shipped'], 1)){
                        Deptskulog::feedMemodata($model);
                        $this->redirect(array('updateapproval','id'=>$model->idmemo));
                    }else{
                        Yii::app()->user->setFlash('fail', "There is some problem with the entered values");
                        $this->redirect(array('updateapproval','id'=>$id));
                    }
                }

		$this->render('update_approval',array(
			'model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept,
                        'dataprovider' => $dataprovider,
		));
	}
        
        /**
         * returning an approval memo
         */
        public function actionreturnApproval($id){
            $model=$this->loadModel($id);
            $skumodel = new Memosku();
            $dataprovider = $this->loadReturnSkudataprovider($id);
            if(isset($_POST['Memo']))
            {
                $status = $model->status;
                $model->attributes=$_POST['Memo'];
                
                if($_POST['Memo']['status'] != 3){
                    $model->status = $status;
                }
                if($model->save()){
                    $this->redirect(array('returnApproval','id'=>$id));
                }	
            }
            
            if(isset($_POST['memosku']) && !empty($_POST['memosku'])){
                if(Memosku::updateReturnSku($_POST['memosku'])){
                    Deptskulog::feedreturnMemodata($model);
                    $this->redirect(array('returnApproval','id'=>$id));
                }else{
                    Yii::app()->user->setFlash('fail', "There is some problem with the entered values");
                    $this->redirect(array('returnApproval','id'=>$id));
                }
            }
            
            $this->render('return_approval',array(
                    'model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider,
            ));
        }
        
        public function actionUpdateAjax()
        {
            $skumodel = new Memosku();

            $this->renderPartial('_ajaxmultiContent', array('skumodel' => $skumodel, 'dept' => $_POST['dept']), false, true);
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$skus = Memosku::model()->findAllByAttributes(array('idmemo' => $id, 'type' => 1));
                        
                        foreach($skus as $sku){
                            $returnmemo = Memosku::model()->findByAttributes(array('idsku' => $sku->idsku, 'idmemo' => $sku->idmemo, 'type' => 2));
                            $locationstock = Locationstocks::model()->findByAttributes(array('idsku'=>$sku->idsku, 'iddept' => $sku->idmemo0->iddptfrom));
                            if(isset($returnmemo)){
                                $locationstock->qtyship -=  ($sku->qty - $returnmemo->qty);
                                $returnmemo->delete();
                            }else{
                                $locationstock->qtyship -=  ($sku->qty);
                            }
                            $locationstock->save();
                            $sku->delete();
                        }
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
		$dataProvider=new CActiveDataProvider('Memo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionApproval()
	{
		$model=new Memo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Memo']))
			$model->attributes=$_GET['Memo'];

		$this->render('approval_admin',array(
			'model'=>$model->approval(),
		));
	}
        
        /**
	 * Manages all models.
	 */
	public function actionQuote()
	{
		$model=new Memo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Memo']))
			$model->attributes=$_GET['Memo'];

		$this->render('quote_admin',array(
			'model'=>$model->quote(),
		));
	}
        
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreatequote()
	{
		$model=new Memo();
                $skumodel = new Memosku();
                $dept = isset($_POST['Memo']['iddptfrom']) ? $_POST['Memo']['iddptfrom'] : 1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Memo']) && isset($_POST['Memosku']))
		{
			$model->attributes=$_POST['Memo'];
                        if($model->quotified()->codify()->save() && $skumodel->saveSkus($_POST, $model)){
                            $this->redirect(array('quote'));
                        }	
		}

		$this->render('createquote',array(
			'model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept,
		));
	}
        
        /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatequote($id)
	{
		$model=$this->loadModel($id);
                $skumodel = new Memosku();
                $dept = isset($_POST['Memo']['iddptfrom']) ? $_POST['Memo']['iddptfrom'] : 1;
                $dataprovider = $this->loadSkudataprovider($id);
                
		if(isset($_POST['Memo']))
		{
                    $model->attributes=$_POST['Memo'];
                    if($model->save()){
                        Deptskulog::feedMemodata($model);
                        $this->redirect(array('quote'));
                    }	
		}
                
                if(isset($_POST['shipped']) && !empty($_POST['shipped'])){
                    if(Memosku::updateSkuqty($id, $_POST['shipped'], 2)){
                        $this->redirect(array('updatequote','id'=>$model->idmemo));
                    }else{
                        Yii::app()->user->setFlash('fail', "There is some problem with the entered values");
                        $this->redirect(array('updatequote','id'=>$id));
                    }
                }

		$this->render('update_quote',array(
			'model'=>$model, 'skumodel' => $skumodel, 'dept' => $dept,
                        'dataprovider' => $dataprovider,
		));
	}
        
        
        /**
         * returning an approval memo
         */
        public function actionreturnQuote($id){
            $model=$this->loadModel($id);
            $skumodel = new Memosku();
            $dataprovider = $this->loadReturnSkudataprovider($id);
            if(isset($_POST['Memo']))
            {
                $status = $model->status;
                $model->attributes=$_POST['Memo'];
                
                if($_POST['Memo']['status'] != 3){
                    $model->status = $status;
                }
                if($model->save()){
                    $this->redirect(array('returnQuote','id'=>$id));
                }	
            }
            
            if(isset($_POST['memosku']) && !empty($_POST['memosku'])){
                if(Memosku::updateReturnSku($_POST['memosku'])){
                    Deptskulog::feedreturnMemodata($model);
                    $this->redirect(array('returnQuote','id'=>$id));
                }else{
                    Yii::app()->user->setFlash('fail', "There is some problem with the entered values");
                    $this->redirect(array('returnQuote','id'=>$id));
                }
            }
            
            $this->render('return_quote',array(
                    'model'=>$model, 'skumodel' => $skumodel, 'dataprovider' => $dataprovider,
            ));
        }
        
        

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Memo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        /**
         * load all skus related to memo
         */
        public function loadSkudataprovider($id){
            $model = $this->loadModel($id);
            $stocks = Memosku::getskus($id, 1);
            $dataProvider=new CActiveDataProvider('Locationstocks', array(
                    'criteria'=>array(
                         'condition'=>'idsku in ('.$stocks.') and iddept = '.$model->iddptfrom,
                    ),
                    'pagination'=>array(
                        'pageSize'=>100,
                    )
            ));
            return $dataProvider;
        }
        
        /**
         * load all skus related to memo
         */
        public function loadReturnSkudataprovider($id){
            $model = $this->loadModel($id);
            $stocks = Memosku::getskus($id, 1);
            $dataProvider=new CActiveDataProvider('Memosku', array(
                    'criteria'=>array(
                         'condition'=>'idsku in ('.$stocks.') and type = 1 and idmemo = '.$id,
                    ),
                    'pagination'=>array(
                        'pageSize'=>100,
                    )
            ));
            return $dataProvider;
        }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='memo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionSearch()
        {
              if(Yii::app()->request->isAjaxRequest && !empty($_REQUEST['term']) && !empty($_REQUEST['dept']))
            {
                $sql = "SELECT l.idsku as idsku, s.skucode as skucode from tbl_locationstocks l, tbl_sku s where l.idsku = s.idsku and l.iddept = " . $_REQUEST['dept'] . " and s.skucode like '".$_REQUEST['term']."%' order by s.skucode ASC";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();

                if (isset($rows) && !empty($rows)) {
                    $data = array_column($rows, 'skucode');
                    echo CJSON::encode($data);
                }else{
                    echo CJSON::encode(array());
                }
                
                
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
}
