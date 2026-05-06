<?php

return [
    'class' => '\yii\symfonymailer\Mailer',
    'useFileTransport' => false,
    'transport' => [
        'scheme' => 'smtps',
        'host' => 'smtp.yandex.ru',
        'username' => 'mail@yandex.ru',
        'password' => 'password',
        'port' => 465,
        'encryption' => 'ssl',
    ],
];
