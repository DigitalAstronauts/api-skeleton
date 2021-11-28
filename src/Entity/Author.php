<?php
declare(strict_types=1);

namespace App\Entity;

use Rocket\Mapping as API;
use Warp\Mapping as DB;

#[API\Resource(path: "/author")]
#[DB\Entity]
#[DB\Table(name: "author")]
class Author
{
    #[DB\Id]
    #[API\Id]
    private int $id = 0;
    #[DB\Column(name: "name", type: "string")]
    private string $name = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
