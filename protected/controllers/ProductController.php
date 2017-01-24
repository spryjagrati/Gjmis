<?php

class ProductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2_new';
   // public $loader = Yii::import();
     
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('maintain', 'updateContent',
                    'createMetal', 'updateSku', 'createStone',
                    'updateMetal', 'deleteMetal', 'deleteStone',
                    'updateStone', 'createFinding', 'updateFinding',
                    'deleteFinding', 'createAddon', 'updateAddon',
                    'deleteAddon', 'createSelmap', 'updateSelmap',
                    'deleteSelmap', 'createImage', 'updateImage',
                    'deleteImage', 'fetchCost', 'fetchCostDisplay',
                    'admin','adminnew', 'create', 'duplicate', 'export', 'export_quotesheet', 'gridskuimages', 'review', 'master','getstone', 'getshape', 'getsize', 'getquality','getskucode', 'getstonedetails','createReview' ,'updateReview','deleteReview' ,'moveReviews','testing',
                    'getTotalcost'),
                'users' => Yii::app()->getModule("user")->getAdmins(),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Manages all Skus.
     */
    public function actionAdmin() {
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
            if (!in_array(1, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        if (isset($_POST['selected_sku'])) {
            $model = new Sku();
            $res1 = Sku::model()->hasCookie('save-selection-admin');
            if (!empty($res1)) {
                $res_cookie = Sku::model()->getCookie('save-selection-admin');
                $res_cookie = stripslashes($res_cookie);
                $res_cookie = json_decode($res_cookie);
                $json = array_unique(array_merge($res_cookie, $_POST['selected_sku']));
            } else {
                $json = $_POST['selected_sku'];
            }
            $json = json_encode($json);
            $model->setCookie('save-selection-admin', $json);
            //print_r($_POST['selected_sku']);
        }
        $image = new Skuimages;
        $model = new Sku('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $model->attributes = $_GET['Sku'];

        $imageUrl = $image->imageThumbUrl;
        $this->render('admin', array(
            'model' => $model,
            'skuimages' => $imageUrl
        ));
    }

    
    /**
     * Manages all Skus.
     */
    public function actionAdminnew() {
        $this->layout = '//layouts/column2_new';
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
            if (!in_array(1, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        if (isset($_POST['selected_sku'])) {
            $model = new Sku();

            $res1 = Sku::model()->hasCookie('save-selection-admin');

            if (!empty($res1)) {

                $res_cookie = Sku::model()->getCookie('save-selection-admin');
                $res_cookie = stripslashes($res_cookie);
                $res_cookie = json_decode($res_cookie);
                $json = array_unique(array_merge($res_cookie, $_POST['selected_sku']));
            } else {

                $json = $_POST['selected_sku'];
            }
            $json = json_encode($json);

            $model->setCookie('save-selection-admin', $json);
            //print_r($_POST['selected_sku']);
        }
        $image = new Skuimages;
        $model = new Sku('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $model->attributes = $_GET['Sku'];
        $imageUrl = $image->imageThumbUrl;
        $this->render('admin', array(
            'model' => $model,
            'skuimages' => $imageUrl
        ));
    }

    /**
     * 
     * Review sku
     * set sku.review  = 1 
     * by Sprymohit 6-5-2014
     * 
     */
    public function actionReview() {
        //echo "<pre>";print_r($_POST);die;
        $idsku = $_POST['idsku'];
        $model = Sku::model()->findByPk($idsku);
        if ($model->review == 0)
            $model->review = 1;
        else
            $model->review = 0;
        $model->save();
        echo "success";
        Yii::app()->end();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
            if (!in_array(1, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        $model = new Sku;
        $modelmetal = new Skumetals;
        $modelcontent = new Skucontent;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sku'])) {
            $model->attributes = $_POST['Sku'];
            if ($model->save()) {
                if (isset($_POST['Skucontent']) && isset($_POST['Skumetals'])) {
                    $modelcontent->idsku = $model->idsku;
                    $modelcontent->name = $model->skucode;
                    $modelcontent->descr = $model->skucode;
                    $modelcontent->type = $_POST['Skucontent']['type'];
                    $modelmetal->idsku = $model->idsku;
                    $modelmetal->idmetal = $_POST['Skumetals']['idmetal'];
                    if ($modelcontent->save() && $modelmetal->save()){
                        $res = $this->createskuAddon( $model->idsku,$modelmetal->idskumetals);
                        $model->tot_cost =ComSpry::calcSkuCost($model->idsku);
                        $model->save();
                        $this->redirect(array('product/maintain', 'id' => $model->idsku));
                    }
                    else
                        print_r(array($modelmetal, $modelcontent));
                }
            }
        }

        $this->render('create', array(
            'model' => $model, 'modelmetal' => $modelmetal, 'modelcontent' => $modelcontent,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionMaintain($id) {
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
            if (!in_array(1, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        $modelsku = Sku::model()->findByPk((int) $id);

        $modelcontent = Skucontent::model()->find('idsku=:idsku', array(':idsku' => $id));
        $modelmetal = new Skumetals;
        $modelmetal->idsku = $id;
        $modelstone = new Skustones;
        $modelstone->idsku = $id;
        $modelfinding = new Skufindings;
        $modelfinding->idsku = $id;
        $modeladdon = new Skuaddon;
        $modeladdon->idsku = $id;
        $modelselmap = new Skuselmap;
        $modelselmap->idsku = $id;
        $modelimage = new Skuimages;
        $modelimage->idsku = $id;
        $modelreview = new Skureviews;
        $modelreview->idsku = $id;
        if (!isset($modelcontent)) {
            $modelcontent = new Skucontent;
            $modelcontent->idsku = $id;
        }
        $image = Skuimages::model()->find('idsku=:idsku and type="MISG" and idclient is null', array(':idsku' => $id));
        if ($image)
            $imageUrl = $image->imageThumbUrl;
        else
            $imageUrl = '';
        $this->render('maintain', array(
            'modelsku' => $modelsku, 'modelcontent' => $modelcontent,
            'modelmetal' => $modelmetal, 'modelstone' => $modelstone,
            'modelfinding' => $modelfinding, 'modeladdon' => $modeladdon,
            'modelselmap' => $modelselmap, 'modelimage' => $modelimage,
            'image' => $imageUrl, 'modelreview' => $modelreview,
        ));
    }

    /**
     * Update SKU
     *
     */
    public function actionUpdateSku($id) {
        $modelsku = Sku::model()->findByPk((int) $id);
        if (isset($_POST['Sku'])) {
            $modelsku->attributes = $_POST['Sku'];
            $stodata = $modelsku->topStoneWeightNum();
            $stonewt = (0 + ($stodata['wt'])) / 5;
            $modelsku->totstowei = 0 + ($stodata['wt']);
            $modelsku->numstones = 0 + ($stodata['ns']);
            $modelsku->totmetalwei = $modelsku->grosswt - $stonewt;
            if ($modelsku->save()) {
                $metal = Skumetals::model()->find('idsku=:idsku', array(':idsku' => $id));
                $metal->weight = $modelsku->totmetalwei;
                $metal->save();
                $modelsku->tot_cost =ComSpry::calcSkuCost($modelsku->idsku);
                $modelsku->save();
                Yii::app()->user->setFlash('sku', ' Sku id ' . $modelsku->idsku . ' updated successfully');
                return $this->renderPartial('_form_sku', array('model' => $modelsku));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_sku', array('model' => $modelsku));
    }

    public function actionCreateMetal($id) {
        $modelmetal = new Skumetals;
        $modelmetal->idsku = $id;
        if (isset($_POST['Skumetals'])) {
            $modelmetal->attributes = $_POST['Skumetals'];
            if ($modelmetal->save()) {
                $res = $this->createskuAddon($id , $modelmetal->idskumetals);
                $summetwt = $this->totMetalWtOnly($modelmetal->idsku);
                //$findwt=$this->totMetalWeightFind($modelmetal->idsku);
                $modelsku = Sku::model()->findByPk($modelmetal->idsku);
                $modelsku->totmetalwei = 0 + $summetwt;
                $modelsku->tot_cost =ComSpry::calcSkuCost($modelmetal->idsku);
                $modelsku->save();

                Yii::app()->user->setFlash('skumetal', 'Skumetal ' . $modelmetal->idskumetals . ' created successfully');
                $modelmetal->unsetAttributes();
                $modelmetal->idsku = $id;
                return $this->renderPartial('_form_metal', array('model' => $modelmetal));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_metal', array('model' => $modelmetal));
        Yii::app()->end();
    }

    public function createskuAddon($id, $idskumetal){
        $skumetal = Skumetals::model()->findByPk($idskumetal);
        $metal = Metal::model()->findByPk($skumetal->idmetal);
        $metalname = $metal->namevar;
        $content = Skucontent::model()->find('idsku=:idsku', array(':idsku' => $id));
        $addon = $this->getaddonArray($metalname,$content);
          
        if(isset($addon)){
            foreach($addon['costadd'] as $key => $value){
                $costadd = Costadd::model()->find('name = :name',array(':name' => $value ));
                
                if(isset($costadd)){
                    $skuaddon = new Skuaddon();
                    $skuaddon->idcostaddon = $costadd->idcostadd;
                    $skuaddon->qty = 1;
                    $skuaddon->idsku = $id;
                    $skuaddon->save();
                }
            }
            
        }
       return 'true';
    }

    public function deleteskuAddon($id, $idskumetal){
        $metal = Metal::model()->findByPk($idskumetal);
        $metalname = $metal->namevar;
        $content = Skucontent::model()->find('idsku=:idsku', array(':idsku' => $id));
        $addon = $this->getaddonArray($metalname,$content);

        if(isset($addon)){
            foreach($addon['costadd'] as $key => $value){
                $costadd = Costadd::model()->find('name = :name',array(':name' => $value ));

                if(isset($costadd)){
                   $skuaddon =  Skuaddon::model()->findByAttributes(array('idsku' => $id, 'idcostaddon' => $costadd->idcostadd));
                   if(!empty($skuaddon)){
                        Skuaddon::model()->deleteByPk($skuaddon->idskuaddon);
                   }
                }
            } 
           
        }
        return 'true';
    }
    
    public function getaddonArray($metalname , $content){
        $path =Yii::app()->basePath.'/data/loader.php';
        $loader = require($path);
        foreach($loader as $key => $value){
            if($metalname == $key){
                foreach($value as $key1 => $value1 ){
                    if($key1 == $content->type){
                        $addon = $value1;
                    }
                } 
            }
        }
        return $addon;
    }

    public function actionUpdateMetal($id) {
        $modelmetal = Skumetals::model()->findByPk($id);
        $previousmetalid = $modelmetal->idmetal;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Skumetals'])) {
            $modelmetal->attributes = $_POST['Skumetals'];
            if ($modelmetal->save()) {
                $pre = $this->deleteskuAddon($modelmetal->idsku , $previousmetalid);
                $res = $this->createskuAddon($modelmetal->idsku , $modelmetal->idskumetals);
                $summetwt = $this->totMetalWtOnly($modelmetal->idsku);
                $findwt = $this->totMetalWeightFind($modelmetal->idsku);
                $modelsku = Sku::model()->findByPk($modelmetal->idsku);
                $modelsku->totmetalwei = 0 + $summetwt;
                $modelsku->tot_cost =ComSpry::calcSkuCost($modelmetal->idsku);
                $modelsku->save();

                //Yii::app()->user->setFlash('updateMetal','Skumetal '.$modelmetal->idskumetals.' updated successfully');
                //$this->renderPartial('updateMetal', array('model'=>$modelmetal),false,true);
                //$this->redirect(array('maintain','id'=>$modelmetal->idsku));
                echo 'Skumetal ' . $modelmetal->idskumetals . ' updated successfully';
            } else {
                echo 'Skumetal ' . $modelmetal->idskumetals . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateMetal', array('model' => $modelmetal), false, true);
        }
    }

    public function actionUpdateContent($id) {
        $modelcontent = Skucontent::model()->find('idsku=:idsku', array(':idsku' => $id));
        if (!isset($modelcontent)) {
            $modelcontent = new Skucontent;
            $modelcontent->idsku = $id;
        }
        if (isset($_POST['Skucontent'])) {
            $modelcontent->attributes = $_POST['Skucontent'];
            if ($modelcontent->save()) {
                Yii::app()->user->setFlash('skucontent', ' Skucontent updated successfully');
                return $this->renderPartial('_form_content', array('model' => $modelcontent));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_content', array('model' => $modelcontent));
        Yii::app()->end();
    }

    public function actionCreateStone($id) {
        $modelstone = new Skustones;
        $modelstone->idsku = $id;
        if(!empty($_POST['Shape']) && !empty($_POST['Size'])){
          $sql = "select idstone as id from tbl_stone where tbl_stone.namevar='" . $_POST['Skustones']['idstone'] . "' and tbl_stone.quality ='".$_POST['Quality']."' and tbl_stone.idstonesize =" . $_POST['Size'] . " and tbl_stone.idshape =" . $_POST['Shape'];
          $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
          $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
          $modelstone->idstone = $rows[0]['id'];
        }

        if (isset($_POST['Skustones'])) {
          $modelstone->idsetting = $_POST['Skustones']['idsetting'];
          $modelstone->height = $_POST['Skustones']['height'];
          $modelstone->mmsize = $_POST['Skustones']['mmsize'];
          $modelstone->diasize = $_POST['Skustones']['diasize'];
          $modelstone->sievesize = $_POST['Skustones']['sievesize'];
          $modelstone->pieces = $_POST['Skustones']['pieces'];
          $modelstone->reviews = $_POST['Skustones']['reviews'];
            //$modelstone->attributes = $_POST['Skustones'];
            if ($modelstone->save()) {
                $modelsku = Sku::model()->findByPk($modelstone->idsku);
                $stodata = $modelsku->topStoneWeightNum();
                $modelsku->totstowei = 0 + ($stodata['wt']);
                $modelsku->numstones = 0 + ($stodata['ns']);
                $stonewt = (0 + ($stodata['wt'])) / 5;
                $modelsku->totmetalwei = $modelsku->grosswt - $stonewt;
                $modelsku->save();
                $metal = Skumetals::model()->find('idsku=:idsku', array(':idsku' => $id));
                $metal->weight = $modelsku->totmetalwei;
                $metal->save();
                $modelsku->tot_cost=ComSpry::calcSkuCost($modelsku->idsku);
                $modelsku->save();

                Yii::app()->user->setFlash('skustone', 'Skustone ' . $modelstone->idskustones . ' created successfully');
                $modelstone->unsetAttributes();
                $modelstone->idsku = $id;
                return $this->renderPartial('_form_stone', array('model' => $modelstone));
                Yii::app()->end();
            }  
        }

        return $this->renderPartial('_form_stone', array('model' => $modelstone));
        Yii::app()->end();
    }

    public function actionDeleteMetal($id) {
        if (Yii::app()->request->isPostRequest) {
            $skumetal = Skumetals::model()->findByPk($id);
            $idmetal = $skumetal->idmetal; $idsku = $skumetal->idsku;
            // we only allow deletion via POST request
            $summetwt = $this->totMetalWtOnly(Skumetals::model()->findByPk($id)->idsku);
            //$findwt=$this->totMetalWeightFind($modelmetal->idsku);
            $modelsku = Sku::model()->findByPk(Skumetals::model()->findByPk($id)->idsku);
            $modelsku->totmetalwei = 0 + $summetwt;
            $modelsku->save();
            Skumetals::model()->findByPk($id)->delete();
            $res = $this->deleteskuAddon($idsku , $idmetal);
            $modelsku->tot_cost =ComSpry::calcSkuCost($idsku);
            $modelsku->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skumetals::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }



    public function actionDeleteStone($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $modelstone = Skustones::model()->findByPk($id);
            $skuid = $modelstone->idsku;
            Skustones::model()->findByPk($id)->delete();
            $modelsku = Sku::model()->findByPk($skuid);
            $stodata = $modelsku->topStoneWeightNum();
            $modelsku->totstowei = 0 + ($stodata['wt']);
            $modelsku->numstones = 0 + ($stodata['ns']);
            $stonewt = (0 + ($stodata['wt'])) / 5;
            $modelsku->totmetalwei = $modelsku->grosswt - $stonewt;
            $modelsku->save();
            $metal = Skumetals::model()->find('idsku=:idsku', array(':idsku' => $modelstone->idsku));
            $metal->weight = $modelsku->totmetalwei;
            $metal->save();
            $modelsku->tot_cost=ComSpry::calcSkuCost($modelsku->idsku);
            $modelsku->save();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skustones::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateStone($id) {
        $modelstone = Skustones::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidationStone($modelstone);

        if (isset($_POST['Skustones'])) {
            $modelstone->attributes = $_POST['Skustones'];
            if ($modelstone->save()) {
                $modelsku = Sku::model()->findByPk($modelstone->idsku);
                $stodata = $modelsku->topStoneWeightNum();
                $modelsku->totstowei = 0 + ($stodata['wt']);
                $modelsku->numstones = 0 + ($stodata['ns']);
                $stonewt = (0 + ($stodata['wt'])) / 5;
                $modelsku->totmetalwei = $modelsku->grosswt - $stonewt;
                if ($modelsku->save()) {
                    $metal = Skumetals::model()->find('idsku=:idsku', array(':idsku' => $modelstone->idsku));
                    $metal->weight = $modelsku->totmetalwei;
                    $metal->save();
                    $modelsku->tot_cost=ComSpry::calcSkuCost($modelsku->idsku);
                    $modelsku->save();
                    echo 'Skustone ' . $modelstone->idskustones . ' updated successfully';
                } else {
                    print_r($modelsku->getErrors());
                    echo 'error occurred in sku updation';
                }
            } else {
                echo 'Skustone ' . $modelstone->idskustones . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateStone', array('model' => $modelstone), false, true);
        }
    }

    public function actionCreateFinding($id) { 
        $modelfinding = new Skufindings;
        $modelfinding->idsku = $id;
        if (isset($_POST['Skufindings'])) {
            $modelfinding->attributes = $_POST['Skufindings'];
            if ($modelfinding->save()) {

                $modelsku = Sku::model()->findByPk($id);
                $modelsku->tot_cost =ComSpry::calcSkuCost($id);
                $modelsku->save();

                Yii::app()->user->setFlash('skufinding', 'Skufinding ' . $modelfinding->idskufindings . ' created successfully');
                $modelfinding->unsetAttributes();
                $modelfinding->idsku = $id;
                return $this->renderPartial('_form_finding', array('model' => $modelfinding));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_finding', array('model' => $modelfinding));
        Yii::app()->end();
    }

    public function actionDeleteFinding($id) {
        if (Yii::app()->request->isPostRequest) {

            $modelfinding =Skufindings::model()->findByPk($id);

            $modelsku = Sku::model()->findByPk($modelfinding->idsku);
            
            // we only allow deletion via POST request
            Skufindings::model()->findByPk($id)->delete();

            $modelsku->tot_cost =ComSpry::calcSkuCost($modelsku->idsku);
            $modelsku->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skufindings::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateFinding($id) {
        $modelfinding = Skufindings::model()->findByPk($id);

        if (isset($_POST['Skufindings'])) {
            $modelfinding->attributes = $_POST['Skufindings'];
            if ($modelfinding->save()) {

                $modelsku = Sku::model()->findByPk($modelfinding->idsku);
                $modelsku->tot_cost =ComSpry::calcSkuCost($modelsku->idsku);
                $modelsku->save();

                echo 'Skufinding ' . $modelfinding->idskufindings . ' updated successfully';
            } else {
                echo 'Skufinding ' . $modelfinding->idskufindings . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateFinding', array('model' => $modelfinding), false, true);
        }
    }

    public function actionCreateAddon($id) {
        $modeladdon = new Skuaddon;
        $modeladdon->idsku = $id;
        if (isset($_POST['Skuaddon'])) {
            $modeladdon->attributes = $_POST['Skuaddon'];
            if ($modeladdon->save()) {
                $modelsku = Sku::model()->findByPk($id);
                $modelsku->tot_cost =ComSpry::calcSkuCost($id);
                $modelsku->save();
                Yii::app()->user->setFlash('skuaddon', 'Skuaddon ' . $modeladdon->idskuaddon . ' created successfully');
                $modeladdon->unsetAttributes();
                $modeladdon->idsku = $id;
                return $this->renderPartial('_form_addon', array('model' => $modeladdon));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_addon', array('model' => $modeladdon));
        Yii::app()->end();
    }

    public function actionDeleteAddon($id) {
        if (Yii::app()->request->isPostRequest) {

            $modeladdon = Skuaddon::model()->findByPk($id);
            $modelsku = Sku::model()->findByPk($modeladdon->idsku);
            // we only allow deletion via POST request
            Skuaddon::model()->findByPk($id)->delete();
            $modelsku->tot_cost =ComSpry::calcSkuCost($modelsku->idsku);
            $modelsku->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skuaddon::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateAddon($id) {
        $modeladdon = Skuaddon::model()->findByPk($id);
        $idsku = $modeladdon->idsku;
        if (isset($_POST['Skuaddon'])) {
            $modeladdon->attributes = $_POST['Skuaddon'];
            if ($modeladdon->save()) {

                $modelsku = Sku::model()->findByPk($idsku);
                $modelsku->tot_cost =ComSpry::calcSkuCost($idsku);
                $modelsku->save();

                echo 'Skuaddon ' . $modeladdon->idskuaddon . ' updated successfully';
            } else {
                echo 'Skuaddon ' . $modeladdon->idskuaddon . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateAddon', array('model' => $modeladdon), false, true);
        }
    }

    public function actionCreateSelmap($id) {
        $modelselmap = new Skuselmap;
        $modelselmap->idsku = $id;
        if (isset($_POST['Skuselmap'])) {
            $modelselmap->attributes = $_POST['Skuselmap'];
            if ($modelselmap->save()) {
                Yii::app()->user->setFlash('skuselmap', 'Sku Seller Data ' . $modelselmap->idskuselmap . ' created successfully');
                $modelselmap->unsetAttributes();
                $modelselmap->idsku = $id;
                return $this->renderPartial('_form_selmap', array('model' => $modelselmap));
                Yii::app()->end();
            }
        }

        return $this->renderPartial('_form_selmap', array('model' => $modelselmap));
        Yii::app()->end();
    }

    public function actionDeleteSelmap($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Skuselmap::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skuselmap::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateSelmap($id) {
        $modelselmap = Skuselmap::model()->findByPk($id);

        if (isset($_POST['Skuselmap'])) {
            $modelselmap->attributes = $_POST['Skuselmap'];
            if ($modelselmap->save()) {
                //Yii::app()->user->setFlash('updateSelmap','Skuselmap '.$modelselmap->idskuselmap.' updated successfully');
                echo 'Sku Seller Data ' . $modelselmap->idskuselmap . ' updated successfully';
            } else {
                echo 'Sku Seller Data ' . $modelselmap->idskuselmap . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateSelmap', array('model' => $modelselmap), false, true);
        }
    }


    public function actionCreateImage($id) {
        $modelimage = new Skuimages('insert');
        $modelimage->idsku = $id;
        if (isset($_POST['Skuimages'])) {
            $modelimage->attributes = $_POST['Skuimages'];
            $modelimage->image = CUploadedFile::getInstance($modelimage, 'image');
            if (isset($modelimage->image) && $modelimage->image !== '') {
                if (!($modelimage->idclient))
                    $modelimage->idclient = null;
                if($modelimage->type == 'MISG'){
                    $filename = $modelimage->idsku . '--' . $modelimage->type . '.' . $modelimage->image->extensionName;
                }else{
                    $filename = $modelimage->image->name;
                }
                if ($modelimage->image->saveAs(Yii::app()->basePath . '/..' . '/images/' . Client::getClientImgFolder($modelimage->idclient) . Client::getClientStdImgSize($modelimage->idclient) . '/' . $filename)) {
                    Yii::app()->thumb->setThumbsDirectory('/images/' . Client::getClientImgFolder($modelimage->idclient) . 'thumb');

                    Yii::app()->thumb
                            ->load(Yii::getPathOfAlias('webroot') . "/images/" . Client::getClientImgFolder($modelimage->idclient) . Client::getClientStdImgSize($modelimage->idclient) . "/" . $filename)
                            ->resize('150', '150')
                            ->save($filename, strtoupper($modelimage->image->extensionName));

                    $modelimage->image = $filename;
                    
                    if ($modelimage->save()) {
                        Yii::app()->user->setFlash('skuimage', 'Sku Image ' . $modelimage->idskuimages . ' created successfully');
                        $this->redirect(array('maintain', 'id' => $id));
                    }
                } else {
                    Yii::app()->user->setFlash('skuimage', 'Sku Image could not be uploaded');
                    $this->redirect(array('maintain', 'id' => $id));
                }
            } else {
                Yii::app()->user->setFlash('skuimage', 'Sku Image not specified');
                $this->redirect(array('maintain', 'id' => $id));
            }
        }

        return $this->renderPartial('_form_image', array('model' => $modelimage));
        Yii::app()->end();
    }

    public function actionDeleteImage($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Skuimages::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skuimages::model()->findByPk($id)->idsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateImage($id) {
        $modelimage = Skuimages::model()->findByPk($id);
        $modelimage->scenario = 'insert';

        if (isset($_POST['Skuimages'])) {
            $modelimage->attributes = $_POST['Skuimages'];
            $modelimage->image = CUploadedFile::getInstance($modelimage, 'image');
            if (isset($modelimage->image) && $modelimage->image !== '') {
                if (!($modelimage->idclient))
                    $modelimage->idclient = null;
                
                if($modelimage->type == 'MISG'){
                    $filename = $modelimage->idsku . '--' . $modelimage->type . '.' . $modelimage->image->extensionName;
                }else{
                    $filename = $modelimage->image->name;
                }
                
                if ($modelimage->image->saveAs(Yii::app()->basePath . '/..' . '/images/' . Client::getClientImgFolder($modelimage->idclient) . Client::getClientStdImgSize($modelimage->idclient) . '/' . $filename)) {
                    Yii::app()->thumb->setThumbsDirectory('/images/' . Client::getClientImgFolder($modelimage->idclient) . 'thumb');

                    Yii::app()->thumb
                            ->load(Yii::getPathOfAlias('webroot') . "/images/" . Client::getClientImgFolder($modelimage->idclient) . Client::getClientStdImgSize($modelimage->idclient) . "/" . $filename)
                            ->resize('150', '150')
                            ->save($filename, strtoupper($modelimage->image->extensionName));

                    $modelimage->image = $filename;
                    if ($modelimage->save()) {
                        Yii::app()->user->setFlash('skuimage', 'Sku Image ' . $modelimage->idskuimages . ' updated successfully');
                        $this->redirect(array('maintain', 'id' => $modelimage->idsku));
                    } else {
                        Yii::app()->user->setFlash('skuimage', 'Sku Image ' . $modelimage->idskuimages . ' could not be updated at this time, please remodify');
                        $this->redirect(array('maintain', 'id' => $modelimage->idsku));
                    }
                } else {
                    Yii::app()->user->setFlash('skuimage', 'Image ' . $modelimage->idskuimages . ' could not be uploaded, please reupload');
                    $this->redirect(array('maintain', 'id' => $modelimage->idsku));
                }
            } else {
                Yii::app()->user->setFlash('skuimage', 'Image ' . $modelimage->idskuimages . ' could not be found, please reupload');
                $this->redirect(array('maintain', 'id' => $modelimage->idsku));
            }
        } else {
            $this->renderPartial('updateImage', array('model' => $modelimage), false, true);
            Yii::app()->end();
        }
    }


    public function actionFetchCost($id) {
        $cost = 0;
        $totcost = 0;
        if (!is_null($id) && $id !== '' && $id !== 0) {
            $cost = ComSpry::calcSkuCostArray($id);
        }
        $sku = Sku::model()->find('idsku=:idsku', array(':idsku' => trim($id)));
        $skustones = $sku->skustones;
        $stonecost = 0;
        foreach ($skustones as $skustone) {
            $stonecost += ($skustone->idstone0->weight) * ($skustone->idstone0->curcost);
        }
        $skumetal = $sku->skumetals[0];
        $metalcost = $skumetal->idmetal0->currentcost * $skumetal->weight;
        if (!is_null($id) && $id !== '' && $id !== 0) {
            $totcost = ComSpry::calcSkuCost($id);
        }

        //TODO echo the display
        //print_r($cost) ;
        echo '<style>
                    .pricetab b{color:#ff0000;}
                    .pricetab .tabcell{background:#E5F1F4; border-right:5px solid #C4CED1; border-bottom:5px solid #C4CED1; padding-right:5px;}
            </style>';

        echo '<div class="pricetab" style="width: 80%; float: right; display: inline-table; align:left; font-size:11px; line-height:20px;">';
        echo '<div style="display:table-row;"><div class="tabcell" style="display:table-cell;">Metal Cost: <b>' . $cost['metal'] . '</b></div><div class="tabcell" style="display:table-cell;">Finding Cost: <b>' . $cost['find'] . '</b></div><div class="tabcell" style="display:table-cell;">Rhodium: <b>' . $cost['chem'] . '</b></div></div>';
        echo '<div style="display:table-row;"><div class="tabcell" style="display:table-cell;">Stone Cost: <b>' . $cost['stone'] . '</b></div></div>';
        echo '<div style="display:table-row;float:left; font-weight:bold">Fixed Labor Costs</div><div style="display:table-row;">';
        foreach ($cost['fixcost'] as $fixcost) {
            echo '<div class="tabcell" style="display:table-cell;">' . $fixcost['name'] . ': <b>' . $fixcost['val'] . '</b></div>';
        }
        echo '</div>';
        echo '<div style="display:table-row;float:left;font-weight:bold">CPFR Costs</div><div style="display:table-row;">';
        foreach ($cost['factor'] as $factor) {
            echo '<div class="tabcell" style="display:table-cell;">' . $factor['name'] . ': <b>' . $factor['val'] . '</b></div>';
        }
        echo '</div>';
        echo '<div style="display:table-row;float:left; font-weight:bold">Platting Costs</div><div style="display:table-row;">';
        foreach ($cost['formula'] as $formula) {
            echo '<div class="tabcell" style="display:table-cell;">' . $formula['name'] . ': <b>' . $formula['val'] . '</b></div>';
        }
        echo '<div class="tabcell" style="display:table-cell;">Setting Cost:  <b>' . $cost['stoset'] . '</b></div>';
        echo '<div class="tabcell" style="display:table-cell;">Bagging:  <b>' . $cost['bagging'] . '</b></div>';
        echo '</div>';
        echo '<div style="display:table-row;float:left; font-weight:bold">Total Labor Costs:<b>' . $cost['labor'] . '</b></div><br />';
        echo '<div style="display:table-row;float:left; font-weight:bold">Total Cost:<b>' . $totcost . '</b></div>';
        echo '</div>';
        Yii::app()->end();
    }

    public function actionFetchCostDisplay($id) {
        $cost = 0;
        if (!is_null($id) && $id !== '' && $id !== 0) {
            $cost = ComSpry::calcSkuCost($id);
        }
        echo 'Cost for id ' . $id . ' code ' . Sku::model()->findByPk($id)->skucode . ' is = $' . $cost;
        Yii::app()->end();
    }

    public function totMetalWeightFind($id) {
        $findwt = Sku::model()->getDbConnection()->createCommand('select sum(fg.weight*sf.qty) wt from {{skufindings}} sf, {{finding}} fg where sf.idsku=' . $id . ' and sf.idfinding=fg.idfinding')->queryScalar();
        return $findwt;
    }

    public function totMetalWtOnly($id) {
        $summetwt = Sku::model()->getDbConnection()->createCommand('select sum(weight) from {{skumetals}} where idsku=' . $id)->queryScalar();
        return $summetwt;
    }

    /**
     * This method is used to create duplicate entry for an Sku.
     */
    public function actionDuplicate($id) {

        $model = Sku::model()->find('idsku=:ID', array(':ID' => $id));
        $modelnew = new Sku;


        if (isset($_POST['Sku'])) {
            $modelnew->attributes = $model->attributes;
            $modelnew->attributes = $_POST['Sku'];
            $modelnew->updby = Yii::app()->user->getId();
            if ($modelnew->save()) {
                $modelcontent = new Skucontent;
                $modelcontent->attributes = $model->skucontent->attributes;
                $modelcontent->idsku = $modelnew->idsku;
                $modelcontent->name = $modelnew->skucode;
                $modelcontent->descr = $modelnew->skucode;
                $modelcontent->updby = Yii::app()->user->getId();
                if ($modelcontent->save() == 0) {
                    Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to content error");
                    $this->renderduplicate($this, $model, $modelnew);
                    die();
                }
                //echo('<pre>');print_r($modelnew->idsku);die();
                foreach ($model->skumetals as $skumetal) {
                    $modelmetal = new Skumetals;
                    $modelmetal->attributes = $skumetal->attributes;
                    $modelmetal->idsku = $modelnew->idsku;
                    $modelmetal->idskumetals = "";
                    $modelmetal->updby = Yii::app()->user->getId();
                    if ($modelmetal->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to metal content error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                foreach ($model->skuaddons as $skuaddon) {
                    $modeladdon = new Skuaddon;
                    $modeladdon->attributes = $skuaddon->attributes;
                    $modeladdon->idsku = $modelnew->idsku;
                    $modeladdon->idskuaddon = "";
                    $modeladdon->updby = Yii::app()->user->getId();
                    if ($modeladdon->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to addon error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                foreach ($model->skufindings as $skufinding) {
                    $modelfindings = new Skufindings;
                    $modelfindings->attributes = $skufinding->attributes;
                    $modelfindings->idsku = $modelnew->idsku;
                    $modelfindings->idskufindings = "";
                    $modelfindings->updby = Yii::app()->user->getId();
                    if ($modelfindings->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to findings error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                foreach ($model->skuimages as $skuimage) {
                    $modelimages = new Skuimages();
                    $modelimages->scenario = 'duplicate';
                    $modelimages->attributes = $skuimage->attributes;
                    $modelimages->idsku = $modelnew->idsku;
                    $modelimages->image = $skuimage->image;
                    $modelimages->idskuimages = "";
                    $modelimages->updby = Yii::app()->user->getId();
                    if ($modelimages->save('duplicate') == 0) {
                        echo('<pre>');
                        print_r($modelimages);
                        die();
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to image error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                foreach ($model->skuselmaps as $skuselmap) {
                    $modelselmap = new Skuselmap;
                    $modelselmap->attributes = $skuselmap->attributes;
                    $modelselmap->idsku = $modelnew->idsku;
                    $modelselmap->idskuselmap = "";
                    if ($modelselmap->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to image seller map error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                foreach ($model->skustones as $skustone) {
                    $modelstones = new Skustones;
                    $modelstones->attributes = $skustone->attributes;
                    $modelstones->idsku = $modelnew->idsku;
                    $modelstones->idskustones = "";
                    $modelstones->updby = Yii::app()->user->getId();
                    if ($modelstones->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to stone error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }
                }

                
                foreach ($model->skureviews as $skureview) {
                    $modelreview = new Skureviews;
                    $modelreview->attributes = $skureview->attributes;
                    $modelreview->idsku = $modelnew->idsku;
                    $modelreview->idskureview = "";
                    $modelreview->updby = Yii::app()->user->getId();
                    if ($modelreview->save() == 0) {
                        Yii::app()->user->setFlash('Error', "Sku cannot be duplicated due to review error");
                        $this->renderduplicate($this, $model, $modelnew);
                        die();
                    }   
                }
                
                //when all models are saved, move the sku update page
                $this->redirect(array('product/maintain', 'id' => $modelnew->idsku));
            }
        }

        $this->render('duplicate', array(
            'model' => $model, 'modelnew' => $modelnew
        ));

        // echo '<pre>'; print_r($model->skucontent->attributes);die();
    }

    private function renderduplicate($phpobject, $model, $modelnew) {
        $phpobject->render('duplicate', array(
            'model' => $model, 'modelnew' => $modelnew
        ));
    }

    /*
     * SKU report export to Excel Sheet Sudhanshu
     */

    public function actionExport() {
        list($controller) = Yii::app()->createController('skuexport/index');
        $modelwi = new WorksheetiForm;

        if (isset($_POST['ids'])) {

            if (isset($_COOKIE['save-selection-admin'])) {   //check if cookie is set
                $res_cookie = stripslashes($_COOKIE['save-selection-admin']);
                $res_cookie = json_decode($res_cookie);

                $skuid = array_merge($res_cookie, $_POST['ids']);  //merge cookie values and checked values
                $skuid = array_unique($skuid);
                $skuid = implode(",", $skuid);
            } else {
                $skuid = implode(",", $_POST['ids']);
            }

            $modelwi->skuid = $skuid;
            $modelwi->idclient = 0;

            $controller->Worksheet($modelwi->skuid, $modelwi->idclient);
        }

    }

    public function actionExport_quotesheet() {
        list($controller) = Yii::app()->createController('skuexport/index');
        $modelqi = new QuotesheetiForm;

        if (isset($_POST['ids'])) {
            if (isset($_COOKIE['save-selection'])) {   //check if cookie is set
                $res_cookie = stripslashes($_COOKIE['save-selection']);
                $res_cookie = json_decode($res_cookie);

                $skuid = array_merge($res_cookie, $_POST['ids']);  //merge cookie values and checked values
                $skuid = array_unique($skuid);
                $skuid = implode(",", $skuid);
            } else {
                $skuid = implode(",", $_POST['ids']);
            }

            $modelqi->skuid = $skuid;
            $modelqi->idclient = 0;

            $controller->Quotesheet_master($modelqi->skuid, $modelqi->idclient);
        }
    }

    public function actionMaster() {
        $uid = Yii::app()->user->getId();
        if ($uid != 1) {
            $value = ComSpry::getUnserilizedata($uid);
            if (empty($value) || !isset($value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
            if (!in_array(56, $value)) {
                throw new CHttpException(403, 'You are not authorized to perform this action.');
            }
        }
        if (isset($_POST['selected_sku'])) {
            $model = new Sku();

            $res1 = Sku::model()->hasCookie('save-selection');

            if (!empty($res1)) {

                $res_cookie = Sku::model()->getCookie('save-selection');
                $res_cookie = stripslashes($res_cookie);
                $res_cookie = json_decode($res_cookie);
                $json = array_unique(array_merge($res_cookie, $_POST['selected_sku']));
            } else {

                $json = $_POST['selected_sku'];
            }
            $json = json_encode($json);

            $model->setCookie('save-selection', $json);
            //print_r($_POST['selected_sku']);
        }
        $image = new Skuimages;
        $model = new Sku('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sku']))
            $model->attributes = $_GET['Sku'];
        $imageUrl = $image->imageThumbUrl;
        $this->render('master', array(
            'model' => $model,
            'skuimages' => $imageUrl
        ));
    }

    public function gridskuimages($data, $row) {

        $skuimages = Skuimages::model()->findByAttributes(array('idsku' => $data->idsku, 'type' => 'MISG'));
        if (!empty($skuimages)) {
            return Yii::app()->baseUrl . "/images/" . Client::getClientImgFolder($skuimages->idclient) . 'thumb' . "/" . $skuimages->image;
        }
    }
    
    public function actionGetstone(){         
        $lista=Stone::model()->findAll(
                    array(
                       'select'=>'distinct namevar',
                            //'condition'=>"trim(namevar) LIKE '%" .$_GET['q']. "%' AND type IS NULL"
                             'condition'=>" (trim(namevar) LIKE '%" .$_GET['q']. "%') AND (jewelry_type = 1)"
                                 ));  
                       $reusults = array();
                       foreach ($lista as $list){
                        $reusults[] = array(
                                                 'id'=>  trim($list->namevar),
                        'name'=> trim($list->namevar),
                   ); 
                }
                 
                    echo CJSON::encode($reusults);  
             }   
    public function actionGetstonedetails(){          
        $sql = 'select tbl_stone.namevar as namevar,tbl_stone.idstone as idstone, concat(tbl_stone.namevar,"-",tbl_shape.name,"-",tbl_stonesize.size,"-",tbl_stone.quality)as name from tbl_stone, tbl_stonesize, tbl_shape where trim(tbl_stone.namevar) LIKE "%'.$_GET['q'].'%" and tbl_stone.idshape= tbl_shape.idshape and tbl_stone.idstonesize = tbl_stonesize.idstonesize order by tbl_stone.namevar asc, tbl_shape.name asc, tbl_stonesize.size';
        $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
        $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $data[] = array(
                'id'=>  trim($row['idstone']),
                'name'=> trim($row['name']),
            ); 
        }
        echo CJSON::encode($data);  
    }   

    public function actionGetshape() {
        $shape = Stone::model()->findAll(
                array(
                    'select' => 'distinct idshape',
                    'condition' => "namevar LIKE '%" . $_POST['name'] . "%'AND jewelry_type = 1"
                )
        );

        $reusults = array();
        foreach ($shape as $list) {
            $reusults[] = '<option value="' . $list->idshape0->idshape . '">' . $list->idshape0->name . '</option>';
        }
        echo "<pre>";
        print_r($reusults);
        die;
    }

    public function actionGetsize() {
        $shape = Stone::model()->findAll(
                array(
                    'select' => 'distinct idstonesize',
                    'condition' => "namevar='" . $_POST['stone'] . "' and idshape=" . $_POST['shape'].' and jewelry_type = 1'
                )
        );

        $reusults = array();
        foreach ($shape as $list) {
            $reusults[] = '<option value="' . $list->idstonesize0->idstonesize . '">' . $list->idstonesize0->size . '</option>';
        }
        echo "<pre>";
        print_r($reusults);
        die;
    }

    public function actionGetquality() {
        $shape = Stone::model()->findAll(
                array(
                    'select' => 'distinct quality',
                    'condition' => "namevar='" . $_POST['name'] . "'"
                )
        );

        $reusults = array();
        foreach ($shape as $list) {
            $reusults[] = '<option value="' . $list->quality . '">' . $list->quality . '</option>';
        }
        echo "<pre>";
        print_r($reusults);
        die;
    }
    
    public function actionGetskucode(){       
        $lista=Sku::model()->findAll(
            array(
              'select'=>'idsku, skucode',
              'condition'=>"skucode LIKE '%" .$_GET['q']. "%'"
        ));    
        $reusults = array();
           foreach ($lista as $list){
            $reusults[] = array(
                'id'=>$list->idsku,
                'name'=>  $list->skucode,
            ); 
        }
         
        echo CJSON::encode($reusults);  
    }   

     public function actionCreateReview($id){
        $modelreview = new Skureviews;
        $modelreview->idsku = $id;
        if (isset($_POST['Skureviews'])) {
            $modelreview->attributes = $_POST['Skureviews'];
            if ($modelreview->save()) {
                Yii::app()->user->setFlash('skureview', 'Skureview ' . $modelreview->idskureview . ' created successfully');
                $modelreview->unsetAttributes();
                $modelreview->idsku = $id;
                return $this->renderPartial('_form_review', array('model' => $modelreview));
                Yii::app()->end();
            }
        }
        return $this->renderPartial('_form_review', array('model' => $modelreview));
        Yii::app()->end();
    }

    public function actionUpdateReview($id) {
        $modelreview = Skureviews::model()->findByPk($id);
        if (isset($_POST['Skureviews'])) {
            $modelreview->attributes = $_POST['Skureviews'];
            if ($modelreview->save()) {
                echo 'Skureview ' . $modelreview->idskureview . ' updated successfully';
            } else {
                echo 'Skureview ' . $modelreview->idskureview . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateReview', array('model' => $modelreview), false, true);
        }
    }

    public function actionDeleteReview($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Skureviews::model()->findByPk($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Skureviews::model()->findByPk($id)->idsku));
        }else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionMoveReviews(){
        $sku = Sku::model()->findAll();
        set_time_limit(300);
        foreach($sku as $key){
            $stone = Skustones::model()->findAll(array(
                'condition'=>'idsku=:skuid AND reviews!=""',
                'params'=>array(':skuid'=>$key->idsku)
            ));
            foreach($stone as $key1){
                $review =new Skureviews;
                $review->idsku = $key->idsku;
                $review->reviews = $key1->reviews;
                $review->updby = $key1->updby;
                if(!$review->save()){
                    $newarray[] = $key1->idskustones;
                }
            }
        }
        $this->redirect(array('admin')); 
    }

    public function actionGetTotalCost($start,$end){
        $skus = Sku::model()->findAll("idsku>=:start AND idsku<=:end", array(":start"=>$start,":end"=>$end));
        foreach($skus as $sku){
            $modelsku = Sku::model()->findByPk($sku->idsku);
            $totalcost = ComSpry::calcSkuCost($sku->idsku);
            $modelsku->tot_cost = $totalcost;
            $modelsku->save();
        } 
         echo "<pre>"; print_r("Total Cost added Successfully From ".$start. ' To '.$end);
    }

    
}

