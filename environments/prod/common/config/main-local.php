<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=poland',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
            'tablePrefix'=>'pol_',
            'enableQueryCache' => true,
            'enableSchemaCache' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'encryption' => 'tls',
            ],
        ],
    ],
];
