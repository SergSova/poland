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
        'session'    => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/'               => 'site/index',
                'catalog'         => 'site/catalog',
                'realty/<id:\d+>' => 'site/realty',
                'video-review'    => 'site/video-review'
            ],
        ]

    ],
];
