<?php
return [
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => 'ZT-hrNySDDOQRVHMyvWu6oS6OAcbwHse'
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],

    ],
];
