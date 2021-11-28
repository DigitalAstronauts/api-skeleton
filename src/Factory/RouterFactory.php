<?php
declare(strict_types=1);

namespace App\Factory;

use App\Action\Shared\AsteriskResourceAction;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rocket\MappingFactory;

class RouterFactory
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    public function create(): Router
    {
        $factory = new MappingFactory();
        $resourceCollections = $factory->create(
            __DIR__ . '/../Entity',
            'App\\Entity'
        );

        $router = new Router();
        $handler = fn(ServerRequest $request) => new JsonResponse(['ok' => true]);
        foreach ($resourceCollections as $collection) {
            foreach ($collection->getResourceList() as $resource) {
                if($resource->method == '*') {
                    $handler = fn(ServerRequestInterface $request) => $this->container->get(AsteriskResourceAction::class)($request, $resource);
                }
                $route = $router->map(
                    $resource->method,
                    $resource->path,
                    $handler
                );
                foreach ($resource->middlewares as $middleware) {
                    $route->middleware(new $middleware());
                }
            }
            foreach ($collection->getSubResourceList() as $subResource) {

                $route = $router->map(
                    $subResource->method,
                    rtrim(sprintf('%s/{%s}/%s', $subResource->parentPath, $collection->getId()->name, $subResource->path), '/'),
                    $handler
                );
                foreach ($subResource->middlewares as $middleware) {
                    $route->middleware(new $middleware());
                }
            }
        }
        return $router;
    }
}