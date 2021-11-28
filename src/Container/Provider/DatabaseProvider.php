<?php
declare(strict_types=1);

namespace App\Container\Provider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use App\Env;
use Nette\Caching\Storages\FileStorage;
use Nette\Caching\Storages\MemoryStorage;
use Nette\Database\Connection;
use Nette\Database\Explorer;
use Nette\Database\Structure;
use Warp\EntityManager;

class DatabaseProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $map = [
            EntityManager::class,
            Explorer::class,
            Connection::class,
        ];
        return in_array($id, $map);
    }

    public function register(): void
    {
        $this->getContainer()->addShared(
            Connection::class,
            fn() => new Connection(
                Env::get('DATABASE_DSN', 'mysql:host=mysql;dbname=micomare_api;charset=utf8'),
                Env::get('DATABASE_USERNAME', 'micomare_api'),
                Env::get('DATABASE_PASSWORD', 'mic0M4r3_4PI'),
            )
        );
        $this->getContainer()->addShared(
            Explorer::class,
            fn() => new Explorer(
                $this->getContainer()->get(Connection::class),
                new Structure(
                    $this->getContainer()->get(Connection::class),
                    new FileStorage(
                        $this->getContainer()->get('appDir') . '/storage/database/structure'
                    )
                )
            )
        );
        $this->getContainer()->addShared(
            EntityManager::class,
            fn() => new EntityManager(
                $this->getContainer()->get(Connection::class),
                new MemoryStorage(),
                [
                    'proxyClassBasePath' => $this->getContainer()->get('appDir') . '/storage/database/proxies'
                ]
            )
        );
    }

}