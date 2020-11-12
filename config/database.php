<?php return [
    'prod' => [
        'displayErrorDetails' => false,
        "db" => [
            "dsn" => "pgsql:host=172.17.18.224;port=5432;dbname=mdr_snh_dhab",
            "username" => "sys.snh_dhab",
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