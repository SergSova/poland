<?php
return [
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'ski4ULCqVRfjk-ChvGIkNVmjWIqJbDE0',
        ],
        'user'       => [
            'identityClass'   => '\backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-frontend',
                'httpOnly' => true
            ],
        ],
        'assetManager' => [
            'bundles' => require(__DIR__.'/assets-prod.php'),
        ],

        'session'    => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/' => 'site/index',
                'service/<id:\d+>' => 'site/service',
                'catalog' => 'site/catalog',
                'technology' => 'site/technology',
                'realty/<id:\d+>' => 'site/realty',
                'video-review' => 'site/video-review'
            ],
        ]

    ],
];
