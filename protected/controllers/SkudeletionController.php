<?php

class SkudeletionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1_new';

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
			array('allow', // allow authenticated user to perform 'delete' actions
				'actions'=>array('index', 'Moveimages'),
                    'users'=>Yii::app()->getModule("user")->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$url = Yii::app()->request->getQuery('skus');
		$filtered_words = array('[', ']');
		$replace = '';
		$url = str_replace($filtered_words, $replace, $url);		
		$ids = explode(',', $url);
		foreach ($ids as $key => $value) {
			if (Sku::model()->exists('idsku=:idsku',array(':idsku'=>$value))){
				$this->removeimage($value);
				$this->removethumb($value);

				$addon=Skuaddon::model()->findAll('idsku=:idsku',array(':idsku'=>$value)); 
				if (!empty($addon)) {
					foreach ($addon as $k => $addons) {
						$addons->delete();
					}
				}

				$invoice=Invoicereturn::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($invoice)) {
					foreach ($invoice as $j => $invoices) {
						$invoices->delete();
					}
				}

				$deptsku=Deptskulog::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($deptsku)) {
					foreach ($deptsku as $m => $Deptskus) {
						$Deptskus->delete();
					}
				}

				$locationstock=Locationstocks::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($locationstock)) {
					foreach ($locationstock as $n => $location) {
						$location->delete();
					}
				}

				$memo=Memosku::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($memo)) {
					foreach ($memo as $o => $memoskus) {
						$memoskus->delete();
					}
				}

				$poskus= Poskus::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($poskus)) {
					foreach ($poskus as $p => $poskus) {
						$poskus->delete();
					}
				}

				$content=Skucontent::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($content)) {
					foreach ($content as $q => $scontent) {
						$scontent->delete();
					}
				}

				$skufinding=Skufindings::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skufinding)) {
					foreach ($skufinding as $r => $finding) {
						$finding->delete();
					}
				}

				$skuimage=Skuimages::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skuimage)) {
					foreach ($skuimage as $s => $image) {
						$image->delete();
					}
				}

				$skumetal=Skumetals::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skumetal)) {
					foreach ($skumetal as $t => $metal) {
						$metal->delete();
					}
				}

				$skustone= Skustones::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skustone)) {
					foreach ($skustone as $u => $stones) {
						$stones->delete();
					}
				}

				$skumap= Skuselmap::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skumap)) {
					foreach ($skumap as $w => $skumaps) {
						$skumaps->delete();
					}
				}

				$skus=Sku::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
				if (!empty($skus)) {
					foreach ($skus as $v => $sku) {
						$sku->delete();
					}
				}
			} else {

			    throw new CHttpException(404,'Skus does not exit.');
			}

		}

		$this->redirect(array('sku/admin'));

	}

	public function removeimage($value){
		$model=new Skuimages;
		$skuimage=Skuimages::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
		foreach ($skuimage as $key => $value) {
			$filename = $value->image;
			$path=realpath(dirname(__FILE__).'/../../');
			unlink($path. '/images/' . Client::getClientImgFolder($model->idclient) . Client::getClientStdImgSize($model->idclient). '/' . $filename);
		}
	}

	public function removethumb($value){
		$skuimage=Skuimages::model()->findAll('idsku=:idsku',array(':idsku'=>$value));
		foreach ($skuimage as $key => $value) {
			$filename = $value->image;
			$path=realpath(dirname(__FILE__).'/../../');
			unlink($path. '/images/' .'thumb'. '/' . $filename);
		}	
	}

	public function actionMoveimages(){
	    $skuimage=Skuimages::model()->findAll();
    	foreach($skuimage as $key => $value){
    		$filename = $value->image;
  			$path=realpath(dirname(__FILE__).'/../../');
  			$client=Client::model()->find('idclient=:idclient',array(':idclient'=>$value->idclient));
  			$filename = $value->image;
  			if (is_null($value->idclient) ){
				$oldpath = $path. '/images/' . '650x650'. '/';
				$newpath = $path. '/images_new/' . '650x650'. '/';
  			} else{
				$oldpath = $path. '/images/' . $client->imgfolder .'/'.$client->stimagesize. '/';
				$newpath = $path. '/images_new/' . $client->imgfolder .'/'.$client->stimagesize. '/';
  			}

		    if (file_exists($oldpath.$filename)) {
		        copy($oldpath.$filename, $newpath.$filename);
	     	}
	     	$this->movethumb($value);

  		}
  		$this->redirect(array('sku/admin'));
	}

	public function movethumb($value){
		$filename = $value->image;
		$path=realpath(dirname(__FILE__).'/../../');
		$client=Client::model()->find('idclient=:idclient',array(':idclient'=>$value->idclient));
		$filename = $value->image;
  		if (is_null($value->idclient) ){
			$oldpath = $path. '/images/' . 'thumb'. '/';
			$newpath = $path. '/images_new/' . 'thumb'. '/';
  		} else{
			$oldpath = $path. '/images/' . $client->imgfolder .'/thumb/';
			$newpath = $path. '/images_new/' . $client->imgfolder .'/thumb/';
  		}

	    if (file_exists($oldpath.$filename)) {
	        copy($oldpath.$filename, $newpath.$filename);
     	}
	}

}