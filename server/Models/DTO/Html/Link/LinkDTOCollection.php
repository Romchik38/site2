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

    public function getLinkByPath(array $path): LinkDTOInterface|null
    {
        return $this->hash[$this->serialize($path)] ?? null;
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
}
