<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Gallant MIS',
        'timeZone' => 'Asia/Calcutta',
	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.validators.*',
                'application.modules.user.models.*',
                'application.modules.user.components.*',
                'application.extensions.*',
                'application.modules.rights.components.*',
	),

	'modules'=>array(
            'user',
             'export',
		
	    	'importcsv'=>array(
                        'path'=>'upload/importCsv/', // path to folder for saving csv file and file with import params
                ),

		// uncomment the following to enable the Gii tool
		
	    	'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'spry',
		),

/* ambitious
            'rights'=>array(
                //'install'=>true, // Enables the installer.
            ),

            'comspry',
*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
                        //'class'=>'RightsWebUser',
			'allowAutoLogin'=>true,
                        'loginUrl' => array('/user/login'),
		),
/*
            'authManager'=>array(
                'class'=>'RightsAuthManager',
            ),
*/
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                            'gii'=>'gii',
                            'gii/<controller:nw+>'=>'gii/<controller>',
                            'gii/<controller:nw+>/<action:nw+>'=>'gii/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
            /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
             */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=gmis',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '1234',
			'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
			'schemaCachingDuration' => 86400,
			'enableProfiling' => true, 'enableParamLogging' => true,
		),
		

        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ), 
            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
                    'errorAction'=>'site/error',
                ),
            
		'log'=>array(
                    'class'=>'CLogRouter',
                    'routes'=>array(
                        array(
                            'class'=>'CFileLogRoute',
                            'levels'=>'error, warning',
                        ),
                        array(
                            'class'=>'CWebLogRoute',
                        ),
                    ),
		),
        'mailer' => array(
                'class' => 'application.extensions.mailer.EMailer',
                'pathViews' => 'application.views.email',
                'pathLayouts' => 'application.views.email.layouts'
            ),

            'thumb'=>array(
                'class'=>'ext.phpthumb.EasyPhpThumb',
            ),

            'comspry'=>array(
                'class'=>'ComSpry'
            ),

        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params'=> array(
                'mpdf'     => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                    'constants'         => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class'=>'mpdf',
                )   
            ) 
        ),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'contact@sprytechies.com',
            'sprypowered'=>'Powered by <a href="http://www.sprytechies.com/" rel="external">Spry Techies</a>.',
            'defitemstatus'=>3,
            'defpostatus'=>1,
            'defprocdept'=>3,
            'defreqstatus'=>5,
            'defreqffstatusm'=>6,
            'defpopdstatusm'=>8,
            'defpoexstatusm'=>9,
            'defpoalocstatusm'=>4,
            'defsalesdept'=>3,
            //'imgFolder'=>'E:/html/gmis/images/',
	),
);
