<?php

class MetalmController extends Controller
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
                if(!in_array(42, $value)){
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
                if(!in_array(42, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Metalm;
                $models = '';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Metalm']))
		{
			$model->attributes=$_POST['Metalm'];
			if($model->save())
				$this->redirect(array('create'));
		}
                    $models=new Metalm('search');
                    $models->unsetAttributes();  // clear any default values
                    if(isset($_GET['Metalm']))
                            $models->attributes=$_GET['Metalm'];
                

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
                if(!in_array(42, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Metalm']))
		{
			$model->attributes=$_POST['Metalm'];
                        
                        foreach($model->metals as $metal){
                            $metal->prevcost = $metal->currentcost;
                            $metal->currentcost = $model->currentcost;
                            if($metal->save()){
                                $metalcostlog=new Metalcostlog('insert');
                                $metalcostlog->cdate=$metal->cdate;
                                $metalcostlog->mdate=$metal->mdate;
                                $metalcostlog->updby=$metal->updby;
                                $metalcostlog->cost=$metal->currentcost;
                                $metalcostlog->idmetal=$metal->idmetal;
                                $metalcostlog->save();
                            }
                        }
                        
			if($model->save())
				$this->redirect(array('view','id'=>$model->idmetalm));
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
                if(!in_array(42, $value)){
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
		$dataProvider=new CActiveDataProvider('Metalm');
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
                if(!in_array(42, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		if(isset($_POST['Metalm'])){
			if(empty($_POST['Metalm']['srate']) && empty($_POST['Metalm']['grate']) ){
				Yii::app()->user->setFlash('error','Silver Base Rate Or Gold Base Rate can not be blank');
				$this->redirect(array('admin'));
			}
			$cost_arr = array('srate'=>$_POST['Metalm']['srate'] , 'grate'=>$_POST['Metalm']['grate']);
			Yii::app()->cache->set('set-term', $cost_arr, 63072000); //2 years sec
			$this->setGoldSilverPrice($_POST['Metalm']);
			$this->redirect(array('admin'));
		}

		$model=new Metalm('search');
		  // clear any default values
		$model->unsetAttributes();
		
		if(isset($_GET['Metalm'])){
			$model->attributes=$_GET['Metalm'];
		}

		$value = Yii::app()->cache->get('set-term');
		$model->srate = $value['srate'];
		$model->grate = $value['grate'];

		$this->render('admin',array(
			'model'=>$model,
		));
                
	}

	public function setGoldSilverPrice($model){
		$dividedby = 31.08;
		if(!empty($model['grate'])){
			$grate = $model['grate'];
			$calgrate = $grate + ($grate * 3/100);
			$price = $calgrate/$dividedby;
			$goldmetal =Metalm::model()->findAll(array('condition'=>"name LIKE '%Gold'"));
			$localtax = $price * 1 /100;
			$tax = round($price + $localtax,2);
			$res = $this->saveGoldCost($goldmetal,$tax);

		}
		if(!empty($model['srate'])){
			$srate = $model['srate'];
			$calsrate = $srate + ($srate * 10 /100);
			$silvermetal = Metalm::model()->findAll(array('condition'=>"name LIKE '%Silver'"));
			$result = $this->saveSilverCost($silvermetal,$calsrate,$dividedby);
		}

 		return 'true';
	}

	public function saveGoldCost($goldmetal , $tax){
		$arr = array();
		foreach ($goldmetal as $key => $value) {
			$cost = $value->currentcost;
			$goldtype = explode(' ', $value->name);
			switch(trim($goldtype[0])){
				case '8K':  $purity = $tax*0.333;
							$wastage = $purity * 10/100;
							$cost = round($purity + $wastage,2);
							$arr[$value->idmetalm] = $cost;
					break;
				case '9K':  $purity = $tax*0.39;
							$wastage = $purity * 10/100;
							$cost = round($purity + $wastage,2);
							$arr[$value->idmetalm] = $cost;
					break;
				case '10K': $purity = $tax*0.42;
							$wastage = $purity * 10/100;
							$cost = round($purity + $wastage,2);
							$arr[$value->idmetalm] = $cost;
					break;
				case '14K': $purity = $tax*0.59;
							$wastage = $purity * 10/100;
							$cost = round($purity + $wastage,2);
							$arr[$value->idmetalm] = $cost;
					break;
				case '18K': $purity = $tax*0.75;
							$wastage = $purity * 10/100;
							$cost = round($purity + $wastage,2);
							$arr[$value->idmetalm] = $cost;
					break;
				default: break;
			}
			$updatecost = Metalm::model()->findByPk($value->idmetalm);
			$updatecost->currentcost = $cost;
			$updatecost->save();
		}
		$res = $this->updateMetalCost($arr);
		return 'true';
	}

	public function saveSilverCost($silvermetal, $calsrate,$dividedby){
		$arr = array();
		foreach ($silvermetal as $key => $value) {
			$silvertype = explode(' ', $value->name);
			if(trim($silvertype[0]) == '.925'){
				$sprice = $calsrate/$dividedby;
				$slocaltax = $sprice *1/100;
				$tax = $sprice+ $slocaltax;
				$purity = $tax*0.936;
				$wastage = $purity*10/100;
				$cost = round($purity+$wastage,2);
				$arr[$value->idmetalm] = $cost;
			}else{
				$cost = $value->currentcost; 
			}
			$updatecost = Metalm::model()->findByPk($value->idmetalm);
			$updatecost->currentcost = $cost;
			$updatecost->save();
		}
		$res = $this->updateMetalCost($arr);
		return 'true';
	}

	public function updateMetalCost($arr){
		foreach($arr as $key => $value){
			$metal = Metal::model()->findAll(array('condition'=>"idmetalm = :metalmid", 'params' => array(':metalmid' => $key)));
			foreach($metal as $key1 => $value1){
				$metalcost = Metal::model()->findByPk($value1->idmetal);
				$metalcost->prevcost = $metalcost->currentcost;
				$metalcost->currentcost = $value;
				if($metalcost->save()){
                    $metalcostlog=new Metalcostlog('insert');
                    $metalcostlog->cdate=$metalcost->cdate;
                    $metalcostlog->mdate=$metalcost->mdate;
                    $metalcostlog->updby=$metalcost->updby;
                    $metalcostlog->cost=$metalcost->currentcost;
                    $metalcostlog->idmetal=$metalcost->idmetal;
                    $metalcostlog->save();
                }
			}
		}
		return 'true';
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Metalm::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='metalm-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
