<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Views;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Api\Models\DTO\Views\SitemapDTOInterface;

class SitemapDTO extends DefaultViewDTO implements SitemapDTOInterface
{
    public function __construct(
        string $name,
        string $description,
        string $output
    ) {
        parent::__construct($name, $description);
        $this->data[SitemapDTOInterface::OUTPUT_FIELD] = $output;
    }

    public function getOutput(): string
    {
        return $this->data[SitemapDTOInterface::OUTPUT_FIELD];
    }
}
