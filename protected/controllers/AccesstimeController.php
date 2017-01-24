<?php

class AccesstimeController extends Controller
{
	   /**
         * default action
         */
        public $defaultAction = 'useraccesstime';

        
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
        
        
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('useraccesstime','delete'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        public function actionUseraccesstime(){
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(57, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $userid=$_GET['id'];
           
            $criteria = new CDbCriteria();
            $criteria->condition = "iduser=$userid";
            $modelAccesstime=new Accesstime;
            //$modelAccesstime->model()->search($userid);
            
            
            if(isset($_GET['Accesstime']))
                $modelAccesstime->attributes=$_GET['Accesstime'];
            
            $this->render('useraccesstime',array('modelAccesstime'=>$modelAccesstime,'userid'=>$userid));
        }
        
        public function actionDelete(){
            $id=$_GET['id'];
            if(Yii::app()->request->isPostRequest)
            {
                
            $model = Accesstime::model()->findByPk($id);
            $model->delete();
            
            }
            else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

        }
        


}