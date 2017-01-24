<?php

class StoneController extends Controller
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
				'actions'=>array('delete','getstonem','getshape','getsize','review','getstone','resetCookie','export'),
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
                if(!in_array(37, $value)){
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
            if(!in_array(37, $value)){
                throw new CHttpException(403,'You are not authorized to perform this action.');
            }
        }
		$model=new Stone;
        $models='';
        $priceopt=array('p'=>'Per Pc','c'=>'Per Ct');
               
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stone']))
		{
            if($this->checkDuplicate($_POST['Stone'])){
				$model->attributes=$_POST['Stone'];
	            if($_POST['priceopt']=='c')
	                $model->curcost=$model->weight*$_POST['Stone']['curcost'];
	            $model->scountry=Stonem::model()->findByPk($model->idstonem)->scountry;
	            $model->creatmeth=Stonem::model()->findByPk($model->idstonem)->creatmeth;
	            $model->treatmeth=Stonem::model()->findByPk($model->idstonem)->treatmeth;

				if($model->save())
					 Yii::app()->user->setFlash('errormessage', "Stone created successfully!");
					$this->redirect(array('create'));
            } else{
                Yii::app()->user->setFlash('errormessage', "Cannot create a duplicate stone!");
            }
		}
        $models=new Stone('search');
        $models->unsetAttributes();  // clear any default values
        if(isset($_GET['Stone']))
            $models->attributes=$_GET['Stone'];

		$this->render('create',array(
			'model'=>$model,'models'=>$models,'priceopt'=>$priceopt,
		));
                
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{  
             //echo "<pre>";print_r($_POST);die;
             $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(37, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=$this->loadModel($id);
              $priceopt=array('p'=>'Per Pc','c'=>'Per Ct');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $oldcost=$model->curcost;
                /* ---- SPry manish dec 31 2012 start-----*/
              if($model->weight != 0){
             $cost_price = round($model->curcost/$model->weight,2);
              }
              else{
                  $cost_price = 0;
              }
              /* ---- SPry manish dec 31 2012 End-----*/
		if(isset($_POST['Stone']))
		{
			$model->attributes=$_POST['Stone'];
                        $model->prevcost=$oldcost;
                        if($_POST['priceopt']=='c'){
                            $model->curcost=$model->weight*$_POST['Stone']['curcost'];
                        }
			if($model->save()){
                            $stonecostlog=new Stonecostlog('insert');
                            $stonecostlog->cdate=$model->cdate;
                            $stonecostlog->mdate=$model->mdate;
                            $stonecostlog->updby=$model->updby;
                            $stonecostlog->cost=$model->curcost;
                            $stonecostlog->idstone=$model->idstone;
                            if($stonecostlog->save()){
				$this->redirect(array('view','id'=>$model->idstone));
                            }
                           
                        }
		}

		$this->render('update',array(
			'model'=>$model,'priceopt'=>$priceopt,'cost_price'=>$cost_price
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
                if(!in_array(37, $value)){
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
		$dataProvider=new CActiveDataProvider('Stone');
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
            if(!in_array(37, $value)){
                throw new CHttpException(403,'You are not authorized to perform this action.');
            }
        }
        if (isset($_POST['selected_sku'])) {
            $model = new Stone();
            $res1 = Stone::model()->hasCookie('save-selection-stone');
            if (!empty($res1)) {
                $res_cookie = Stone::model()->getCookie('save-selection-stone');
                $res_cookie = stripslashes($res_cookie);
                $res_cookie = json_decode($res_cookie);
                $json = array_unique(array_merge($res_cookie, $_POST['selected_sku']));
            } else {
                $json = $_POST['selected_sku'];
            }
            $json = json_encode($json);
            $model->setCookie('save-selection-stone', $json);
        }
            
		$model=new Stone('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stone']))
			$model->attributes=$_GET['Stone'];
		$this->render('admin',array(
			'model'=>$model,
		));
                
	}
	public function actionResetCookie(){
		$model = new Stone();
		$model->removeCookie('save-selection-stone');
	}

	public function actionExport() {
        if (isset($_POST['ids'])) {
            if (isset($_COOKIE['save-selection-stone'])) {   //check if cookie is set
                $res_cookie = stripslashes($_COOKIE['save-selection-stone']);
                $res_cookie = json_decode($res_cookie);
                $skuidstone = array_merge($res_cookie, $_POST['ids']);  //merge cookie values and checked values
                $skuidstone = array_unique($skuidstone);
                $skuidstone = implode(",", $skuidstone);
            } else {
                $skuidstone = implode(",", $_POST['ids']);
            }
        }
        $ids = explode(",", $skuidstone);
        $repeat = count($ids);
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
        $totalsku = array();
        $totalsku = $this->masterarray($ids);
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("GJMIS")
                ->setLastModifiedBy("GJMIS")
                ->setTitle("Excel Export Document")
                ->setSubject("Excel Export Document")
                ->setDescription("Exporting documents to Excel using php classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Excel export file");
        $lfcr = chr(10);

        $styleDefaultArray = array(
            'font' => array(
                'bold' => false,
                'size'=>10,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $styleHeaderArray = array(
            'font' => array(
                'bold' => true,
                'size'=>11,
            ),
             'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:K2')->applyFromArray($styleHeaderArray);

        $objPHPExcel->setActiveSheetIndex(0)
        	->setCellValue('A1', 'Stones')
        	->setCellValue('A2', 'Stone Id')
        	->setCellValue('B2', 'Stone Alias')
        	->setCellValue('C2', 'StoneM')
        	->setCellValue('D2', 'Shape')
        	->setCellValue('E2', 'Size')
        	->setCellValue('F2', 'Color')
        	->setCellValue('G2', 'Grade')
        	->setCellValue('H2', 'Cut')
        	->setCellValue('I2', 'ct/wt')
        	->setCellValue('J2', 'Type')
        	->setCellValue('K2', 'Price');

        	
        for ($i = 3; $i < ($repeat) + 3; $i++) {
        	$objPHPExcel->setActiveSheetIndex(0)
        		->setCellValue('A'.$i, $totalsku[($i-3)]['idstone'])
        		->setCellValue('B'.$i, $totalsku[($i-3)]['stonealias'])
        		->setCellValue('C'.$i, $totalsku[($i-3)]['stonem'])
        		->setCellValue('D'.$i, $totalsku[($i-3)]['shape'])
        		->setCellValue('E'.$i, $totalsku[($i-3)]['size'])
        		->setCellValue('F'.$i, $totalsku[($i-3)]['color'])
        		->setCellValue('G'.$i, $totalsku[($i-3)]['grade'])
        		->setCellValue('H'.$i, $totalsku[($i-3)]['cut'])
        		->setCellValue('I'.$i, $totalsku[($i-3)]['ct_wt'])
        		->setCellValue('J'.$i, $totalsku[($i-3)]['jewe_type'])
        		->setCellValue('K'.$i, $totalsku[($i-3)]['price']);

        	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->applyFromArray($styleDefaultArray);
        	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        		
        }
        spl_autoload_register(array('YiiBase', 'autoload'));
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Stones.xlsx"');
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas();
        $objWriter->save('php://output');
        Yii::app()->end();

        // Once we have finished using the library, give back the
        // power to Yii...
        spl_autoload_register(array('YiiBase', 'autoload'));
    }

    public function masterarray($ids){

    	foreach ($ids as $id) {
    		$stone = Stone::model()->find('idstone=:idskustone', array(':idskustone' => trim($id)));
    		if($stone->jewelry_type == 1){
    			$type = 'Jewelry';
    		}else{
    			$type = 'Bead';
    		}
    		$totalsku[] = array(
    			'idstone' => $stone->idstone,
    			'stonealias'=>$stone->namevar,
    			'stonem'=> $stone->idstonem0->name,
    			'shape' => trim($stone->idshape0->name),
    			//'clarity'=> $stone->idclarity0->name,
    			'size'=> $stone->idstonesize0->size,
    			'color'=>$stone->color,
    			'scountry'=>$stone->scountry,
    			'grade'=>$stone->quality,
    			'cut'=>$stone->cut,
    			'ct_wt'=>$stone->weight,
    			'jewe_type'=> $type,
    			'price'=>$stone->curcost,

    		);
    	}
    	return $totalsku;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Stone::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='stone-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        /**
         * function to display stone stocks
         */
        protected function gridStoneStocks($data, $row){
            $sql = 'SELECT sum(qty) as pos, (select sum(qty) from  `tbl_deptstonelog` where refsent =4 and idstone = '.$data->idstone.' ) as neg FROM `tbl_deptstonelog` where iddept=4 and idstone = '.$data->idstone.'';
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
              if(!empty($rows)){
                    return ($rows[0]['pos']+ $rows[0]['neg']); 
               }
        }
        
        /**
         * function to display duplicate stone
         */
        protected function checkDuplicate($array){
            $model = Stone::model()->findByAttributes(array('idstonem'=>$array['idstonem'], 'idshape'=>$array['idshape'], 'idstonesize'=>$array['idstonesize'], 'color'=>$array['color'], 'quality'=>$array['quality']));
            if(isset($model)){
                return false;
            }else{
                return true;
            }
        }
          public function actionGetstonem(){	      
		$lista=Stonem::model()->findAll(
					array(
					   'select'=>'idstonem, name',
				          'condition'=>"name LIKE '%" .$_GET['q']. "%'"
							     ));         	
				  // echo('<pre>');print_r($lista);die();
					   $reusults = array();
					   foreach ($lista as $list){
					    $reusults[] = array(
						'id'=>$list->idstonem,
						'name'=>  $list->name,
				   ); 
				}
				 
					echo CJSON::encode($reusults);  
             }   
 
          public function actionGetshape(){	      
		$lista=Shape::model()->findAll(
					array(
					   'select'=>'idshape, name',
				          'condition'=>"name LIKE '%" .$_GET['q']. "%'"
							     ));         	
				  // echo('<pre>');print_r($lista);die();
					   $reusults = array();
					   foreach ($lista as $list){
					    $reusults[] = array(
						'id'=>$list->idshape,
						'name'=>  $list->name,
				   ); 
				}
				 
					echo CJSON::encode($reusults);  
             }    
               public function actionGetsize(){	      
		$lista=Stonesize::model()->findAll(
					array(
					   'select'=>'idstonesize, size',
				          'condition'=>"size LIKE '%" .$_GET['q']. "%'"
							     ));         	
				  // echo('<pre>');print_r($lista);die();
					   $reusults = array();
					   foreach ($lista as $list){
					    $reusults[] = array(
						'id'=>$list->idstonesize,
						'size'=>  $list->size,
				   ); 
				}
				 
					echo CJSON::encode($reusults);  
             }    

            /**
             * 
             * Review stone
             * set stone.review  = 1 
             */
             
            public function actionReview() {
                //echo "<pre>";print_r($_POST);die;
                $idstone = $_POST['idstone'];
                $model = Stone::model()->findByPk($idstone);
                if ($model->review == 0)
                    $model->review = 1;
                else
                    $model->review = 0;
                $model->save();
                echo "success";
                Yii::app()->end();
            }

    public function actionGetstone(){	      
		$lista=Stone::model()->findAll(
			array(
				'select'=>'distinct namevar',
				        'condition'=>"trim(namevar) LIKE '%" .$_GET['q']. "%' AND jewelry_type = 2"
			));   	  
			$reusults = array();
			foreach ($lista as $list){
				$reusults[] = array('id'=>  trim($list->namevar),
					'name'=> trim($list->namevar),
				); 
			}
				 
			echo CJSON::encode($reusults);  
    }   
        
        
}
