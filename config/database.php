<?php return [
    'prod' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=10.214.50.168;port=5432;dbname=mdr_snh_dhab",
            "username" => "usr_websis",
            "password" => "mdr@123"
        ],
    ],
    'homol' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=172.17.18.224;port=5432;dbname=mdr_snh_dhab",
            "username" => "usr_snh_dhab",
            "password" => "mdr@123"
        ],
    ],
    'prod-fab' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=192.168.10.113;port=5432;dbname=sinat",
            "username" => "postgres",
            "password" => "pg01"
        ],
    ],
    'dev' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=192.168.10.113;port=5432;dbname=sinat",
            "username" => "postgres",
            "password" => "pg01"
        ],
    ],
];