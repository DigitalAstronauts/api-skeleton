<?php
declare(strict_types=1);

namespace App\Action\Shared;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rocket\Mapping\Resource;
use Rocket\Mapping\SubResource;

class AsteriskResourceAction
{
    public function __construct(
        private ListAllResource $listAllResource,
        private CreateResource $createResource
    )
    {
    }

    public function __invoke(
        ServerRequestInterface $request,
        Resource | SubResource $mapping
    ): ResponseInterface
    {
        return match ($request->getMethod()) {
            'GET' => ($this->listAllResource)($request, $mapping),
            'POST' => ($this->createResource)($request, $mapping),
        };
    }
}