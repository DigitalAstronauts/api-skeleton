<?php
declare(strict_types=1);

namespace App;

use App\Container\ContainerFactory;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Dotenv\Dotenv;

class Application
{
    private ContainerInterface $container;

    public function run(string $envPath = __DIR__ . '/../.env'): void
    {
        (new Dotenv())->load($envPath);
        $this->createContainer();
        $this->serve();
    }

    private function createContainer(): void
    {
        $this->container = (new ContainerFactory())->create();
    }

    public function serve(): void
    {
        $container = $this->container;
        /** @var ServerRequestInterface $request */
        $request = $container->get(ServerRequestInterface::class);
        /** @var Router $router */
        $router = $container->get(Router::class);

        try {
            $response = $router->dispatch($request);
        } catch (NotFoundException $exception) {
            $response = new JsonResponse(
                [
                    'ok' => false,
                    'message' => 'Resource was not found.',
                ],
                400
            );
        }
        (new SapiEmitter())->emit($response);
    }
}