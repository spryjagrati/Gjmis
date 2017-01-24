<?php

class AliasesController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update','loadattributes','admin','delete','changeAFields'),
				'users'=>array('@'),
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
                 Yii::import('ext.multimodelform.MultiModelForm');
		$model=new Aliases;
                $member = new DependentAlias;
                $validatedMembers = array();  //ensure an empty array
		if(isset($_POST['Aliases']))
		{
                    $model->attributes=$_POST['Aliases'];
                       
                    if( 
                        $model->save()
                       )
                       {
                         //the value for the foreign key 'groupid'
                         $masterValues = array ('idaliases'=>$model->id);
                         if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues))
                            $this->redirect(array('admin'));
                        }
                        else{
                           var_dump(MultiModelForm::validate($member,$validatedMembers,$deleteItems));
                        }
                    
		}

		$this->render('create',array(
			'model'=>$model,
                        //submit the member and validatedItems to the widget in the edit form
                        'member'=>$member,
                        'validatedMembers' => $validatedMembers,
		));
	}
        
        public function getModels(){
            $records= Yii::app()->db->schema->getTables();
            $tables = array();
            foreach($records as $k=>$v){
                $pos = strpos($k, 'tbl_');
                if($pos!==false){
                    $value = ucfirst(str_replace("tbl_","",$k));
                    $tables[$value] = $value; 
                }
            }
            return $tables;
        }
        
        public function actionLoadattributes()
        {
            if(isset($_POST['model'])){
                
                $modelName =  $_POST['model'];
                $model = new $modelName;
                $data = $model->attributes;

                echo "<option value=''>Select Fields</option>";
                foreach($data as $k=>$v)
                echo CHtml::tag('option', array('value'=>$k),CHtml::encode($k),true);
                
            }
        }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		Yii::import('ext.multimodelform.MultiModelForm');
 
                $model=$this->loadModel($id); //the Group model

                $member = new DependentAlias;
                $validatedMembers = array(); //ensure an empty array

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aliases']))
		{
                    
                        $model->attributes=$_POST['Aliases'];
 
                        //the value for the foreign key 'groupid'
                        $masterValues = array ('idaliases'=>$model->id);

                        if( //Save the master model after saving valid members
                            MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues) &&
                            $model->save()
                           )
                                $this->redirect(array('admin'));
                        
		}

		$this->render('update',array(
			'model'=>$model,
                        //submit the member and validatedItems to the widget in the edit form
                        'member'=>$member,
                        'validatedMembers' => $validatedMembers,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Aliases');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{       
		$model=new Aliases('search');
                $deptalias = new DependentAlias('search');
                
		$model->unsetAttributes();  // clear any default values
                $deptalias->unsetAttributes(); //clear any default values
		
                if(isset($_GET['Aliases']))
			$model->attributes=$_GET['Aliases'];
                
                if(isset($_GET['DependentAlias']))
			$deptalias->attributes=$_GET['DependentAlias'];

		$this->render('admin',array(
			'model'=>$model, 'deptalias'=>$deptalias,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Aliases the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Aliases::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Aliases $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='aliases-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	// public function actionChangeAFields($atarget, $start,$end){
	// 	$aliases = Aliases::model()->findAll("aTarget=:atarget AND id>=:start AND id<=:end", array(":atarget"=>$atarget,":start"=>$start,":end"=>$end));
 //        foreach($aliases as $alias){
 //            $modelalias = Aliases::model()->findByPk($alias->id);
 //            $modelalias->aField = 'Stone Name';
 //            $modelalias->save();
 //        } 
 //        echo "<pre>"; print_r("Field updated Successfully From ".$start. ' To '.$end.' for '.$atarget);
	// }
}
