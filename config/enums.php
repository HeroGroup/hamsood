<?php

return [
    'active_days' => [
        '0' => 'امروز',
        '1' => 'فردا',
        '2' => 'پس فردا',
    ],

    'active_until' => [
        1 => 'فعال تا 1 بامداد',
        2 => 'فعال تا 2 بامداد',
        3 => 'فعال تا 3 بامداد',
        4 => 'فعال تا 4 صبح',
        5 => 'فعال تا 5 صبح',
        6 => 'فعال تا 6 صبح',
        7 => 'فعال تا 7 صبح',
        8 => 'فعال تا 8 صبح',
        9 => 'فعال تا 9 صبح',
        10 => 'فعال تا 10 صبح',
        11 => 'فعال تا 11 صبح',
        12 => 'فعال تا 12 ظهر',
        13 => 'فعال تا 1 بعدازظهر',
        14 => 'فعال تا 2 بعدازظهر',
        15 => 'فعال تا 3 بعدازظهر',
        16 => 'فعال تا 4 بعدازظهر',
        17 => 'فعال تا 5 بعدازظهر',
        18 => 'فعال تا 6 بعدازظهر',
        19 => 'فعال تا 7 شب',
        20 => 'فعال تا 8 شب',
        21 => 'فعال تا 9 شب',
        22 => 'فعال تا 10 شب',
        23 => 'فعال تا 11 شب',
        24 => 'فعال تا 12 شب',
    ],

    'active' => [
        0 => 'غیرفعال',
        1 => 'فعال',
    ],

    'order_status' => [
        1 => 'ثبت شد',
        2 => 'ارسال شد',
        3 => 'لغو شده',
        4 => 'لغو توسط کاربر',
        11 => 'پرداخت شد',
    ],

    'payment_method' => [
        1 => 'پرداخت در محل',
        2 => 'پرداخت اینترنتی'
    ],

    'online_payment_methods' => [
        '1' => [
            'name' => 'درگاه pay.ir',
            'icon' => '/images/pay_ir_icon.png',
            'active' => 1,
            'selected' => true
        ],
        '2' => [
            'name' => 'درگاه زرین پال',
            'icon' => '/images/zarinpal_icon.png',
            'active' => 0,
            'selected' => false
        ]
    ],

    'transaction_status' => [
        0 => 'منتظر پرداخت',
    ],

    'transaction_sign' => [
        1 => 'CRED',
        2 => 'DEBT',
    ],

    'transaction_type' => [
        1 => 'افزایش اعتبار کیف پول',
        2 => 'پرداخت سفارش',
    ],

    'yes_no' => [
        0 => 'خیر',
        1 => 'بله'
    ],

    'hours' => [
        8 => '08',
        9 => '09',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => '17',
        18 => '18',
        19 => '19',
        20 => '20',
        21 => '21',
        22 => '22'
    ],

    'gender' => [
        'male' => 'آقا',
        'female' => 'خانم'
    ]

];
