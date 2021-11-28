<?php
declare(strict_types=1);

namespace App\Action\Shared;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rocket\Mapping\Resource;
use Rocket\Mapping\SubResource;

interface SharedActionInterface
{
    public function __invoke(ServerRequestInterface $request, Resource | SubResource $mapping): ResponseInterface;
}
