<?php

class BeadController extends Controller
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
				'actions'=>array('create','update', 'admin' , 'maintain' , 'createMetal' ,'createFinding', 'createImage', 'deleteMetal', 'deleteFinding',''),
				'actions'=>array('create','update', 'admin' , 'maintain' , 'createMetal' ,'createFinding', 'createImage','createStone','updateMetal','updateBead','updateFinding','updateStone', 'updateImage','deleteMetal', 'deleteFinding','deleteImage', 'deleteStone','getStone', 'export','createReview' ,'updateReview','deleteReview','getshape','getsize'),
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
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Bead('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Bead']))
            $model->attributes=$_GET['Bead'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$beadsku=new Bead;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Bead']))
		{
			$beadsku->attributes=$_POST['Bead'];
			if($beadsku->save())
				$this->redirect(array('maintain','id'=>$beadsku->idbeadsku));
		}

		$this->render('create',array(
			'model'=>$beadsku,
		));
	}

	public function actionMaintain($id){
		$beadsku = Bead::model()->findByPk((int) $id);
		$beadstones = new Beadstones;
		$beadstones->idbeadsku = $id;
		$beadmetal = new Beadmetals;
		$beadmetal->idbeadsku = $id;
		$beadfinding = new Beadfinding;
		$beadfinding->idbeadsku = $id;
		$beadimages = new Beadimages;
		$beadimages->idbeadsku = $id;
        $beadreview = new Beadreviews;
        $beadreview->idbeadsku = $id;
		if(isset($_POST['Bead'])){
			$beadsku->attributes=$_POST['Bead'];
			if($beadsku->save())
			$this->redirect(array('maintain','id'=>$beadsku->idbeadsku));
		}

		$this->render('maintain',array(
			'modelbead'=>$beadsku,
			'modelstones' =>$beadstones,
			'modelmetal' => $beadmetal,
			'modelfinding' => $beadfinding,
			'modelimages' => $beadimages,
            'modelreview' => $beadreview,
		));


	}

     public function actionCreateMetal($id){
        $modelmetal = new Beadmetals;
        $modelmetal->idbeadsku = $id;
        if (isset($_POST['Beadmetals'])) {
            $modelmetal->attributes = $_POST['Beadmetals'];
            if ($modelmetal->save()) {
                Yii::app()->user->setFlash('beadmetal', 'Beadmetal ' . $modelmetal->idbeadmetals . ' created successfully');
                $modelmetal->unsetAttributes();
                $modelmetal->idbeadsku = $id;
                return $this->renderPartial('_form_metal', array('model' => $modelmetal));
                Yii::app()->end();
            }else{
                Yii::app()->user->setFlash('beadmetal', 'Beadmetal not created');
            }
        }
        return $this->renderPartial('_form_metal', array('model' => $modelmetal));
        Yii::app()->end();
    }

    public function actionUpdateMetal($id) {
        $modelmetal = Beadmetals::model()->findByPk($id);
        if (isset($_POST['Beadmetals'])) {
            $modelmetal->attributes = $_POST['Beadmetals'];
            if ($modelmetal->save()) {
                echo 'Beadmetal ' . $modelmetal->idbeadmetals. ' updated successfully';
            } else {
                echo 'Beadmetal ' . $modelmetal->idbeadmetals . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateMetal', array('model' => $modelmetal), false, true);
        }
    }

    public function actionDeleteMetal($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Beadmetals::model()->findByPk($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Beadmetals::model()->findByPk($id)->idbeadsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


	public function actionCreateFinding($id){
		$modelfinding = new Beadfinding;
        $modelfinding->idbeadsku = $id;
        if (isset($_POST['Beadfinding'])) {
        	 $modelfinding->attributes = $_POST['Beadfinding'];
            if ($modelfinding->save()) {
            	Yii::app()->user->setFlash('beadfinding', 'Beadfinding' . $modelfinding->idbeadfinding . ' created successfully');
                $modelfinding->unsetAttributes();
                $modelfinding->idbeadsku = $id;
                return $this->renderPartial('_form_finding', array('model' => $modelfinding));
                Yii::app()->end();
            }
        }
        return $this->renderPartial('_form_finding', array('model' => $modelfinding));
        Yii::app()->end();
	}

	public function actionCreateImage($id){
		$modelimage = new Beadimages('insert');
        $modelimage->idbeadsku = $id;
        if (isset($_POST['Beadimages'])) {
        	$modelimage->attributes = $_POST['Beadimages'];
            $modelimage->image = CUploadedFile::getInstance($modelimage, 'image');
            if (isset($modelimage->image) && $modelimage->image !== '') {
            	if($modelimage->type == 'MISG'){
                    $filename = $modelimage->idbeadsku . '--' . $modelimage->type . '.' . $modelimage->image->extensionName;
                }else{
                    $filename = $modelimage->image->name;
                }
                if ($modelimage->image->saveAs(Yii::app()->basePath . '/..' . '/bead_images/' . Client::getClientImgFolder(null) . Client::getClientStdImgSize(null) . '/' . $filename)) {
                    Yii::app()->thumb->setThumbsDirectory('/bead_images/' . Client::getClientImgFolder(null).'thumb');

                    Yii::app()->thumb
                            ->load(Yii::getPathOfAlias('webroot') . "/bead_images/" . Client::getClientImgFolder(null) . Client::getClientStdImgSize(null) . "/" . $filename)
                            ->resize('150', '150')
                            ->save($filename, strtoupper($modelimage->image->extensionName));

                    $modelimage->image = $filename;
                    
                    if ($modelimage->save()) {
                        Yii::app()->user->setFlash('beadimage', 'Bead Image ' . $modelimage->idbeadimages . ' created successfully');
                        $this->redirect(array('maintain', 'id' => $id));
                    }
                }else {
                    Yii::app()->user->setFlash('beadimage', 'Bead Image could not be uploaded');
                    $this->redirect(array('maintain', 'id' => $id));
                }
            }else {            	
                Yii::app()->user->setFlash('beadimage', 'Bead Image not specified');
                $this->redirect(array('maintain', 'id' => $id));
            }
        }
        return $this->renderPartial('_form_image', array('model' => $modelimage));
        Yii::app()->end();
	}

    public function actionCreateStone($id){
        $modelstone = new Beadstones;
        $modelstone->idbeadsku = $id;
        if(!empty($_POST['Shape']) && !empty($_POST['Size'])){
          $sql = "select idstone as id from tbl_stone where tbl_stone.jewelry_type = 2 and tbl_stone.namevar='" . $_POST['Beadstones']['idstone'] . "' and tbl_stone.idstonesize =" . $_POST['Size'] . " and tbl_stone.idshape =" . $_POST['Shape'];
          $dependency = new CDbCacheDependency('SELECT MAX(mdate) FROM tbl_stone');
          $rows = Yii::app()->db->cache(1000, $dependency)->createCommand($sql)->queryAll();
          $modelstone->idstone = $rows[0]['id'];
        }
        
        if (isset($_POST['Beadstones'])) {
            $modelstone->idsetting = $_POST['Beadstones']['idsetting'];
            $modelstone->pieces = $_POST['Beadstones']['pieces'];
            $modelstone->lgsize = $_POST['Beadstones']['lgsize'];
            $modelstone->smsize = $_POST['Beadstones']['smsize'];
            $modelstone->gem_wt = $_POST['Beadstones']['gem_wt'];
            if ($modelstone->save()) {
                $modelbead = Bead::model()->findByPk($modelstone->idbeadsku);
                $stodata = $modelbead->topStoneWeightNum();
                $modelbead->totstowei = $stodata['wt'];
                $modelbead->numstones = $stodata['ns'];
                $modelbead->save();
                Yii::app()->user->setFlash('beadstone', 'Beadstone ' . $modelstone->idbeadstones . ' created successfully');
                $modelstone->unsetAttributes();
                $modelstone->idbeadsku = $id;
                return $this->renderPartial('_form_stone', array('model' => $modelstone));
                Yii::app()->end();
            }
        }
        //return $this->renderPartial('_form_stone', array('model' => $modelstone));
        Yii::app()->end();
    }

    public function actionUpdateStone($id){
        $modelstone = Beadstones::model()->findByPk($id);
        if(isset($_POST['Beadstones'])){
            $modelstone->attributes = $_POST['Beadstones'];
            if ($modelstone->save()) {
                $modelbead = Bead::model()->findByPk($modelstone->idbeadsku);
                $stodata = $modelbead->topStoneWeightNum();
                $modelbead->totstowei = 0 + ($stodata['wt']);
                $modelbead->numstones = 0 + ($stodata['ns']);
                if ($modelbead->save()) {
                    echo 'Beadstone ' . $modelstone->idbeadstones . ' updated successfully';
                } else {
                    print_r($modelbead->getErrors());
                    echo 'error occurred in sku updation';
                }
            }else {
                echo 'Beadstone ' . $modelstone->idbeadstones . ' could not be updated at this time, please remodify';
            }
        }else{
            $this->renderPartial('updateStone', array('model' => $modelstone), false, true);
            Yii::app()->end();
        }
    } 

    public function actionDeleteStone($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $modelstone = Beadstones::model()->findByPk($id);
            $idbeadsku = $modelstone->idbeadsku;
            // we only allow deletion via POST request
            $modelstone->delete();
            $modelbead = Bead::model()->findByPk($idbeadsku);
            $stodata = $modelbead->topStoneWeightNum();
            $modelbead->totstowei = 0 + ($stodata['wt']);
            $modelbead->numstones = 0 + ($stodata['ns']);
            $modelbead->save();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Beadstones::model()->findByPk($id)->idbeadsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateBead($id){
		$modelbead = Bead::model()->findByPk((int) $id);
        if (isset($_POST['Bead'])) {
            $modelbead->attributes = $_POST['Bead'];
            if ($modelbead->save()) {
                Yii::app()->user->setFlash('bead', ' Bead id ' . $modelbead->idbeadsku . ' updated successfully');
                return $this->renderPartial('_form_bead', array('model' => $modelbead));
                Yii::app()->end();
            }
        }
        return $this->renderPartial('_form_bead', array('model' => $modelbead));
	}

	public function actionUpdateFinding($id) {
        $modelfinding = Beadfinding::model()->findByPk($id);
        if (isset($_POST['Beadfinding'])) {
            $modelfinding->attributes = $_POST['Beadfinding'];
            if ($modelfinding->save()) {
                echo 'Beadfinding ' . $modelfinding->idbeadfinding. ' updated successfully';
            } else {
                echo 'Beadfinding ' . $modelfinding->idbeadfinding . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateFinding', array('model' => $modelfinding), false, true);
        }
    }

    public function actionUpdateImage($id){
    	$modelimage = Beadimages::model()->findByPk($id);
        $modelimage->scenario = 'insert';
        if (isset($_POST['Beadimages'])) {
        	$modelimage->attributes = $_POST['Beadimages'];
            $modelimage->image = CUploadedFile::getInstance($modelimage, 'image');
            if (isset($modelimage->image) && $modelimage->image !== '') {
            	if($modelimage->type == 'MISG'){
                    $filename = $modelimage->idbeadsku . '--' . $modelimage->type . '.' . $modelimage->image->extensionName;
                }else{
                    $filename = $modelimage->image->name;
                }

                if ($modelimage->image->saveAs(Yii::app()->basePath . '/..' . '/bead_images/' . Client::getClientImgFolder(null) . Client::getClientStdImgSize(null) . '/' . $filename)) {
                    Yii::app()->thumb->setThumbsDirectory('/bead_images/' . Client::getClientImgFolder(null).'thumb');

                    Yii::app()->thumb
                            ->load(Yii::getPathOfAlias('webroot') . "/bead_images/" . Client::getClientImgFolder(null) . Client::getClientStdImgSize(null) . "/" . $filename)
                            ->resize('150', '150')
                            ->save($filename, strtoupper($modelimage->image->extensionName));

                    $modelimage->image = $filename;
                    if ($modelimage->save()) {
                        Yii::app()->user->setFlash('beadimage', 'Bead Image ' . $modelimage->idbeadimages . ' created successfully');
                        $this->redirect(array('maintain', 'id' =>  $modelimage->idbeadsku ));
                    }
                }else {
                    Yii::app()->user->setFlash('beadimage', 'Bead Image could not be uploaded');
                    $this->redirect(array('maintain', 'id' =>  $modelimage->idbeadsku));
                }
            }
        } else {
            $this->renderPartial('updateImage', array('model' => $modelimage), false, true);
            Yii::app()->end();
        }
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	
	
    public function actionDeleteFinding($id)
	{
		if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Beadfinding::model()->findByPk($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Beadfinding::model()->findByPk($id)->idbeadsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDeleteImage($id)
	{
		if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Beadimages::model()->findByPk($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Beadimages::model()->findByPk($id)->idbeadsku));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

    
    public function actionCreateReview($id){
        $modelreview = new Beadreviews;
        $modelreview->idbeadsku = $id;
        if (isset($_POST['Beadreviews'])) {
            $modelreview->attributes = $_POST['Beadreviews'];
            if ($modelreview->save()) {
                Yii::app()->user->setFlash('beadreview', 'Beadreview ' . $modelreview->idbeadreview . ' created successfully');
                $modelreview->unsetAttributes();
                $modelreview->idbeadsku = $id;
                return $this->renderPartial('_form_review', array('model' => $modelreview));
                Yii::app()->end();
            }
        }
        return $this->renderPartial('_form_review', array('model' => $modelreview));
        Yii::app()->end();
    }

    public function actionUpdateReview($id) {
        $modelreview = Beadreviews::model()->findByPk($id);
        if (isset($_POST['Beadreviews'])) {
            $modelreview->attributes = $_POST['Beadreviews'];
            if ($modelreview->save()) {
                echo 'Beadreview ' . $modelreview->idbeadreview . ' updated successfully';
            } else {
                echo 'Beadreview ' . $modelreview->idbeadreview . ' could not be updated at this time, please remodify';
            }
        } else {
            $this->renderPartial('updateReview', array('model' => $modelreview), false, true);
        }
    }

    public function actionDeleteReview($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Beadreviews::model()->findByPk($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('maintain', 'id' => Beadreviews::model()->findByPk($id)->idbeadsku));
        }else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bead the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bead::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bead $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bead-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionExport() {
        $beadids = $_POST['ids'];
        $repeat = count($beadids);
        $totalsku = array();
        $totalsku = $this->masterarray($beadids);
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        // Turn off our amazing library autoload
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        //include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel'. DIRECTORY_SEPARATOR . 'IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $filepath = Yii::app()->getBasePath() . '/components/Bead_Datasheet.xls';
        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objReader = PHPExcel_IOFactory::createReader("Excel2007");
        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        $j=2; 
        for ($i = 2; $i < (($repeat) + 2); $i++) {
            $objPHPExcel->getActiveSheet(0)->getStyle('A:S')->getFont()->setName('Calibri')->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':S' . $i)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(50);

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $j, $totalsku[($i - 2)][0]['beadskucode'])
                ->setCellValue('C' . $j, $totalsku[($i - 2)][0]['type'])
                ->setCellValue('D' . $j, $totalsku[($i - 2)][0]['sub_category'])
                ->setCellValue('E' . $j, $totalsku[($i - 2)][1])
                ->setCellValue('F' . $j, $totalsku[($i - 2)][0]['size'])
                ->setCellValue('G' . $j, $totalsku[($i - 2)][0]['grosswt'])
                ->setCellValue('H' . $j, $totalsku[($i - 2)][0]['magnetwt'])
                ->setCellValue('I' . $j, $totalsku[($i - 2)][0]['totmetalwei']);
            
            $findings = $totalsku[($i - 2)][4]; $p = $j;
            foreach($findings as $finding ){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('Q' . $p, $finding['name'])
                    ->setCellValue('R' . $p, $finding['cost']);
               $p++;
            }

            $stone = $totalsku[($i - 2)][3]; $k = $j;
            foreach($stone as $key){
                $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('J' . $k, $key['stonename'])
                  ->setCellValue('K' . $k, $key['shape'])
                  ->setCellValue('L' . $k, $key['pieces'])
                  ->setCellValue('M' . $k, $key['stonewt'])
                  ->setCellValue('N' . $k, $key['ppc'])
                  ->setCellValue('O' . $k, $key['lgsize'])
                  ->setCellValue('P' . $k, $key['smsize'])
                  ->setCellValue('S' . $k, $key['reviews']);
                $k++;
            }
            //image drawing
            
            if(isset($totalsku[($i - 2)][5][0])){
                $basepath = dirname(dirname(Yii::app()->basePath)).$totalsku[($i - 2)][5][0];
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('Bead image');
                    $objDrawing->setDescription('Bead image');
                    $objDrawing->setPath($basepath);
                    $objDrawing->setCoordinates('A'.$j);
                    $objDrawing->setOffsetX(10);
                    $objDrawing->setOffsetY(10);
                    $objDrawing->setWidthAndHeight(30,45);
                    $objDrawing->setResizeProportional(true);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            }


            $j = $k + 1;
        }

        $styleThickBorderOutline = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray($styleThickBorderOutline);





        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Bead_Datasheet.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        //power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));

    }
    public function masterarray($ids) {
        foreach ($ids as $id) {
            $beadsku = Bead::model()->find('idbeadsku=:idbeadsku', array(':idbeadsku' => trim($id)));
            $category = Category::model()->findAll();
            $beadstones = $beadsku->beadstones;
            $stones = array();
            foreach ($beadstones as $beadstone) {
                $stones[] = array(
                    'beadskus' => $beadsku->beadskucode,
                    'item_type' => $beadsku->type,
                    'subtype'=> $beadsku->sub_category,
                    'totmetalwt' => $beadsku->totmetalwei,
                    'magnetwt' => $beadsku->magnetwt,
                    'totgrosswt' => $beadsku->grosswt,
                    'pieces' => $beadstone->pieces,
                    'shape' => trim($beadstone->idstone0->idshape0->name),
                    'stonename' => trim($beadstone->idstone0->idstonem0->name),
                    'stonewt' => $beadstone->idstone0->weight,
                    'ppc' => $beadstone->idstone0->curcost,
                    'lgsize'=>$beadstone->lgsize,
                    'smsize'=>$beadstone->smsize,
                    'reviews' => $beadstone->remark,
                );
            }
            if(isset($beadsku->beadmetals[0])){
                $beadmetal = $beadsku->beadmetals[0];
                $metal = $beadmetal->idmetal0->namevar;
                $metal_name = $beadmetal->idmetal0->idmetalm0->name;
            }else{
                $metal = '';
                $metal_name = '';
            }
           
            $finds = array();
            $findings = $beadsku->beadfinding;
            foreach ($findings as $finding) {
                $finds[] = array(
                    'name' => $finding->idfinding0->name,
                    'cost' => $finding->idfinding0->cost,
                );
            }
            //image
            $beadimages = $beadsku->beadimages();
            $imageUrls = array();
            foreach ($beadimages as $beadimage) {
                if($beadimage->type == 'MISG'){
                    $imageUrls[] = $beadimage->imageThumbUrl;
                } 
            }
            $totalsku[] = array($beadsku->attributes, $metal, $metal_name,$stones, $finds , $imageUrls);
        }
        return $totalsku;
    }

     public function actionGetshape() {
        $shape = Stone::model()->findAll(
                array(
                    'select' => 'distinct idshape',
                    'condition' => "namevar LIKE '%" . $_POST['name'] . "%' AND jewelry_type = 2"
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
                    'condition' => "namevar='" . $_POST['stone'] . "' and idshape=" . $_POST['shape'].' and jewelry_type = 2'
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
}
