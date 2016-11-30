<?php

return [


    'driver' => 'smtp',
    'host' => 'smtp.mailtrap.io',
    'port' => '25',
    'from' => [
        'address' => 'hello@example.com',
        'name' => 'Example',
    ],
    'encryption' => 'tls',
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',

];
