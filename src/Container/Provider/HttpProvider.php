<?php
declare(strict_types=1);

namespace App\Container\Provider;

use App\Factory\RouterFactory;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;

class HttpProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $map = [
            Router::class,
            ServerRequestInterface::class,
        ];
        return in_array($id, $map);
    }

    public function register(): void
    {
        $this->getContainer()->addShared(
            Router::class,
            fn() => $this->getContainer()->get(RouterFactory::class)->create()
        );
        $this->getContainer()->addShared(
            ServerRequestInterface::class,
            fn() => ServerRequestFactory::fromGlobals()
        );
    }

}