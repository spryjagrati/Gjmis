<?php

class StonealiasController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2_new';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'getstones'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    // public function actionCreate()
    // {
    // 	$model=new Stonealias;
    // 	// Uncomment the following line if AJAX validation is needed
    // 	// $this->performAjaxValidation($model);
    // 	if(isset($_POST['Stonealias']))
    // 	{
    // 		$model->attributes=$_POST['Stonealias'];
    // 		if($model->save())
    // 			$this->redirect(array('admin'));
    // 	}
    // 	$this->render('create',array(
    // 		'model'=>$model,
    // 	));
    // }

    public function actionCreate() {
        //echo "<pre>";print_r($_POST);die;
        Yii::import('ext.multimodelform.MultiModelForm');

        $model = new Stonem;
        $member = new Stonealias;
        $validatedMembers = array();  //ensure an empty array

        if (isset($_POST['Stonealias'])) {
            
            $masterValues = array('idstonem' => $_POST['Stonem']['idstonem']);
            if (MultiModelForm::save($member, $validatedMembers, $deleteMembers, $masterValues))
                $this->redirect(array('admin'));
        }

        

        $this->render('create', array(
            'model' => $model,
            //submit the member and validatedItems to the widget in the edit form
            'member' => $member,
            'validatedMembers' => $validatedMembers,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
       // echo "<pre>";print_r($_POST);die;

        $stonealias = Stonealias::model()->findByPk($id);
        Yii::import('ext.multimodelform.MultiModelForm');

        $model = Stonem::model()->findByPk($stonealias->idstonem);

        $member = new Stonealias;
        $validatedMembers = array();  //ensure an empty array

        if (isset($_POST['Stonealias'])) {
            $masterValues = array('idstonem' => $model->idstonem);
            
            if (MultiModelForm::save($member, $validatedMembers, $deleteMembers, $masterValues))
                $this->redirect(array('admin'));
        }


        $this->render('update', array(
            'model' => $model,
            //submit the member and validatedItems to the widget in the edit form
            'member' => $member,
            'validatedMembers' => $validatedMembers,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Stonealias');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
       
        $model = new Stonealias('search');
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Stonealias']))
            $model->attributes = $_GET['Stonealias'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Stonealias the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Stonealias::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Stonealias $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'stonealias-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetstones() {
        $sql = 'select idstone as id, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where tbl_stone.namevar like "%' . $_GET['q'] . '%" and tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        // echo $sql;die;
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        $reusults = array();
        foreach ($rows as $row) {
            // $data[$row['id']] = $row['name'];
            $reusults[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }
        echo CJSON::encode($reusults);
    }

}
