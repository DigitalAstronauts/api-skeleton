<?php

use GuzzleHttp\Psr7\Response;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Router;
use Micomare\Api\Bootstrap;
use Psr\Http\Message\ServerRequestInterface;

require __DIR__ . '/../vendor/autoload.php';

(new \App\Application())
    ->run(
        __DIR__ . '/../.env'
    );
