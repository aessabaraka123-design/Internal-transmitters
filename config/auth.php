<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    'guards' => [

        // حارس المستخدمين العاديين داخل الشركة
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // حارس السوبر أدمن (قاعدة البيانات الرئيسية)
        'super_admin' => [
            'driver'   => 'session',
            'provider' => 'super_admins',
        ],
    ],

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        'super_admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\SuperAdmin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
        'super_admins' => [
            'provider' => 'super_admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
