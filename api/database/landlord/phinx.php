<?php declare(strict_types=1);

return [
    'paths' => [
        'migrations' => __DIR__ . '/migrations',
        'seeds' => __DIR__ . '/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'landlord',
        'landlord' => [
            'adapter' => 'mysql',
            'host' => getenv('DATABASE_LANDLORD_HOST') ?? 'localhost',
            'name' => getenv('DATABASE_LANDLORD_NAME') ?? 'mars_landlord',
            'user' => getenv('DATABASE_LANDLORD_NAME') ?? 'mars_landlord',
            'pass' => getenv('DATABASE_LANDLORD_NAME') ?? 'mars_landlord',
            'port' => '3306',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
