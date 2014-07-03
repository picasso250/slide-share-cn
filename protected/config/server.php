<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(

	// application components
	'components'=>array(

		'db'=>array(
			'connectionString' => 'mysql:host='.SAE_MYSQL_HOST_M.';dbname='.SAE_MYSQL_DB.';port='.SAE_MYSQL_PORT,
			'emulatePrepare' => true,
			'username' => SAE_MYSQL_USER,
			'password' => SAE_MYSQL_PASS,
			'charset' => 'utf8',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'cumt.xiaochi@gmail.com',
        'upload_root' => dirname(dirname(__DIR__)).'/assets/upload',
        'upload_url' => '/assets/upload',
	),
);