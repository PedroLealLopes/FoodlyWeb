<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/restaurants',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET location/{cidade}' => 'location',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{cidade}' => '<cidade:\\w+>',
                    ],
                ], 
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/profiles',
                    'pluralize' => false,
                ], 
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/users',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ], 
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/orders',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                        'GET client/{id}' => 'client',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/menus',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                        'GET restaurant/{id}' => 'restaurant',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/profiles',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/dishes',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                        'GET restaurant/{id}' => 'restaurant',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ], 
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/restaurant-reviews',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                        'GET restaurant/{id}' => 'restaurant',
                        'GET user/{id}' => 'user',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'api/profile-restaurant-favorites',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET total' => 'total',
                        'GET user/{id}' => 'user',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
