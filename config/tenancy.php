<?php

declare(strict_types=1);

use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\ImpersonationToken;

return [
'central_domains' => [
    '127.0.0.1',
    'localhost',
],
    'tenant_model' => Tenant::class,

    'id_generator' => Stancl\Tenancy\UUIDGenerator::class,

    'domain_model' => Stancl\Tenancy\Database\Models\Domain::class,

    /**
     * ميزات الـ Tenancy المفعّلة
     */
    'features' => [
        // Stancl\Tenancy\Features\UserImpersonation::class,
        // Stancl\Tenancy\Features\TelescopeTags::class,
        // Stancl\Tenancy\Features\UniversalRoutes::class,
        // Stancl\Tenancy\Features\TenantConfig::class,
        // Stancl\Tenancy\Features\CrossDomainRedirect::class,
        // Stancl\Tenancy\Features\ViaHttp::class,
    ],

    'bootstrappers' => [
        Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\QueueTenancyBootstrapper::class,
    ],

    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),

        'template_tenant_connection' => null,

        /**
         * اسم قاعدة بيانات كل شركة: tenant_{id}
         */
        'prefix' => 'tenant_',
        'suffix' => '',

'managers' => [
    'sqlite' => Stancl\Tenancy\TenantDatabaseManagers\SQLiteDatabaseManager::class,
    'mysql'  => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
    'pgsql'  => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLDatabaseManager::class,
    'sqlsrv' => Stancl\Tenancy\TenantDatabaseManagers\MySQLDatabaseManager::class,
],
    ],

    'cache' => [
        'tag' => 'tenancy',
    ],

    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
            // 's3',
        ],
        'root_override' => [
            'local'  => '%storage_path%/app/',
            'public' => '%storage_path%/app/public/',
        ],
    ],

    'redis' => [
        'prefix_base' => 'tenant',
        'prefixed_connections' => [
            // 'default',
        ],
    ],

    'migration_parameters' => [
        '--force'                => true,
        '--path'                 => [database_path('migrations/tenant')],
        '--realpath'             => true,
    ],

    'seeder_parameters' => [
        '--class' => 'TenantDatabaseSeeder',
        '--force' => true,
    ],
];
