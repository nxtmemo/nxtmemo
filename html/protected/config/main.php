<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
	),

    /* Application name */
	'name'=>'NXTMemo',

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(

        /* Posts per page */
		'pageSize'=>50,

		/* Nxt token timestamp must not be older than this */
		'tokenMaxAge'=>2628000,//one month

		/*
		 *     Cronjob example
		 *     * * * * * wget http://url-to-nxtmemo.com/cron?key=<cronKey>
		 */
		'cronKey'=>'Put-your-secret-key-here',
		
		/*
		 * NXT options
		 */
		'nxt_prot'=>'http',
		'nxt_host'=>'127.0.0.1',
		'nxt_port'=>'7876', // testnet 6876
		'nxt_account'=>'NXT-XXXX-XXXX-XXXX-XXXXX',
		'nxt_alias'=>'youralias',
		'nxt_token_website'=>'http://yourwebsite.com',
		'nxt_genesistime'=>1385298000, // this is a constant
	),

	// application components
	'components'=>array(
		
		/* Database settinigs */
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=nxtmemo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
				
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
            'caseSensitive'=>false, 
			'rules'=>array(
                'tag/<s>'=>'site/index',
                'acc/<a>'=>'site/index',
                'txid/<t>'=>'site/index',
                'alias/<alias>'=>'site/index',
                'cron'=>'cron/index',
                '/'=>'site/index',
			),
		),
				
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
		
	),
);
