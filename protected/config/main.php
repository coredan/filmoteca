<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Filmoteca',
	'defaultController' => 'user/login',

	// preloading 'log' component
	'preload'=>array('log'),

	// default language
	'language' => 'es',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',		
		'ext.giix-components.*', // giix components
		'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.libs.*',
	),

	'modules'=>array(
		// comment the following to disable the Gii tool		
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password'=>'1q2w3e',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','193.145.124.84','213.231.115.146', "192.168.1.*"),
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
			),
		),
        'user'=>array(
				
			// enable cookie-based authentication
			/*'allowAutoLogin'=>true,*/

            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => false,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/films/index'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),

            'tableUsers' => 'tbl_users',
            'tableProfiles' => 'tbl_profiles',
            'tableProfileFields' => 'tbl_profiles_fields',   
            'sendActivationMail' => true,  
        ),       
	),

	// application components
	'components'=>array(
		
		'CustomHelper' => array(
            'class' => 'application.components.CustomHelper',
        ),
		// 'user'=>array(
		// 	// enable cookie-based authentication
		// 	'allowAutoLogin'=>true,
		// 	'class' => 'WebUser',
		// 	'loginUrl' => array('/user/login'),
		// ),
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'class' => 'WebUser',
            'loginUrl' => array('/user/login'),
        ),
		//comment the following to disable URLs in path-format
		'urlManager'=>array(
			//'caseSensitive'=>false,			
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(				
		        //array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
		        array('api/create', 'pattern'=>'api/<model:\w+>', 'verb'=>'POST'),
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			
		),		
		// MySQL database		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=filmotecadb',
			'username' => 'root',
			'password' => 'H1dr0c3f4l0#',

			'emulatePrepare' => true,
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		// Explotacion
		// 'db'=>array(
		// 	'connectionString' => 'mysql:host=localhost;dbname=id3971552_filmotecadb',
		// 	'username' => 'id3971552_danmaster',
		// 	'password' => 'H1p0gr1f0#',
			
		// 	'emulatePrepare' => true,
		// 	'charset' => 'utf8',
		// 	'tablePrefix' => 'tbl_',
		// ),
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
        /*'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
        ),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
        'enableDownloads'=>TRUE,
		'adminEmail'=>'webmaster@example.com',
		'iSupportEmail'=>'coredan@gmail.com',
		'dateFormat'=>'d/m/Y'
	),
);