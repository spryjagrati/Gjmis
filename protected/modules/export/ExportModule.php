<?php

class ExportModule extends CWebModule
{



	public $exportUrl = array("/export/skuexport?type=skuexport");
	public $masterUrl = array("/export/skuexport?type=master");

       public function __call($name, $args)
       {
    $reflect  = new ReflectionClass($name);
    $instance = $reflect->newInstanceArgs($args);
    return $instance;
     }
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'export.models.*',
			'export.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}

