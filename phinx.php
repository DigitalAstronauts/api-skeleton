<?php

use App\Env;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/.env');

return
[
    'paths' => [
        'migrations' => __DIR__ . '/resources/migrations',
        'entitities' => __DIR__ . '/src/Entity'
    ],
    'entityPrefix' => 'App\Entity',
    'environments' => [
        'default_migration_table' => '_phinxlog',
        'default_environment' => 'production',
        'production' => [
            'adapter' => Env::get('DATABASE_MIGRATION_ADAPTER', 'mysql'),
            'host' => Env::get('DATABASE_HOST', 'mysql'),
            'name' => Env::get('DATABASE_DBNAME', 'micomare_api'),
            'user' => Env::get('DATABASE_USERNAME', 'micomare_api'),
            'pass' => Env::get('DATABASE_PASSWORD', 'mic0M4r3_4PI'),
            'port' => Env::get('DATABASE_PORT', 3306),
            'charset' => Env::get('DATABASE_CHARSET', 'utf8mb4'),
        ],
    ],
    'version_order' => 'creation'
];
