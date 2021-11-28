<?php
declare(strict_types=1);

namespace App\Action\Shared;

use App\Service\Serializer;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rocket\Mapping\Resource;
use Rocket\Mapping\SubResource;
use Warp\EntityManager;

class CreateResource implements SharedActionInterface
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    public function __invoke(ServerRequestInterface $request, Resource|SubResource $mapping): ResponseInterface
    {
        $entity = Serializer::unserialize($request->getBody()->getContents(), $mapping->resourceClass);
        $this->entityManager->store($entity);
        return new JsonResponse([
            'ok' => true,
            'data' => json_decode(Serializer::serialize($entity), true)
        ]);
    }

}