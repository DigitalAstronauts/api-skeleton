<?php
declare(strict_types=1);

namespace App\Container;

use League\Container\Container;
use League\Container\ReflectionContainer;
use App\Container\Provider;
use Psr\Container\ContainerInterface;

class ContainerFactory
{
    private const PROVIDERS = [
        Provider\HttpProvider::class,
        Provider\DatabaseProvider::class,
    ];

    public function create(): ContainerInterface
    {
        $container = new Container();
        $container->addShared(ContainerInterface::class, $container);
        $container->addShared('appDir', __DIR__ . '/../..');
        $container->delegate(new ReflectionContainer());
        foreach (self::PROVIDERS as $providerClass) {
            $container->addServiceProvider($container->get($providerClass));
        }
        return $container;
    }
}
