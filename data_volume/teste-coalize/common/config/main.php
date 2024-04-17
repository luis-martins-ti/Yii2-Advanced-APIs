<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User', // Adicione a propriedade 'class' aqui
            'identityClass' => 'common\models\User', // Classe de identidade de usuário
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => '3f4dab80b7e9c72185ae14e7e0a8bc2f1f56fb9f0ac8f2c880f80cf670abeb9a', // Chave secreta para assinar o token
        ],
        'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'], // Permitir solicitações de qualquer origem
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'], // Métodos permitidos
                'Access-Control-Request-Headers' => ['*'], // Cabeçalhos permitidos
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'login'],
                'backend/web/client' => 'client/index',
                'backend/web/client/create' => 'client/create',
                'backend/web/product' => 'product/index',
                'backend/web/product/create' => 'product/create',
            ],
        ],
    ],
    'controllerMap' => [
        'create-user' => 'console\controllers\CreateUserController',
    ],
    'params' => [
        'isConsole' => php_sapi_name() == 'cli', // Verifica se a aplicação está sendo executada no contexto do console
    ],
    'as jwtAuth' => [
        'class' => 'common\components\JwtAuth',
        'only' => ['client/index', 'client/create', 'product/index', 'product/create'], // Aplicar apenas a essas ações
    ],
];
