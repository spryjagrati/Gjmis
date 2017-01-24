<?php

class PurchaseOrderController extends Controller
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
				'actions'=>array('maintain','updatePo',
                                    'createItem','updateItem',
                                    'deleteItem','fetchCost','fetchCostDisplay',
                                    'fetchSkuPrice','process','requirements',
                                    'updatePoStatus','updateItemStatus','itemStatusLogs',
                                    'createRequest','updateRequest','deleteRequest',
                                    'admin','export'),
				'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        
	/**
	 * Manages all Skus.
	 */
	public function actionAdmin()
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$model=new Po('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Po']))
			$model->attributes=$_GET['Po'];

		$this->render('admin',array(
			'model'=>$model,
		));
                
	}

        /**
	 * Maintain the PO - register and add items and modify items before it is processed
	 */
	public function actionMaintain($id,$message='')
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$modelpo=Po::model()->findByPk((int)$id);
                $modelposku=new Poskus; $modelposku->idpo=$id;
                $modelsku=new Sku('search');$modelsku->unsetAttributes();

                if(isset($_GET['Sku']))
			$modelsku->attributes=$_GET['Sku'];
                
		$this->render('maintain',array(
			'modelpo'=>$modelpo,'modelposku'=>$modelposku,'modelsku'=>$modelsku,'message'=>$message
		));
                
	}

        /**
	 * Process the PO - Assign to a dept and track status and process numbers - update
	 */
	public function actionProcess($id)
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$modelpo=Po::model()->findByPk((int)$id);

		$this->render('process',array(
			'modelpo'=>$modelpo,
		));
                
	}

        /**
	 * Maintain the PO - register and add items and modify items before it is processed
	 */
	public function actionRequirements($id)
	{
             $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		$modelpo=Po::model()->findByPk((int)$id);
                $modelrequestmetal=new Matreq('metreq'); $modelrequestmetal->idpo=$id;$modelrequestmetal->type='metal';$modelrequestmetal->qunit='gms';
                $modelrequeststone=new Matreq('storeq'); $modelrequeststone->idpo=$id;$modelrequeststone->type='stone';$modelrequeststone->qunit='nos';
                $modelrequestchem=new Matreq('chemreq'); $modelrequestchem->idpo=$id;$modelrequestchem->type='chemical';$modelrequestchem->qunit='ltr';
                $modelrequestfind=new Matreq('findreq'); $modelrequestfind->idpo=$id;$modelrequestfind->type='finding';$modelrequestfind->qunit='nos';

		$this->render('requirements',array(
			'modelpo'=>$modelpo,'modelrequestmetal'=>$modelrequestmetal,
                    'modelrequeststone'=>$modelrequeststone,'modelrequestchem'=>$modelrequestchem,
                    'modelrequestfind'=>$modelrequestfind,
		));
                 
	}

        /**
         * Update PO
         *
         */

        public function actionUpdatePo($id){
                $modelpo=Po::model()->findByPk((int)$id);
		if(isset($_POST['Po']))
		{
			$modelpo->attributes=$_POST['Po'];
			if($modelpo->save()){
                            $modellog=new Postatuslog('insert');
                            $modellog->idpo=$modelpo->idpo;
                            $modellog->idstatusm=$modelpo->idstatusm;
                            $modellog->instructions=$modelpo->instructions;
                            if($modellog->save()){
                                Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' updated successfully');
                            }else{
                                Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' Status log could not be added.');
                            }
                            return $this->renderPartial('_form_po', array('model'=>$modelpo));
                            Yii::app()->end();
                        }
		}

                return $this->renderPartial('_form_po',array('model'=>$modelpo));
        }

        /**
         * Update PO
         *
         */

        public function actionUpdatePoStatus($id){
                $modelpo=Po::model()->findByPk((int)$id);
		if(isset($_POST['Po']))
		{
                        $status=($modelpo->idstatusm!==$_POST['Po']['idstatusm'])?true:false;
			$modelpo->attributes=$_POST['Po'];
			if($modelpo->save()){
                        $modellog=new Postatuslog('insert');
                            if($status){
                                if($modelpo->idstatusm==ComSpry::getDefPoPdStatusm()){
                                    $fdept=ComSpry::getDefPoDept($id);
                                    $tdept=ComSpry::getDefSalesDept();
                                    $pseudoreqs=$this->getPOReqs($id,$fdept,$tdept);
                                    foreach($pseudoreqs as $req){
                                        $this->updateDeptLog($req,false);
                                    }
                                }elseif($modelpo->idstatusm==ComSpry::getDefPoExStatusm()){
                                    $fdept=ComSpry::getDefSalesDept();
                                    $tdept=null;
                                    $pseudoreqs=$this->getPOReqs($id,$fdept,$tdept);
                                    foreach($pseudoreqs as $req){
                                        $this->updateDeptLog($req,false);
                                    }
                                }elseif($modelpo->idstatusm==ComSpry::getDefPoAlocStatusm()){
                                    //TODO: allocated the def manufacturing status to po items
                                    //update poskustatus fields idprocdept and idstatusm
                                    //insert poskustatuslog idposku,reqdqty,processqty,delqty,idprocdept,idstatusm
                                    $procdeptupdated=true;
                                    foreach($modelpo->poskuses as $posku){
                                        $poskustatus=$posku->poskustatus;
                                        $poskustatus->idprocdept=$modelpo->idprocdept;
                                        $procdeptupdated=$poskustatus->save()&&$procdeptupdated;
                                    }
                                    if(!$procdeptupdated)
                                        Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' echo Some item depts are not updated');
                                }
                                $modellog->idpo=$modelpo->idpo;
                                $modellog->idstatusm=$modelpo->idstatusm;
                                $modellog->instructions=$modelpo->instructions;
                                if($modellog->save()){
                                    Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' updated successfully');
                                }else{
                                    Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' Status log could not be added.');
                                }
                            }else{
                                Yii::app()->user->setFlash('po',' Po id '.$modelpo->idpo.' updated successfully. No Status Change.');
                            }
                            return $this->renderPartial('_form_postatus', array('model'=>$modelpo));
                            Yii::app()->end();
                        }
		}

                return $this->renderPartial('_form_postatus',array('model'=>$modelpo));
        }

        private function getPOReqs($id,$fdept,$tdept){
            $reqs=array();
            //metal requests
            $metdata=Po::model()->getDbConnection()->createCommand('select m.idmetal idmetal, m.namevar metal, ms.purity purity, sum(sm.weight*ps.qty) weight
    from tbl_po po, tbl_poskus ps, tbl_metal m, tbl_metalstamp ms, tbl_sku s, tbl_skumetals sm
where m.idmetal=sm.idmetal and m.idmetalstamp=ms.idmetalstamp
and po.idpo=ps.idpo and ps.idsku=s.idsku and s.idsku=sm.idsku and po.idpo='.$id.' group by m.idmetal')->queryAll();
            foreach($metdata as $met){
                $metreq=new Matreq;$metreq->unsetAttributes();
                $metreq->reqby=$tdept;$metreq->reqto=$fdept;
                $metreq->idpo=$id;$metreq->qunit='gms';$metreq->type='metal';
                $metreq->idmetal=$met['idmetal'];$metreq->fqty=$met['weight'];
                $reqs[]=$metreq;
            }
            //stone requests
            $stodata=Po::model()->getDbConnection()->createCommand('select st.idstone idstone, st.namevar stone, sz.size size, sh.name shape, st.quality quality, sc.name clarity, sum(ps.qty*ss.pieces) nos
from tbl_po po, tbl_poskus ps, tbl_stone st, tbl_stonesize sz, tbl_sku s, tbl_skustones ss, tbl_shape sh, tbl_clarity sc
where st.idstone=ss.idstone and st.idshape=sh.idshape and st.idstonesize=sz.idstonesize and st.idclarity=sc.idclarity and po.idpo=ps.idpo
and ps.idsku=s.idsku and s.idsku=ss.idsku and po.idpo='.$id.' group by st.idstone')->queryAll();
            foreach($stodata as $sto){
                $storeq=new Matreq;$storeq->unsetAttributes();
                $storeq->reqby=$tdept;$storeq->reqto=$fdept;
                $storeq->idpo=$id;$storeq->type='stone';
                $storeq->idstone=$sto['idstone'];$storeq->fqty=$sto['nos'];
                $reqs[]=$storeq;
            }
            //finding requests
            $finddata=Po::model()->getDbConnection()->createCommand('select f.idfinding idfind, sf.name name, m.namevar metal, f.name code, sum(ps.qty*sf.qty) qty
from tbl_po po, tbl_poskus ps, tbl_finding f, tbl_metal m, tbl_sku s, tbl_skufindings sf
where po.idpo=ps.idpo and ps.idsku=s.idsku and s.idsku=sf.idsku and f.idfinding=sf.idfinding and f.idmetal=m.idmetal
and po.idpo='.$id.' group by f.idfinding')->queryAll();
            foreach($finddata as $find){
                $findreq=new Matreq;$findreq->unsetAttributes();
                $findreq->reqby=$tdept;$findreq->reqto=$fdept;
                $findreq->idpo=$id;$findreq->type='finding';
                $findreq->idfinding=$find['idfind'];$findreq->fqty=$find['qty'];
                $reqs[]=$findreq;
            }
            return $reqs;
        }

        public function actionCreateItem($id){
                $modelposku=new Poskus;
                $modelposku->idpo=$id;
		if(isset($_POST['Poskus']))
		{
			$modelposku->attributes=$_POST['Poskus'];
                        if(!$modelposku->validate()){
                            Yii::app()->user->setFlash('posku','check po item errors');
                            $this->redirect(array('purchaseOrder/maintain/'.$modelposku->idpo));
                        }
                        $modelposku->totamt=$this->calcItemPrice($modelposku);
                        $moredata=$this->staticdata($modelposku->idpo,$modelposku->idsku);
                        $modelposku->custsku=$moredata['ccode'];
                        if($modelposku->appmetwt==0)
                            $modelposku->appmetwt=$moredata['appmetwt'];
                        $modelposku->descrip=Skucontent::model()->find('idsku=:idsku',array(':idsku'=>$modelposku->idsku))->name;
                        $modelposku->itemtype=$moredata['type'];
                        $modelposku->itemmetal=$moredata['metal'];
                       // $modelposku->metalstamp=$moredata['metalstamp'];
			if($modelposku->save()){
                            Yii::app()->user->setFlash('posku','Posku (item) '.$modelposku->idposkus.' created successfully');
                            //update po totamt
                            $sumamt=$modelposku->getDbConnection()->createCommand('select sum(totamt) as sumamt from {{poskus}} where idpo='.$modelposku->idpo)->queryScalar();
                            $modelpo=Po::model()->findByPk($modelposku->idpo);
                            $modelpo->totamt=0+$sumamt;
                            $modelpo->save();

                            $modelstatus=new Poskustatus('insert');
                            $modelstatus->idposku=$modelposku->idposkus;
                            $modelstatus->reqdqty=$modelposku->qty;
                            $modelstatus->idstatusm=ComSpry::getDefItemStatusm();
                            $modelstatus->idprocdept=ComSpry::getDefProcDept();$modelstatus->processqty=0;$modelstatus->delqty=0;
                            $modelstatus->save();

                            $modelposku->unsetAttributes(); $modelposku->idpo=$id;

                            $this->redirect(array('purchaseOrder/maintain/'.$modelposku->idpo));
                            /*
                            return $this->renderPartial('_form_sku', array('model'=>$modelposku));
                            Yii::app()->end();
                             *
                             */
                        }
		}

                return $this->renderPartial('_form_sku',array('model'=>$modelposku));
                Yii::app()->end();
        }

        public function actionDeleteItem($id)
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			Poskus::model()->findByPk($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('maintain','id'=>Poskus::model()->findByPk($id)->idpo));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                
	}

        public function actionUpdateItem($id)
	{
		$modelposku=Poskus::model()->findByPk($id);
                $suggprice=$this->calcItemPrice($modelposku);
		if(isset($_POST['Poskus']))
		{
			$modelposku->attributes=$_POST['Poskus'];
                        $modelposku->totamt=$this->calcItemPrice($modelposku);
                        $moredata=$this->staticdata($modelposku->idpo,$modelposku->idsku);
                        $modelposku->custsku=$moredata['ccode'];
                        if($modelposku->appmetwt==0)
                            $modelposku->appmetwt=$moredata['appmetwt'];
                        $modelposku->itemtype=$moredata['type'];
                        $modelposku->itemmetal=$moredata['metal'];
                      //  $modelposku->metalstamp=$moredata['metalstamp'];
			if($modelposku->save()){
                            $sumamt=$modelposku->getDbConnection()->createCommand('select sum(totamt) as sumamt from {{poskus}} where idpo='.$modelposku->idpo)->queryScalar();
                            $modelpo=Po::model()->findByPk($modelposku->idpo);
                            $modelpo->totamt=0+$sumamt;
                            $modelpo->save();
                            echo 'Posku (item) '.$modelposku->idposkus.' updated successfully';
                        }else{
                            echo 'Posku (item) '.$modelposku->idposkus.' could not be updated at this time, please remodify';
                        }
		}else{
                    $this->renderPartial('updateItem', array('model'=>$modelposku,'suggprice'=>$suggprice),false,true);
                }
	}

        public function actionUpdateItemStatus($id)
	{
		$modelposku=Poskus::model()->findByPk($id);
                $modelstatus=Poskustatus::model()->find('idposku=:idposku', array(':idposku'=>$id));
		if(isset($_POST['Poskus'])&&isset($_POST['Poskustatus']))
		{
			$modelposku->remark=$_POST['Poskus']['remark'];
			//$modelposku->descrip=$_POST['Poskus']['descrip'];
			if($modelposku->save()){
                            //save the poskustatus data
                            $modelstatus->processqty=$_POST['Poskustatus']['processqty'];
                            $modelstatus->delqty=$_POST['Poskustatus']['delqty'];
                            $modelstatus->idstatusm=$_POST['Poskustatus']['idstatusm'];
                            $modelstatus->grosswt=$_POST['Poskustatus']['grosswt'];
                            if(isset($_POST['Poskustatus']['idprocdept'])&&$_POST['Poskustatus']['idprocdept']!=='')
                                $modelstatus->idprocdept=$_POST['Poskustatus']['idprocdept'];
                            if(isset($_POST['Poskustatus']['rcvddate'])&&$_POST['Poskustatus']['rcvddate']!=='')
                                $modelstatus->rcvddate=$_POST['Poskustatus']['rcvddate'];
                            if(isset($_POST['Poskustatus']['dlvddate'])&&$_POST['Poskustatus']['dlvddate']!=='')
                                $modelstatus->dlvddate=$_POST['Poskustatus']['dlvddate'];
                            if($modelstatus->save()){
                                echo 'Posku (item) status updated successfully';
                                //save the log
                                $modellog=new Poskustatuslog('insert');
                                $modellog->idposku=$modelstatus->idposku;
                                $modellog->reqdqty=$modelstatus->reqdqty;
                                $modellog->processqty=$modelstatus->processqty;
                                $modellog->delqty=$modelstatus->delqty;
                                $modellog->idprocdept=$modelstatus->idprocdept;
                                $modellog->rcvddate=$modelstatus->rcvddate;
                                $modellog->dlvddate=$modelstatus->dlvddate;
                                $modellog->idstatusm=$modelstatus->idstatusm;
                                $modellog->grosswt=$modelstatus->grosswt;
                                $modellog->remark=$modelposku->remark;
                                $modellog->descrip=$modelposku->descrip;
                                if($modellog->save())
                                    echo '. Status update log saved successfully';
                                else
                                    echo '. Status update log was not saved';
                            }else{
                                echo 'Posku (item) status could not be updated. remarks saved.';
                            }
                        }else{
                            echo 'Posku (item) '.$id.' could not be updated at this time, please remodify';
                        }
		}else{
                    $this->renderPartial('updateItemStatus', array('model'=>$modelposku,'modelstatus'=>$modelstatus),false,true);
                }
	}

        public function actionCreateRequest($id){
            $model='';
                switch ($_POST['Matreq']['type']) {
                    case 'metal':
                        $model=new Matreq('metreq');break;
                    case 'stone':
                        $model=new Matreq('storeq');break;
                    case 'chemical':
                        $model=new Matreq('chemreq');break;
                    case 'finding':
                        $model=new Matreq('findreq');break;
                }
                $model->idpo=$id;
		if(isset($_POST['Matreq']))
		{
			$model->attributes=$_POST['Matreq'];
                        $model->sdate=date('Y-m-d H:i:s');$model->estdate=date('Y-m-d',mktime(0, 0, 0, date("m"), date("d"), date("y"))+86400);
                        $model->idstatusm=ComSpry::getDefReqStatusm();
			if($model->save()){
                            Yii::app()->user->setFlash('matreq','Request '.$model->idmatreq.' created successfully');
                            $modellog=new Matreqlog('insert');
                            $modellog->idmatreq=$model->idmatreq;
                            $modellog->rqty=$model->rqty;
                            $modellog->fqty=$model->fqty;
                            $modellog->idstatusm=$model->idstatusm;
                            $modellog->save();
                            switch($model->type){
                                case 'metal':
                                    $model=new matreq('metreq');
                                case 'stone':
                                    $model=new matreq('storeq');
                                case 'chemical':
                                    $model=new matreq('chemreq');
                                case 'finding':
                                    $model=new matreq('findreq');
                            }
                            $model->idpo=$id;$model->type=$_POST['Matreq']['type'];$model->qunit=$_POST['Matreq']['qunit'];
                        }
		}
                switch ($_POST['Matreq']['type']) {
                    case 'metal':
                        $this->renderPartial('_form_request_metal',array('model'=>$model));break;
                    case 'stone':
                        $this->renderPartial('_form_request_stone',array('model'=>$model));break;
                    case 'chemical':
                        $this->renderPartial('_form_request_chem',array('model'=>$model));break;
                    case 'finding':
                        $this->renderPartial('_form_request_find',array('model'=>$model));break;
                }
                Yii::app()->end();
        }

        public function actionDeleteRequest($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			Matreq::model()->findByPk($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('requirements','id'=>Matreq::model()->findByPk($id)->idpo));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

        public function actionUpdateRequest($id){
                $model=Matreq::model()->findByPk($id);;
		if(isset($_POST['Matreq']))
		{
			$model->fqty=$_POST['Matreq']['fqty'];$model->notes=$_POST['Matreq']['notes'];
                        $model->edate=date('Y-m-d H:i:s');
                        $model->idstatusm=ComSpry::getDefReqffStatusm();
			if($model->save()){
                            // insert the dept material logs
                            $this->updateDeptLog($model);

                            $modellog=new Matreqlog('insert');
                            $modellog->idmatreq=$model->idmatreq;
                            $modellog->rqty=$model->rqty;
                            $modellog->fqty=$model->fqty;
                            $modellog->idstatusm=$model->idstatusm;
                            $modellog->save();
                            echo 'Request updated successfully';
                        }else{
                            echo 'Request could not be updated, please check the issues with administrator';
                        }
		}else{
                    return $this->renderPartial('updateRequest',array('model'=>$model),false,true);
                }
                Yii::app()->end();
        }

        protected function updateDeptLog($model,$echo=true){
            $modellog1='';$modellog2='';
            switch ($model->type) {
                case 'metal':
                    $modellog1=new Deptmetallog('insert');$modellog1->idmetal=$model->idmetal;
                    $modellog2=new Deptmetallog('insert');$modellog2->idmetal=$model->idmetal;
                    break;
                case 'stone':
                    $modellog1=new Deptstonelog('insert');$modellog1->idstone=$model->idstone;
                    $modellog2=new Deptstonelog('insert');$modellog2->idstone=$model->idstone;
                    break;
                case 'chemical':
                    $modellog1=new Deptchemlog('insert');$modellog1->idchemical=$model->idchemical;
                    $modellog2=new Deptchemlog('insert');$modellog2->idchemical=$model->idchemical;
                    break;
                case 'finding':
                    $modellog1=new Deptfindlog('insert');$modellog1->idfinding=$model->idfinding;
                    $modellog2=new Deptfindlog('insert');$modellog2->idfinding=$model->idfinding;
                    break;
            }
            $modellog1->qty=(1)*$model->fqty;$modellog2->qty=(-1)*$model->fqty;
            $modellog1->idpo=$model->idpo;$modellog2->idpo=$model->idpo;
            if($model->type=='metal' || $model->type=='chemical'){
                $modellog1->cunit=$model->qunit;$modellog2->cunit=$model->qunit;
            }
            //assign departments respectively
            $modellog1->iddept=$model->reqby;$modellog2->iddept=$model->reqto;
            $modellog1->refrcvd=$model->reqto;$modellog2->refsent=$model->reqby;

            if($modellog1->save()&&$modellog2->save()){
                if($echo)
                    echo 'Department material log updated successfully\n';return true;
            }else{
                print_r($modellog1);print_r($modellog2);
                if($echo)
                    echo 'Department material log could not be updated\n';return false;
            }
        }

	/**
	 * Display Item Status logs.
	 */
	public function actionItemStatusLogs($id)
	{
            $model=Poskus::model()->findByPk($id);
            $this->renderPartial('itemStatusLogs',array('model'=>$model),false,true);
	}

        public function actionFetchCost($id){
            $cost=0;
            if(!is_null($id) && $id!=='' &&$id!==0){
                $skus=Poskus::model()->findAllByAttributes(array('idpo'=>$id));
                if($skus!=='')
                foreach($skus as $posku){
                    $cost+=$this->calcItemPrice($posku);
                }
            }
            echo $cost;
            Yii::app()->end();
        }

        public function actionFetchCostDisplay($id){
            $cost=0;
            if(!is_null($id) && $id!=='' &&$id!==0){
                $skus=Poskus::model()->findAllByAttributes(array('idpo'=>$id));
                if($skus!=='')
                foreach($skus as $posku){
                    $cost+=$this->calcItemPrice($posku);
                }
            }
            echo 'Cost for po id '.$id.' is = $'.$cost;
            Yii::app()->end();
        }

        public function calcItemPrice($model){
            $price=0;
            if($model->validate()){
                $idsku=$model->idsku;
                $cost=ComSpry::calcSkuCost($idsku);
                $idpo=$model->idpo;
                $client=Po::model()->findByPk($idpo)->idclient;
                $comm=Client::model()->findByPk($client)->commission;
                $qty=$model->qty;
                $price=$cost*(100+$comm)/100*$qty;
            }
            return $price;
        }

        public function fetchItemPrice($id){
            $price=0;
            if(!is_null($id) && $id!=='' &&$id!==0){
                $idsku=Poskus::model()->findByPk($id)->idsku;
                $cost=ComSpry::calcSkuCost($idsku);
                $idpo=Poskus::model()->findByPk($id)->idpo;
                $client=Po::model()->findByPk($idpo)->idclient;
                $comm=Client::model()->findByPk($client)->commission;
                $qty=Poskus::model()->findByPk($id)->qty;
                $price=$cost*(100+$comm)/100*$qty;
            }
            return $price;
        }

        public function actionFetchItemPriceDisplay($id){
            $price=$this->fetchItemPrice($id);
            echo 'Price for item id '.$id.' is = $'.$price;
            Yii::app()->end();
        }

        public function staticdata($idpo, $idsku){
            //custsku, appmetwt, itemtype, itemmetal, metalstamp
            $idclient=Po::model()->findByPk($idpo)->idclient;
            $ccode=Sku::model()->getDbConnection()->createCommand('select clientcode from {{skuselmap}} where idsku='.$idsku.' and idclient='.$idclient)->queryScalar();
            $type=Sku::model()->getDbConnection()->createCommand('select type from {{skucontent}} where idsku='.$idsku)->queryScalar();
            $metal=Sku::model()->getDbConnection()->createCommand('select m.namevar from {{metal}} m, {{skumetals}} sm where sm.idmetal=m.idmetal and sm.idsku='.$idsku)->queryScalar();
            $metalstamp=Sku::model()->getDbConnection()->createCommand('select name from {{metalstamp}} ms, {{metal}} m, {{skumetals}} sm where sm.idmetal=m.idmetal and m.idmetalstamp=ms.idmetalstamp and sm.idsku='.$idsku)->queryScalar();
            $appmetwt=Sku::model()->getDbConnection()->createCommand('select totmetalwei from {{sku}} where idsku='.$idsku)->queryScalar();
            $stadata=array('ccode'=>$ccode,'type'=>$type,'metal'=>$metal,'metalstamp'=>$metalstamp,'appmetwt'=>$appmetwt);
            return $stadata;
        }
/*
        public function actionFetchSkuPrice($idsku,$idpo){
            $cost=0;
            if(!is_null($idsku) && $idsku!=='' &&$idsku!==0){
                $cost=ComSpry::calcSkuCost($idsku);
            }
            $client=Po::model()->findByPk($idpo)->idclient;
            $comm=Client::model()->findByPk($client)->commission;
            echo $cost*(100+$comm)/100;
            Yii::app()->end();
        }
 *
 */

        public function actionExport($id)
	{
            $uid = Yii::app()->user->getId(); 
            if($uid != 1){
                $value = ComSpry::getUnserilizedata($uid);
                if(empty($value) || !isset($value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
                if(!in_array(11, $value)){
                    throw new CHttpException(403,'You are not authorized to perform this action.');
                }
            }
            $modelpo=Po::model()->findByPk((int)$id);
                $poskus = $modelpo->poskuses;
		
                $i = 0;
               foreach($poskus as $posku)
                {
                    $i++;
                    $skustones = $posku->idsku0->skustones;
                    $stones = array();
                foreach ($skustones as $skustone){
                $stones[]=array('pieces'=>$skustone->pieces,
                'shape'=>trim($skustone->idstone0->idshape0->name),'size'=>trim($skustone->idstone0->idstonesize0->size),
                'name'=>trim($skustone->idstone0->namevar), 'reviews'=>$skustone->reviews);
                }
                  $sku[] = array( 'gjno' => $posku->idsku0->skucode, 'Price' => $posku->totamt, 'Code' => $posku->idsku0->skucode,
                  'Ref' => $posku->refno, 'Order' => $posku->reforder, 'Cust' => $posku->custsku,
                  'AppMetalWt' => $posku->appmetwt, 'Item'=> $posku->itemtype, 'Metal' => $posku->itemmetal,
                  'US' => $posku->usnum, 'Description' => $posku->descrip,'Qty'=> $posku->qty,
                  'Ext' =>$posku->ext,'Remark'=>$posku->remark,'Stamp' =>$posku->metalstamp0->name, 'Stone' => $stones);


                }
		 
				


                // get a reference to the path of PHPExcel classes
                $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');


                // Turn off our amazing library autoload
                spl_autoload_unregister(array('YiiBase','autoload'));

                 //
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

                 // PO Export

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Purchase Order #'.$id)
                ->setCellValue('M1', date("F j, Y"))
                ->setCellValue('A2', 'S. No.')
                ->setCellValue('B2', 'GJ No.')
                ->setCellValue('C2', 'Price')
                ->setCellValue('D2', 'Code')
                ->setCellValue('E2', 'Ref#')
                ->setCellValue('F2', 'Order#')
                ->setCellValue('G2', 'Cust#')
                ->setCellValue('H2', 'App. Metal Wt.')
                ->setCellValue('I2', 'Item')
                ->setCellValue('J2', 'Metal')
                ->setCellValue('K2', 'US#')
                ->setCellValue('L2', 'Description')
                ->setCellValue('M2', 'Product Remarks')
                ->setCellValue('N2', 'Qty')
                ->setCellValue('O2', 'Ext')
                ->setCellValue('P2', 'Remark')
                ->setCellValue('Q2', 'Stamp');


                $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($i+5).':Q'.($i+5))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->freezePane('A2');
                $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2, 1);


                for($k=3 ; $k <= $i+2; $k++){
                $skustones = '';  
                foreach($sku[$k-3]['Stone'] as $skustone){
                    $skustones .= ' '.$skustone['name'].' '.$skustone['shape'].' '.$skustone['size'].' - '.$skustone['pieces'].'Pcs +';
                    
                }
                if($skustones == ""){$skustone = "  ";}else{$skustone = substr($skustones, 0, -1);}
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$k, $k-2)
                ->setCellValue('B'.$k, $sku[$k-3]['gjno'])
                ->setCellValue('C'.$k, round(($sku[$k-3]['Price']/$sku[$k-3]['Qty']),2))
                ->setCellValue('D'.$k, $sku[$k-3]['Code'])
                ->setCellValue('E'.$k, $sku[$k-3]['Ref'])
                ->setCellValue('F'.$k, $sku[$k-3]['Order'])
                ->setCellValue('G'.$k, $sku[$k-3]['Cust'])
                ->setCellValue('H'.$k, $sku[$k-3]['AppMetalWt'])
                ->setCellValue('I'.$k, $sku[$k-3]['Item'])
                ->setCellValue('J'.$k, $sku[$k-3]['Metal'])
                ->setCellValue('K'.$k, $sku[$k-3]['US'])
                ->setCellValue('L'.$k, $skustone)
                ->setCellValue('M'.$k, $sku[$k-3]['Stone'][0]['reviews'])
                ->setCellValue('N'.$k, $sku[$k-3]['Qty'])
                ->setCellValue('O'.$k, $sku[$k-3]['Ext'])
                ->setCellValue('P'.$k, $sku[$k-3]['Remark'])
                ->setCellValue('Q'.$k, $sku[$k-3]['Stamp']);

                }
                $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('M'.($i+5), 'Total Qty')
                ->setCellValue('N'.($i+5), '=SUM(N3:N'.($i+3).')');

                $styleThickBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THICK,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleThickBorderOutline);

                 $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('argb' => 'FF000000'),

                    ),
                ),
                );

                  for($k=3 ; $k <= $i+2; $k++){
                  
                      $objPHPExcel->getActiveSheet()->getStyle('A'.$k.':Q'.$k)->applyFromArray($styleThinBlackBorderOutline);
                  }


                // Rename sheet
                $objPHPExcel->getActiveSheet()->setTitle('Purchase Order');

                // Set active sheet index to the first sheet,
                // so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);

                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/xlsx');
                header('Content-Disposition: attachment;filename="PO.xlsx"');
                header('Cache-Control: max-age=0');


                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');


                // Once we have finished using the library, give back the
                // power to Yii...
                spl_autoload_register(array('YiiBase','autoload'));


                Yii::app()->end();


                

	}
}
