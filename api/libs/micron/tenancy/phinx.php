<?php declare(strict_types=1);

return [
    'paths' => [
        'migrations' => [
            'MicronResearch\\Tenancy\\Migrations' => dirname(__FILE__) . '/src/Migrations'
        ],
        'seeds' => [
            'MicronResearch\\Tenancy\\Seeds' => dirname(__FILE__) . '/src/Seeds'
        ],
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'landlord',
        'landlord' => [
            'adapter' => '%%PHINX_LANDLORD_ADAPTER%%',
            'host' => '%%PHINX_LANDLORD_HOST%%',
            'name' => '%%PHINX_LANDLORD_DATABASE%%',
            'user' => '%%PHINX_LANDLORD_USERNAME%%',
            'pass' => '%%PHINX_LANDLORD_PASSWORD%%',
            'port' => '%%PHINX_LANDLORD_PORT%%',
            'charset' => '%%PHINX_LANDLORD_CHARACTER_SET%%',
        ],
    ],
    'version_order' => 'execution'
];
