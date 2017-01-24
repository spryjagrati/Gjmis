<?php

class StonevoucherController extends Controller
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
				'actions'=>array('admin','delete','maintain','stoneUpdate'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','maintain','stoneUpdate'),
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
                if(!in_array(22, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Stonevoucher;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stonevoucher']))
		{
			$model->attributes=$_POST['Stonevoucher'];
			if($model->save()){
                                $model->code = $this->generateVoucher($model->idstonevoucher);
                                $model->save();
				$this->redirect(array('admin'));
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
                if(!in_array(22, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
		if(isset($_POST['Stonevoucher']))
		{
			//echo('<pre>');print_r($_POST['Stonevoucher']);die();
                        $model->attributes=$_POST['Stonevoucher'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idstonevoucher));
		}

		$this->render('update',array(
			'model'=>$model,
		));
                
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
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
                if(!in_array(22, $value)){
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
		$dataProvider=new CActiveDataProvider('Stonevoucher');
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
                if(!in_array(22, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Stonevoucher('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stonevoucher']))
			$model->attributes=$_GET['Stonevoucher'];

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
		$model=Stonevoucher::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='stonevoucher-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        /**
         * Maintains content of voucher
         */
        public function actionMaintain($id){
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(22, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $models = Stonestocks::model()->findAllByAttributes(array('idstonevoucher'=>$id));
            if(!empty($models)){
                $this->redirect(array('stoneupdate','id'=>$id));
            }
            $model = new Stonestocks();
            $voucher = Stonevoucher::model()->findByPk($id);
            
            if($_POST['Stonestocks']){
                //echo('<pre>');print_r($_POST);die();
                if(isset($_POST['Stonestocks']['stonewt']) && isset($_POST['Stonestocks']['idstone'])){
                
                if(isset($voucher->issuedfrom)){
                    $model->idstone = $_POST['Stonestocks']['idstone'];
                    $model->qty = $_POST['Stonestocks']['qty'];
                    $model->idpo = $_POST['Stonestocks']['idpo'];
                    $model->stonewt = $_POST['Stonestocks']['stonewt'];
                    $model->remark = $_POST['Stonestocks']['remark'];
                    $model->acknow = $_POST['Stonestocks']['acknow'];
                    $model->skuname = trim($_POST['Stonestocks']['skuname']);
                    $model->set = trim($_POST['Stonestocks']['set']);
                    $model->idstonevoucher = $voucher->idstonevoucher;
                    $model->idlocation = $voucher->iddept0->idlocation;
                    $model->iddept = $voucher->issuedto;
                    $model->refrcvd = $voucher->issuedfrom;
                    $model->save(); 
                    
                    $modelnew = new Stonestocks();
                    $modelnew->idstone = $_POST['Stonestocks']['idstone'];
                    $modelnew->qty = -1 * abs($_POST['Stonestocks']['qty']);
                    $modelnew->idpo = $_POST['Stonestocks']['idpo'];
                    $modelnew->stonewt = -1 * $_POST['Stonestocks']['stonewt'];
                    $modelnew->remark = $_POST['Stonestocks']['remark'];
                    $modelnew->acknow = $_POST['Stonestocks']['acknow'];
                    $modelnew->skuname = $_POST['Stonestocks']['skuname'];
                    $modelnew->set = $_POST['Stonestocks']['set'];
                    $modelnew->idstonevoucher = $voucher->idstonevoucher;
                    $modelnew->idlocation = $voucher->iddept0->idlocation;
                    $modelnew->iddept = $voucher->issuedfrom;
                    $modelnew->refsent = $voucher->issuedto;
                    $modelnew->save();
                    
                    unset($_POST['Stonestocks']['idstone']);
                    unset($_POST['Stonestocks']['qty']);
                    unset($_POST['Stonestocks']['idpo']);
                    unset($_POST['Stonestocks']['stonewt']);
                    unset($_POST['Stonestocks']['remark']);
                    unset($_POST['Stonestocks']['acknow']);
                    unset($_POST['Stonestocks']['skuname']);
                    unset($_POST['Stonestocks']['set']);
                    
					if($_POST['Stonestocks']['more']){
                    foreach($_POST['Stonestocks']['more'] as $key=>$value){
                        $model = new Stonestocks();
                        $model->idstone = $value['idstone'];
                        $model->qty = $value['qty'];
                        $model->idpo = $value['idpo'];
                        $model->stonewt = $value['stonewt'];
                        $model->remark = $value['remark'];
                        $model->skuname = $value['skuname'];
                        $model->set = $value['set'];
                        if($value['acknow'] =='on' ){
                        $model->acknow = 1;}else{
                            $model->acknow = 0;
                        }
                        $model->idstonevoucher = $voucher->idstonevoucher;
                        $model->idlocation = $voucher->iddept0->idlocation;
                        $model->iddept = $voucher->issuedto;
                        $model->refrcvd = $voucher->issuedfrom;
                        $model->save();

                        $modelnew = new Stonestocks();
                        $modelnew->idstone = $value['idstone'];
                        $modelnew->qty = -1 * abs($value['qty']);
                        $modelnew->idpo = $value['idpo'];
                        $modelnew->stonewt =  -1 *$value['stonewt'];
                        $modelnew->remark = $value['remark'];
                        $modelnew->skuname = $value['skuname'];
                        $modelnew->set = $value['set'];
                         if($value['acknow'] =='on' ){
                        $modelnew->acknow = 1;}else{
                            $modelnew->acknow = 0;
                        }
                        $modelnew->idstonevoucher = $voucher->idstonevoucher;
                        $modelnew->idlocation = $voucher->iddept0->idlocation;
                        $modelnew->iddept = $voucher->issuedfrom;
                        $modelnew->refsent = $voucher->issuedto;
                        $modelnew->save();
                    }}
                    
                }else{
                    $model->idstone = $_POST['Stonestocks']['idstone'];
                    $model->qty = $_POST['Stonestocks']['qty'];
                    $model->idpo = $_POST['Stonestocks']['idpo'];
                    $model->stonewt = $_POST['Stonestocks']['stonewt'];
                    $model->remark = $_POST['Stonestocks']['remark'];
                    $model->acknow = $_POST['Stonestocks']['acknow'];
                    $model->skuname = $_POST['Stonestocks']['skuname'];
                    $model->set = $_POST['Stonestocks']['set'];
                    $model->idstonevoucher = $voucher->idstonevoucher;
                    $model->idlocation = $voucher->iddept0->idlocation;
                    $model->iddept = $voucher->issuedto;
                    $model->refrcvd = $voucher->issuedfrom;
                    $model->save();
                    
                    unset($_POST['Stonestocks']['idstone']);
                    unset($_POST['Stonestocks']['qty']);
                    unset($_POST['Stonestocks']['idpo']);
                    unset($_POST['Stonestocks']['stonewt']);
                    unset($_POST['Stonestocks']['remark']);
                    unset($_POST['Stonestocks']['acknow']);
                    unset($_POST['Stonestocks']['skuname']);
                    unset($_POST['Stonestocks']['set']);
                
					if($_POST['Stonestocks']['more']){
                    foreach($_POST['Stonestocks']['more'] as $key=>$value){
                        $model = new Stonestocks();
                        $model->idstone = $value['idstone'];
                        $model->qty = $value['qty'];
                        $model->idpo = $value['idpo'];
                        $model->stonewt = $value['stonewt'];
                        $model->remark = $value['remark'];
                        $model->skuname = $value['skuname'];
                        $model->set = $value['set'];
                         if($value['acknow'] =='on' ){
                        $model->acknow = 1;}else{
                            $model->acknow = 0;
                        }
                        $model->idstonevoucher = $voucher->idstonevoucher;
                        $model->idlocation = $voucher->iddept0->idlocation;
                        $model->iddept = $voucher->issuedto;
                        $model->refrcvd = $voucher->issuedfrom;
                        $model->save();
                    }}
                }
                
            }
             $this->redirect(array('stoneupdate','id'=>$id));
            }
            $this->render('maintain',array(
			  'model'=>$model,
            ));
            
        }
        
        
        /**
         * Generates voucher code based upon department
         */
        public function generateVoucher($id){
            $voucher = Stonevoucher::model()->findByPk($id);
            $strings = explode(' ', $voucher->iddept0->name);
            foreach($strings as $string){
                $vouchercode = $vouchercode.substr($string, 0, 1);
            }
            return($vouchercode.$id);
        }
        
        
        
        /**
         * Updates stone stock
         */
        public function actionstoneUpdate($id){
          
           $voucher = Stonevoucher::model()->findByPk($id);
           if($_POST['Stonestocks']){
                if(isset($voucher->issuedfrom)){ 
                    
                    foreach($_POST['Stonestocks'] as $k=>$v){
                        if($k === 'more'){ 
                    foreach($_POST['Stonestocks']['more'] as $key=>$value){
                        if($value['stonewt'] > 0 && isset($value['idstone'])){
                            $model = new Stonestocks();
                            $model->idstone = $value['idstone'];
                            $model->qty = $value['qty'];
                            $model->idpo = $value['idpo'];
                            $model->stonewt = $value['stonewt'];
                            $model->remark = $value['remark'];
                            $model->skuname = $value['skuname'];
                            $model->set = $value['set'];
                            if($value['acknow'] =='on' ){
                            $model->acknow = 1;}else{
                                $model->acknow = 0;
                            }
                            $model->idstonevoucher = $voucher->idstonevoucher;
                            $model->idlocation = $voucher->iddept0->idlocation;
                            $model->iddept = $voucher->issuedto;
                            $model->refrcvd = $voucher->issuedfrom;
                            $model->save();

                            $modelnew = new Stonestocks();
                            $modelnew->idstone = $value['idstone'];
                            $modelnew->qty = -1 * abs($value['qty']);
                            $modelnew->idpo = $value['idpo'];
                            $modelnew->stonewt = -1 * $value['stonewt'];
                            $modelnew->remark = $value['remark'];
                            $modelnew->skuname = $value['skuname'];
                            $modelnew->set = $value['set'];
                             if($value['acknow'] =='on' ){
                            $modelnew->acknow = 1;}else{
                                $modelnew->acknow = 0;
                            }
                            $modelnew->idstonevoucher = $voucher->idstonevoucher;
                            $modelnew->idlocation = $voucher->iddept0->idlocation;
                            $modelnew->iddept = $voucher->issuedfrom;
                            $modelnew->refsent = $voucher->issuedto;
                            $modelnew->save();
                    }
                    }
                    }else{
                        $model = Stonestocks::model()->findByPk($v['idstonestocks']);
                        $model->attributes = $v;
                        if($v['acknow'] =='on' ){
                            $model->acknow = 1;}else{
                                $model->acknow = 0;
                            }
                        $model->save();
                    }
                    }
                    
                
                    
                }else{  
                     foreach($_POST['Stonestocks'] as $k=>$v){
                         if($k === 'more'){
                             if($_POST['Stonestocks']['more']){
                    foreach($_POST['Stonestocks']['more'] as $key=>$value){
                        if($value['stonewt'] > 0 && isset($value['idstone'])){
                        $model = new Stonestocks();
                        $model->idstone = $value['idstone'];
                        $model->qty = $value['qty'];
                        $model->idpo = $value['idpo'];
                        $model->stonewt = $value['stonewt'];
                        $model->remark = $value['remark'];
                        $model->skuname = $value['skuname'];
                        $model->set = $value['set'];
                         if($value['acknow'] =='on' ){
                        $model->acknow = 1;}else{
                            $model->acknow = 0;
                        }
                        $model->idstonevoucher = $voucher->idstonevoucher;
                        $model->idlocation = $voucher->iddept0->idlocation;
                        $model->iddept = $voucher->issuedto;
                        $model->refrcvd = $voucher->issuedfrom;
                        $model->save();
                         }
                    }
                    }
                         }else{
                              $model = Stonestocks::model()->findByPk($v['idstonestocks']);
                                $model->attributes = $v;
                                if($v['acknow'] =='on' ){
                            $model->acknow = 1;}else{
                                $model->acknow = 0;
                            }
                                $model->save();
                         }
                     }
                    
               
            }
             $this->redirect(array('stoneupdate','id'=>$id));
            }
            $models = Stonestocks::model()->findAllByAttributes(array('idstonevoucher'=>$id,'iddept'=>$voucher->issuedto));
            foreach($models as $key=>$model){
                if(($model->qty) < 0){
                    unset($models[$key]);
                }
            }
            
            $this->render('stoneupdate',array(
			  'models'=>$models,
            ));
        }
}
