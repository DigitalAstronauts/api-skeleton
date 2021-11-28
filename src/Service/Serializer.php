<?php
declare(strict_types=1);

namespace App\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

class Serializer
{
    private static $instance;
    private $serializer;
    private $jsonContext;

    private function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->jsonContext = SerializationContext::create()->enableMaxDepthChecks();
    }

    public static function serialize($object): string
    {
        return self::instance()->serializeJson($object);
    }

    public static function unserialize(string $data, string $objectClass)
    {
        return self::instance()->serializer
            ->deserialize(
                $data,
                $objectClass,
                'json'
            );
    }

    private function serializeJson($object): string
    {
        return $this->serializer->serialize(
            $object,
            'json',
            $this->jsonContext
        );
    }

    private static function instance(): static
    {
        return self::$instance ?? self::$instance = new self();
    }
}