<?php return [
    'prod' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=condado;port=5432;dbname=snh_dhab",
            "username" => "sys.snh_dhab",
            "password" => "#BDsyssnhdh@b#"
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