<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'gii', 'debug'],
    'aliases' => [
    	'@mdm/admin' => __DIR__ . '/../../vendor/yii2-admin',
    ],
    'modules' => [
		'manage' => [
			'class' => 'mdm\admin\Module',
			 
			'layout' => 'left-menu', // it can be '@path/to/your/layout'.
			/**/
			'controllerMap' => [
				'assignment' => [
				'class' => 'mdm\admin\controllers\AssignmentController',
				'userClassName' => 'common\models\User',
				'idField' => 'id'
				]
			],
			'menus' => [
				'assignment' => [
				'label' => 'Grand Access' // change label
				],
				//'route' => null, // disable menu route
			]
    	],
	'gii' => [
    		'class' => 'yii\gii\Module',
    		'allowedIPs' => ['*'] // adjust this to your needs
	],
	'debug' => [
        	'class' => 'yii\debug\Module',
        	'allowedIPs' => ['*']
    	]
    ],
    'components' => [
	'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
	'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
	'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
