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

    public function getLinkByUrl(string $url): LinkDTOInterface|null
    {
        return $this->hash[$url] ?? null;
    }

    public function getAllLinks(): array
    {
        return $this->hash;
    }
}
