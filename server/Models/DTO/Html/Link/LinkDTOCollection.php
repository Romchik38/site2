<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Html\Link;

use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Html\Link\LinkDTOInterface;

/**
 * A collection of LinkDTOInterface
 * 
 * @api
 */
abstract class LinkDTOCollection implements LinkDTOCollectionInterface
{
    /** @var array<string,LinkDTOInterface> */
    protected $hash = [];

    public function __construct(
        protected LinkDTOFactoryInterface $linkDTOFactory
    ) {}


    public function getLinksByPaths(array $paths): array
    {
        $dtos = [];
        $fetch = [];
        foreach ($paths as $path) {
            $dto = $this->hash[$this->serialize($path)] ?? null;
            if ($dto !== null) {
                $dtos[] = $dto;
            } else {
                $fetch[] = $path;
            }
        }
        if (count($fetch) > 0) {
            $fetched = $this->getFromRepository($fetch);
            array_merge($dtos, $fetched);
        }
        return $dtos;
    }

    public function getAllLinks(): array
    {
        return array_values($this->hash);
    }

    /** You can replace this with own serializator */
    protected function serialize(array $path): string
    {
        return serialize($path);
    }

    /** 
     * Implement your logic to get an array of LinkDTOs by provided paths
     * 
     *  1. Get Models from a Repository
     *  2. Create LinkDTOs
     *  3. Add them the hash
     *  4. Return an array with DTOs
     * 
     * @return LinkDTOInterface[]
     */
    abstract protected function getFromRepository(array $paths): array;
}
