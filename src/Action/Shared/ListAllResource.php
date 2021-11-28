<?php
declare(strict_types=1);

namespace App\Action\Shared;

use App\Service\Serializer;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rocket\Mapping\Resource;
use Rocket\Mapping\SubResource;
use Warp\EntityManager;

class ListAllResource implements SharedActionInterface
{
    public function __construct(
        private EntityManager $entityManager
    )
    {
    }

    public function __invoke(ServerRequestInterface $request, Resource|SubResource $mapping): ResponseInterface
    {
        $repository = $this->entityManager->getRepository($mapping->resourceClass);
        $where = [];
        // TODO: implement filtering
        $iterator = $repository->find($where);
        return new Response(
            200,
            [
                'Content-Type' => 'application/json'
            ],
            Serializer::serialize(iterator_to_array($iterator))
        );
    }

}