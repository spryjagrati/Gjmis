<?php

class DeptstonelogController extends Controller
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
                                'actions'=>array('admin','delete'),
                                'users'=>Yii::app()->getModule("user")->getAdmins(),
                        ),
                        array('allow', // allow authenticated user to perform 'create' and 'update' actions
                                'actions'=>array('create','update','StocksCreate','StocksUpdate','AjaxUpdategrid'),
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
                $model=new Deptstonelog;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['Deptstonelog']))
                {
                        $model->attributes=$_POST['Deptstonelog'];
                        if($model->save())
                                $this->redirect(array('view','id'=>$model->iddeptstonelog));
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
                $model=$this->loadModel($id);

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['Deptstonelog']))
                {
                        $model->attributes=$_POST['Deptstonelog'];
                        
                        if($model->save())
                                $this->redirect(array('view','id'=>$model->iddeptstonelog));
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
                if(!in_array(21, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
                if(Yii::app()->request->isPostRequest)
                {
                        // we only allow deletion via POST request
                        $model = Stonestocks::model()->findByPk($id);
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
                $dataProvider=new CActiveDataProvider('Deptstonelog');
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
                if(!in_array(21, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
                $model=new Stonestocks('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Stonestocks']))
                        $model->attributes=$_GET['Stonestocks'];

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
                $model=Deptstonelog::model()->findByPk((int)$id);
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
                if(isset($_POST['ajax']) && $_POST['ajax']==='deptstonelog-form')
                {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }
        
         /*Manish Changes --start-- oct 15 for added positive and negative values in database table deptstonelog */
         public function refrcvd($data){
            $model=new Stonestocks;
            $sum = (ComSpry::getStonecount($data['refrcvd'], $data['idstone']));
            //echo('<pre>');print_r($sum);die();
            if($data['refrcvd'] == 4){
                if($sum <= 0){
                    Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                    $this->redirect(array('stockscreate'));
                }else{
                    $sum = $sum - $data['stonewt'];
                    if($sum < 0){
                        Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                        $this->redirect(array('stockscreate'));
                    }else{
                        $model=new Stonestocks;
                        $model->iddept = $data['refrcvd']; 
                        $model->refsent = $data['iddept']; 
                        $model->idstone = $data['idstone']; 
                        $model->qty = '-'.$data['qty']; 
                        $model->stonewt = '-'.$data['stonewt'];
                        if($model->save()) return $model->idstonestocks;
                    }
                }
            }else{
                $model=new Stonestocks;
               
                $model->iddept = $data['refrcvd']; 
                $model->refsent = $data['iddept']; 
                $model->idstone = $data['idstone']; 
                $model->qty = '-'.$data['qty']; 
                $model->stonewt = '-'.$data['stonewt'];
               if($model->save()) return $model->idstonestocks;
            }
            
            return false;

        }
        public function refsent($data){
               
            $model=new Stonestocks;
            $sum = (ComSpry::getStonecount($data['iddept'], $data['idstone']));
            if($data['refsent'] == 4){
                if($sum <= 0){
                    Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                    $this->redirect(array('stockscreate'));
                }else{
                    $sum = $sum - $data['stonewt'];
                    if($sum < 0){
                        Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                        $this->redirect(array('stockscreate'));
                    }else{
                        
                        $model->iddept = $data['refsent']; 
                        $model->refrcvd = $data['iddept']; 
                        $model->idstone = $data['idstone']; 
                        $model->qty = $data['qty']; 
                        $model->stonewt = $data['stonewt'];
                        if($model->save()) return $model->idstonestocks;
                    }
                }
            }else{
                
                $model->iddept = $data['refsent']; 
                $model->refrcvd = $data['iddept']; 
                $model->idstone = $data['idstone']; 
                $model->qty = $data['qty']; 
                $model->stonewt = $data['stonewt'];
                if($model->save()) return $model->idstonestocks;
            }
           return false;
        }
       /* Manish Changes --End--*/
        
       public function actionStocksCreate()
        {
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(21, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
                $model=new Stonestocks;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['Stonestocks']))
                {
                    /*Manish Changes --start-- oct 15 for added positive and negative values in database table deptstonelog */
                    if(isset($_POST['Stonestocks']['refsent']) && !empty($_POST['Stonestocks']['refsent']))
                    {
                        $idss=$this->refsent($_POST['Stonestocks']);
                        if($idss){
                            $model->attributes=$_POST['Stonestocks'];
                            $model->stonewt = -1 * $_POST['Stonestocks']['stonewt'];
                            $model->qty = -1 * $_POST['Stonestocks']['qty'];
                            if($model->save()){
                                $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
                            }else{
                                Yii::app()->user->setFlash('error', "Error on update please try again.");
                                $this->removeSS($idss);
                                $this->redirect(array('stockscreate'));
                            }
                        }else{
                            Yii::app()->user->setFlash('error', "Error on update please try again.");
                            $this->redirect(array('stockscreate'));
                        }
                        
                    }
                    elseif(isset($_POST['Stonestocks']['refrcvd']) && !empty($_POST['Stonestocks']['refrcvd'])) {
                        $idss=$this->refrcvd($_POST['Stonestocks']);
                        if($idss){
                            $model->attributes=$_POST['Stonestocks'];
                            $model->stonewt = $_POST['Stonestocks']['stonewt'];
                            if($model->save()){
                                    $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
                            }else{
                                Yii::app()->user->setFlash('error', "Error on update please try again.");
                                $this->removeSS($idss);
                                $this->redirect(array('stockscreate'));
                            }
                        }else{
                            Yii::app()->user->setFlash('error', "Error on update please try again.");
                            $this->redirect(array('stockscreate'));
                        }
                        
                    }
                   elseif((isset($_POST['Stonestocks']['refsent']) && !empty($_POST['Stonestocks']['refsent'])) && (isset($_POST['Stonestocks']['refrcvd']) && !empty($_POST['Stonestocks']['refrcvd'])))
                  {
                     
                      Yii::app()->user->setFlash('error','Incorrect values.');
                   // $this->redirect(array('StocksUpdate','id'=>$model->iddeptstonelog));
                       /* Manish Changes --End--*/
                  }else{
                          
                        $model->attributes=$_POST['Stonestocks'];
                        $model->stonewt = $_POST['Stonestocks']['stonewt'];
                        
                        if($model->save()){
                                $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
                        }else{
                            Yii::app()->user->setFlash('error', "Error on update please try again.");
                            $this->redirect(array('stockscreate'));
                        }
                  }
                
                }
       
                $this->render('stocks',array(
                        'model'=>$model,
                ));
                
        }
        
        
        
         /*Manish Changes --start-- oct 15 for added positive and negative values in database table deptstonelog */
        public function refupdate($model, $model2, $data)
        {
                
            $sum = ComSpry::getStonecount($model2->iddept, $model2->idstone);
            
            if($model2->iddept == 4){
                if($sum <= 0){
                    Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                    $this->redirect(array('StocksUpdate', 'id'=>$model->idstonestocks));
                }else{
                        $sum = $sum + $model2->stonewt;
                        $sum = $sum - $data['stonewt'];

                        if($sum < 0){
                            Yii::app()->user->setFlash('error', "Cannot update stone data as department stock value is going negative.");
                            $this->redirect(array('StocksUpdate', 'id'=>$model->idstonestocks));
                        }else{
                            $model2->qty = -1 * $data['qty'];
                            $model2->stonewt =  -1 * $data['stonewt'];
                            $model2->remark = $data['remark'];
                            $model2->save();
                        }
                }
            }else{
                    $model2->qty = -1 * $data['qty'];
                    $model2->stonewt = -1 * $data['stonewt'];
                    $model2->remark = $data['remark'];
                    $model2->save();
            }
        }
        
        
        
        public function sentrcvd($id,$data)
        {
            
            $model=Stonestocks::model()->findByPk($id-1);
         
            $model->attributes = $data;
            if(isset($model->attributes))
            {
                $model->qty = 0;
                $model->stonewt = 0;
            }
            if($model->save)
            $model->save();
        }
        /* Manish Changes --End--*/
        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionStocksUpdate($id)
        {
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(21, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
                $model=Stonestocks::model()->findByPk($id);
                

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['Stonestocks']))
                { 
                    $model->attributes = $_POST['Stonestocks'];
                    $model->save();
                    if($model->save()){
                                $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
                           }
                    
                    
                    
//                    /*Manish Changes --start-- oct 15 for added positive and negative values in database table deptstonelog */
//                    if(isset($model->refrcvd)  && !isset($model->refsent))
//                    {       
//                            $model2 = Stonestocks::model()->findByAttributes(array('iddept'=>$model->refrcvd, 'refsent'=>$model->iddept, 'idstone'=>$model->idstone, 'cdate'=>$model->cdate ));
//                            $this->refupdate($model, $model2,$_POST['Stonestocks']);
//                            $model->attributes=$_POST['Stonestocks'];
//                            $model->stonewt = $_POST['Stonestocks']['stonewt'];
//                            $model->remark = $_POST['Stonestocks']['remark'];
//                            if($model->save()){
//                                $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
//                            }
//                    }
//                    elseif(isset($model->refsent) && !isset($model->refrcvd))
//                    {
//                            $model2 = Stonestocks::model()->findByAttributes(array('iddept'=>$model->refsent, 'refrcvd'=>$model->iddept, 'idstone'=>$model->idstone, 'cdate'=>$model->cdate ));
//                            $this->refupdate($model, $model2, $_POST['Stonestocks']);
//                            $model->attributes=$_POST['Stonestocks'];
//                            $model->stonewt = $_POST['Stonestocks']['stonewt'];
//                            $model->remark = $_POST['Stonestocks']['remark'];
//                            if($model->save()){
//                                $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));
//                            }
//                    } 
//                        
//                    /* Manish Changes --End--*/
//                    else
//                    {
//                            $model->attributes=$_POST['Stonestocks'];
//                            $model->stonewt = $_POST['Stonestocks']['stonewt'];
//                            $model->remark = $_POST['Stonestocks']['remark'];
//                            $this->sentrcvd($id,$_POST['Stonestocks']);
//                            if($model->save()){
//                                    $this->redirect(array('StocksUpdate','id'=>$model->idstonestocks));}
//                    }
                                
                }

                $this->render('stocksupdate',array(
                        'model'=>$model,
                ));
                
        }
        
        /**
         * This function is to update through ajax request
         */
        public function actionAjaxUpdategrid(){
             $checked = explode(',',$_POST['theIds']);
             $unchecked = explode(',',$_POST['uncheckedIds']); 
             foreach($checked as $key=>$value){
             $model = Stonestocks::model()->findByPk($value);
             $model->acknow = 1;
             $model->save();
             }
             foreach($unchecked as $key=>$value){
             $model = Stonestocks::model()->findByPk($value);
             $model->acknow = 0;
             $model->save();
             }
          
        }
        
        public function removeSS($idss){
            $model = Stonestocks::model()->findByPk($idss);
            $model->delete();
        }
        
        
}
